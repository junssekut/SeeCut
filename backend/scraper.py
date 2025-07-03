import json
import os # Keep os for file path management of JSON output, but image dir calls removed
import requests # Still used for API calls, but not for image content download
from serpapi import GoogleSearch
import time
import string
import sys
from urllib.parse import urlparse, unquote # No longer strictly needed for image filenames, but harmless

# --- Configuration ---
API_KEY = "2eaac37157d3fd473f87995dd4392361bed790b98268cc49c0b96faefe826422" # Replace with your actual SerpApi API key

LATITUDE = -6.566583457716657
LONGITUDE = 106.86446469132996
ZOOM_LEVEL = 14

OUTPUT_JSON_FILENAME = "barbershops_data_with_image_links.json" # MODIFIED: New filename to reflect image links

# --- Pagination Constants ---
MAX_BARBERSHOPS_TO_FETCH = 20
SERPAPI_MAPS_PAGE_SIZE = 20 
# --- End Pagination Constants ---

# --- NEW FEATURE: Consecutive Empty Searches Limit ---
CONSECUTIVE_EMPTY_SEARCH_LIMIT = 5 # Break after this many consecutive empty pages
# --- End NEW FEATURE ---

# --- Main Logic for Scraping ---

# NEW FEATURE: Load existing data if file exists
barbershops_with_details = []
existing_barbershop_data_ids = set() # To track data_id for de-duplication

if os.path.exists(OUTPUT_JSON_FILENAME):
    print(f"Loading existing data from {OUTPUT_JSON_FILENAME}...")
    try:
        with open(OUTPUT_JSON_FILENAME, "r", encoding="utf-8") as f:
            barbershops_with_details = json.load(f)
        
        # Populate the set of existing IDs
        for shop in barbershops_with_details:
            if "data_id" in shop and shop["data_id"]:
                existing_barbershop_data_ids.add(shop["data_id"])
        print(f"Loaded {len(barbershops_with_details)} existing barbershops. {len(existing_barbershop_data_ids)} unique IDs.")
    except json.JSONDecodeError as e:
        print(f"Error decoding existing JSON file: {e}. Starting with an empty list.")
        barbershops_with_details = []
        existing_barbershop_data_ids = set()
    except Exception as e:
        print(f"An unexpected error occurred loading existing file: {e}. Starting with an empty list.")
        barbershops_with_details = []
        existing_barbershop_data_ids = set()
else:
    print(f"'{OUTPUT_JSON_FILENAME}' not found. Starting with an empty list of barbershops.")

# --- Pagination Variables (re-initialized or kept for new searches) ---
start_offset = 0
total_newly_fetched_barbershops_this_run = 0 
# --- End NEW FEATURE ---
# NEW FEATURE: Counter for consecutive empty searches
consecutive_empty_searches_count = 0 
# --- End Pagination Variables ---

# NEW FEATURE: Function to save data (to avoid code duplication)
def save_data(data_list, filename):
    if data_list:
        try:
            with open(filename, "w", encoding="utf-8") as f:
                json.dump(data_list, f, indent=4, ensure_ascii=False)
            print(f"\nAll data ({len(data_list)} unique barbershops total) successfully saved to {filename}")
        except Exception as e:
            print(f"\nERROR: Failed to save data to {filename}: {e}")
    else:
        print(f"\nNo barbershop data to save to {filename}.")
# --- End NEW FEATURE ---

try:
    # --- Pagination Loop ---
    while total_newly_fetched_barbershops_this_run < MAX_BARBERSHOPS_TO_FETCH: 
        if consecutive_empty_searches_count >= CONSECUTIVE_EMPTY_SEARCH_LIMIT:
            print(f"Reached {CONSECUTIVE_EMPTY_SEARCH_LIMIT} consecutive empty search results. Stopping pagination.")
            break

        main_search_params = {
            "engine": "google_maps",
            "q": "barber",
            "ll": f"@{LATITUDE},{LONGITUDE},{ZOOM_LEVEL}z",
            "type": "search",
            "api_key": API_KEY,
            "start": start_offset
        }

        print(f"\nPhase 1: Searching for barbershops near {LATITUDE}, {LONGITUDE} (offset: {start_offset})...")
        
        search = GoogleSearch(main_search_params)
        results = search.get_dict()

        if "local_results" in results:
            current_page_barbershops = results["local_results"]
            
            if not current_page_barbershops:
                print(f"No more barbershops found from offset {start_offset}. Stopping pagination.")
                # NEW FEATURE: Increment consecutive empty searches counter
                consecutive_empty_searches_count += 1 
                # MODIFIED: Skip to next iteration to allow check for CONSECUTIVE_EMPTY_SEARCH_LIMIT
                start_offset += SERPAPI_MAPS_PAGE_SIZE # Still increment offset
                time.sleep(1) # Still delay
                continue # Skip processing this page, go to next loop iteration
            else:
                # NEW FEATURE: Reset counter if results are found
                consecutive_empty_searches_count = 0 

            print(f"Found {len(current_page_barbershops)} barbershops on this page. Total unique in data: {len(existing_barbershop_data_ids)}") 

            for i, barbershop in enumerate(current_page_barbershops):
                current_data_id = barbershop.get("data_id")

                # Skip if already processed (duplicate from loaded data)
                if current_data_id and current_data_id in existing_barbershop_data_ids:
                    print(f"  Skipping '{barbershop.get('title', 'Unknown Barbershop')}' (ID: {current_data_id}) - already exists in loaded data.")
                    continue # Skip to next barbershop in current_page_barbershops

                # MODIFIED: Check against MAX_BARBERSHOPS_TO_FETCH for newly added barbershops
                if total_newly_fetched_barbershops_this_run >= MAX_BARBERSHOPS_TO_FETCH: 
                    print(f"Reached maximum desired NEW barbershops ({MAX_BARBERSHOPS_TO_FETCH}). Stopping.")
                    break 

                barbershop_name = barbershop.get("title", "Unknown Barbershop")
                print(f"\nProcessing NEW barbershop {total_newly_fetched_barbershops_this_run + 1}: {barbershop_name}") 

                # Extract GPS coordinates
                gps_lat = None
                gps_lon = None
                if "gps_coordinates" in barbershop:
                    gps_lat = barbershop["gps_coordinates"].get("latitude")
                    gps_lon = barbershop["gps_coordinates"].get("longitude")

                # Extract opening hours
                opening_hours = None
                if "operating_hours" in barbershop and barbershop["operating_hours"]:
                    opening_hours = [f"{day.capitalize()}: {time_str}" 
                                     for day, time_str in barbershop["operating_hours"].items()]

                place_link = None
                place_id = barbershop.get("place_id")

                barbershop_info = {
                    "name": string.capwords(barbershop_name),
                    "address": string.capwords(barbershop.get("address")),
                    "phone": barbershop.get("phone"),
                    "rating": barbershop.get("rating"),
                    "reviews_count": barbershop.get("reviews"),
                    "website": barbershop.get("website"),
                    "data_id": current_data_id,

                    "latitude": gps_lat,
                    "longitude": gps_lon,
                    "open_hours": opening_hours,
                    "description": barbershop.get("description"),
                    "place_id": place_id,
                    
                    "main_thumbnail_url": None,
                    "all_photos_urls": [],     
                    "reviews_data": [],
                }
            
                main_thumb_url = barbershop.get("thumbnail")
                if main_thumb_url:
                    barbershop_info["main_thumbnail_url"] = main_thumb_url

                # --- Phase 2: Fetching additional photos using Google Maps Photos API ---
                if current_data_id:
                    photos_params = {
                        "engine": "google_maps_photos",
                        "data_id": current_data_id,
                        "api_key": API_KEY
                    }
                    try:
                        photos_search = GoogleSearch(photos_params)
                        photos_results = photos_search.get_dict()

                        if "photos" in photos_results:
                            for idx, photo in enumerate(photos_results["photos"]):
                                photo_url = photo.get("image") 
                                if photo_url:
                                    # MODIFIED: Append URL directly, no download
                                    barbershop_info["all_photos_urls"].append(photo_url) 
                                # time.sleep(0.1) # REMOVED: No sleep for simple URL assignment
                        # else: print for no photos
                    except Exception as e:
                        print(f"  Error fetching general photos for {barbershop_name}: {e}")
                    time.sleep(0.5)

                # --- Phase 3: Fetching review images AND review details using Google Maps Reviews API ---
                if current_data_id:
                    reviews_params = {
                        "engine": "google_maps_reviews",
                        "data_id": current_data_id,
                        "api_key": API_KEY,
                        "sort_by": "newestFirst",
                    }
                    try:
                        reviews_search = GoogleSearch(reviews_params)
                        reviews_results = reviews_search.get_dict()

                        if "reviews" in reviews_results:
                            for review in reviews_results["reviews"]:
                                review_details = {
                                    "user_name": string.capwords(review.get("user", {}).get("name")),
                                    "contributor_id": review.get("user", {}).get("contributor_id"),
                                    "rating": review.get("rating"),
                                    "link": review.get("link"),
                                    "snippet": review.get("snippet"),
                                    "iso_date": review.get("iso_date"),
                                    "review_images_urls": [], # MODIFIED: Changed name to reflect URLs, not paths
                                }

                                if "images" in review and review["images"]:
                                    for img_url_str in review["images"]:
                                        if img_url_str:
                                            # MODIFIED: Append URL directly, no download
                                            review_details["review_images_urls"].append(img_url_str) 
                                    # time.sleep(0.1) # REMOVED: No sleep for simple URL assignment

                                barbershop_info["reviews_data"].append(review_details)
                                
                            if not barbershop_info["reviews_data"]:
                                pass
                        # else: print for no reviews
                    except Exception as e:
                        print(f"  Error fetching reviews for {barbershop_name}: {e}")
                    time.sleep(0.5)

                barbershops_with_details.append(barbershop_info) # Append the new barbershop info
                existing_barbershop_data_ids.add(current_data_id) # Add new ID to the set
                total_newly_fetched_barbershops_this_run += 1 # Increment only for newly added

            # Check if we broke out of inner loop due to MAX_BARBERSHOPS_TO_FETCH
            if total_newly_fetched_barbershops_this_run >= MAX_BARBERSHOPS_TO_FETCH:
                break 

            # Pagination control after processing a page
            if len(current_page_barbershops) < SERPAPI_MAPS_PAGE_SIZE:
                print(f"Fewer than {SERPAPI_MAPS_PAGE_SIZE} results on this page ({len(current_page_barbershops)}). Likely reached end of results. Stopping pagination.")
                break

            start_offset += SERPAPI_MAPS_PAGE_SIZE
            time.sleep(1)

    else:
        print("No 'local_results' found in the SerpApi response. Check your query or API key.")
        if "error" in results:
            print(f"SerpApi Error: {results['error']}")
    
    # MODIFIED: Final message if no new data was fetched AND no data was loaded
    if total_newly_fetched_barbershops_this_run == 0 and not barbershops_with_details: 
        print(f"No new barbershop data was fetched and no existing data was loaded. Check search parameters or file.")

# NEW FEATURE: Catch KeyboardInterrupt and save data
except KeyboardInterrupt:
    print("\n\nCtrl+C detected! Attempting to save current data before exiting...")
    save_data(barbershops_with_details, OUTPUT_JSON_FILENAME)
    sys.exit(0) # Exit cleanly after saving
# --- End NEW FEATURE ---

except Exception as e:
    print(f"An unexpected error occurred during the main search loop: {e}")
    print("Please ensure your API_KEY is correct and you have an active internet connection.")

save_data(barbershops_with_details, OUTPUT_JSON_FILENAME)