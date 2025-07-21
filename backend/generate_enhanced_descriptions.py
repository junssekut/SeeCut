#!/usr/bin/env python3
"""
Enhanced description generator with more variety and personalization.
"""

import json
import random
import re
from typing import Dict, List, Any

# Expanded templates for more variety
DESCRIPTION_TEMPLATES = {
    'excellent_service': [
        "Exceptional barbershop renowned for its meticulous attention to detail and outstanding customer service, consistently earning rave reviews from satisfied clients.",
        "Premier grooming establishment delivering excellence in every cut, with skilled barbers who take pride in their craft and customer satisfaction.",
        "Top-tier barbershop experience featuring master barbers and a commitment to perfection that keeps customers returning.",
        "Award-worthy barbershop known throughout the community for superior skill, professionalism, and consistently exceptional results."
    ],
    'high_quality': [
        "Professional barbershop offering high-quality cuts and grooming services with attention to modern styling trends.",
        "Well-regarded grooming destination providing expert barbering with a focus on precision and customer care.",
        "Quality-focused barbershop where experienced barbers deliver reliable, professional grooming services.",
        "Trusted barbershop combining traditional techniques with contemporary styling for discerning clients."
    ],
    'community_focused': [
        "Beloved neighborhood barbershop serving the local community with friendly service and dependable grooming expertise.",
        "Community cornerstone providing quality barbering services with a personal touch and welcoming atmosphere.",
        "Local favorite barbershop where neighbors gather for great conversation and consistently good haircuts.",
        "Neighborhood institution offering reliable grooming services with the warmth and familiarity of a community gathering place."
    ],
    'convenient_professional': [
        "Conveniently located barbershop catering to busy professionals with efficient service and flexible scheduling options.",
        "Accessible grooming destination offering professional service designed to accommodate your schedule and lifestyle.",
        "Strategic location meets professional grooming with this well-positioned barbershop serving working professionals.",
        "Time-conscious barbershop providing quality cuts without the wait, perfect for busy schedules."
    ],
    'traditional_classic': [
        "Authentic barbershop experience featuring time-honored techniques, classic cuts, and the timeless art of traditional grooming.",
        "Classic barbering establishment preserving the heritage of traditional grooming with skilled craftsmanship and old-school charm.",
        "Traditional barbershop offering genuine vintage styling and classic grooming services in an authentic setting.",
        "Heritage barbershop maintaining the classic standards of traditional grooming with experienced, old-school barbers."
    ],
    'modern_stylish': [
        "Contemporary barbershop specializing in modern cuts and trending styles with a fresh approach to men's grooming.",
        "Stylish grooming studio offering the latest in barbering techniques and contemporary hair styling.",
        "Modern barbershop destination featuring current trends, innovative styling, and a contemporary atmosphere.",
        "Trendy grooming establishment where modern techniques meet creative styling for today's fashion-conscious client."
    ],
    'versatile_general': [
        "Versatile barbershop accommodating diverse styling preferences with skilled barbers and a welcoming environment.",
        "Full-service barbershop offering a comprehensive range of grooming services for clients of all ages and styles.",
        "Adaptable grooming establishment providing personalized service tailored to each client's individual preferences.",
        "All-around barbershop delivering quality grooming services with the flexibility to meet various styling needs."
    ]
}

def get_location_insights(address: str) -> Dict[str, Any]:
    """Extract detailed insights from address."""
    insights = {
        'urban_level': 'suburban',
        'commercial_area': False,
        'upscale_area': False,
        'accessibility': 'standard'
    }
    
    address_lower = address.lower()
    
    # Check for commercial indicators
    commercial_keywords = ['mall', 'plaza', 'center', 'square', 'complex', 'tower']
    if any(kw in address_lower for kw in commercial_keywords):
        insights['commercial_area'] = True
        insights['accessibility'] = 'high'
    
    # Check for upscale area indicators
    upscale_keywords = ['central', 'premium', 'grand', 'royal', 'executive', 'luxury']
    if any(kw in address_lower for kw in upscale_keywords):
        insights['upscale_area'] = True
    
    # Urban level detection
    major_cities = ['jakarta', 'bandung', 'surabaya', 'medan', 'semarang', 'palembang']
    if any(city in address_lower for city in major_cities):
        insights['urban_level'] = 'metropolitan'
    elif any(term in address_lower for term in ['city', 'kota']):
        insights['urban_level'] = 'urban'
    
    return insights

def analyze_business_name(name: str) -> Dict[str, Any]:
    """Comprehensive analysis of business name."""
    analysis = {
        'style_indicator': 'general',
        'target_market': 'general',
        'brand_personality': 'professional',
        'modernity_level': 'standard'
    }
    
    name_lower = name.lower()
    
    # Style indicators
    traditional_terms = ['classic', 'traditional', 'heritage', 'vintage', 'old', 'original']
    modern_terms = ['modern', 'contemporary', 'new', 'studio', 'lounge', 'gallery', 'space']
    premium_terms = ['premium', 'luxury', 'royal', 'king', 'master', 'exclusive', 'elite']
    
    if any(term in name_lower for term in traditional_terms):
        analysis['style_indicator'] = 'traditional'
        analysis['modernity_level'] = 'classic'
    elif any(term in name_lower for term in modern_terms):
        analysis['style_indicator'] = 'modern'
        analysis['modernity_level'] = 'contemporary'
    elif any(term in name_lower for term in premium_terms):
        analysis['style_indicator'] = 'premium'
        analysis['target_market'] = 'upscale'
    
    # Brand personality
    friendly_terms = ['family', 'community', 'neighborhood', 'local', 'friendly']
    if any(term in name_lower for term in friendly_terms):
        analysis['brand_personality'] = 'friendly'
        analysis['target_market'] = 'community'
    
    return analysis

def evaluate_service_quality(rating: float, review_count: int) -> str:
    """Evaluate service quality tier."""
    rating = rating or 0.0
    review_count = review_count or 0
    
    if rating >= 4.8 and review_count >= 20:
        return 'exceptional'
    elif rating >= 4.6 and review_count >= 15:
        return 'excellent'
    elif rating >= 4.4 and review_count >= 10:
        return 'high_quality'
    elif rating >= 4.0:
        return 'good'
    else:
        return 'standard'

def select_optimal_description(barbershop_data: Dict[str, Any]) -> str:
    """Select the most contextually appropriate description."""
    
    # Extract and analyze data
    name = barbershop_data.get('name', '')
    address = barbershop_data.get('address', '')
    rating = barbershop_data.get('rating') or 0.0
    review_count = barbershop_data.get('reviews_count') or 0
    
    # Perform analysis
    location_insights = get_location_insights(address)
    name_analysis = analyze_business_name(name)
    quality_tier = evaluate_service_quality(rating, review_count)
    
    # Template selection logic with priority order
    
    # 1. Exceptional quality gets priority
    if quality_tier == 'exceptional':
        return random.choice(DESCRIPTION_TEMPLATES['excellent_service'])
    
    # 2. Premium/upscale establishments
    elif (name_analysis['target_market'] == 'upscale' or 
          name_analysis['style_indicator'] == 'premium' or
          location_insights['upscale_area']):
        if quality_tier in ['excellent', 'high_quality']:
            return random.choice(DESCRIPTION_TEMPLATES['excellent_service'])
        else:
            return random.choice(DESCRIPTION_TEMPLATES['modern_stylish'])
    
    # 3. Excellent quality establishments
    elif quality_tier == 'excellent':
        return random.choice(DESCRIPTION_TEMPLATES['excellent_service'])
    
    # 4. Traditional style establishments
    elif name_analysis['style_indicator'] == 'traditional':
        return random.choice(DESCRIPTION_TEMPLATES['traditional_classic'])
    
    # 5. Modern style establishments
    elif name_analysis['style_indicator'] == 'modern':
        return random.choice(DESCRIPTION_TEMPLATES['modern_stylish'])
    
    # 6. Community-focused establishments
    elif name_analysis['brand_personality'] == 'friendly':
        return random.choice(DESCRIPTION_TEMPLATES['community_focused'])
    
    # 7. High-quality establishments
    elif quality_tier == 'high_quality':
        return random.choice(DESCRIPTION_TEMPLATES['high_quality'])
    
    # 8. Commercial/convenient locations
    elif location_insights['commercial_area'] or location_insights['accessibility'] == 'high':
        return random.choice(DESCRIPTION_TEMPLATES['convenient_professional'])
    
    # 9. Default to versatile/general
    else:
        return random.choice(DESCRIPTION_TEMPLATES['versatile_general'])

def generate_enhanced_descriptions(input_file: str, output_file: str):
    """Generate enhanced contextual descriptions."""
    
    with open(input_file, 'r', encoding='utf-8') as f:
        barbershops = json.load(f)
    
    print(f"Generating enhanced descriptions for {len(barbershops)} barbershops...")
    
    # Track variety for quality assurance
    used_descriptions = {}
    
    for i, barbershop in enumerate(barbershops):
        description = select_optimal_description(barbershop)
        barbershop['description'] = description
        
        # Track description usage for variety analysis
        used_descriptions[description] = used_descriptions.get(description, 0) + 1
        
        if (i + 1) % 15 == 0:
            print(f"Processed {i + 1} barbershops...")
    
    # Save the enhanced data
    with open(output_file, 'w', encoding='utf-8') as f:
        json.dump(barbershops, f, indent=2, ensure_ascii=False)
    
    print(f"Enhanced descriptions saved to: {output_file}")
    
    # Show variety statistics
    print(f"\nDescription variety: {len(used_descriptions)} unique descriptions generated")
    print(f"Average reuse: {sum(used_descriptions.values()) / len(used_descriptions):.1f} times per description")
    
    # Show some examples categorized by quality
    print("\n=== SAMPLE ENHANCED DESCRIPTIONS ===")
    
    # Group by rating for examples
    high_rated = [b for b in barbershops if (b.get('rating') or 0) >= 4.5]
    medium_rated = [b for b in barbershops if 4.0 <= (b.get('rating') or 0) < 4.5]
    
    if high_rated:
        print(f"\n🌟 HIGH-RATED EXAMPLE ({high_rated[0]['name']}):")
        print(f"Rating: {high_rated[0]['rating']} ({high_rated[0]['reviews_count']} reviews)")
        print(f"Description: {high_rated[0]['description']}")
    
    if medium_rated:
        print(f"\n⭐ STANDARD EXAMPLE ({medium_rated[0]['name']}):")
        print(f"Rating: {medium_rated[0]['rating']} ({medium_rated[0]['reviews_count']} reviews)")
        print(f"Description: {medium_rated[0]['description']}")

if __name__ == "__main__":
    input_file = "barbershops_data_with_image_links.json"
    output_file = "barbershops_enhanced_descriptions.json"
    
    generate_enhanced_descriptions(input_file, output_file)
