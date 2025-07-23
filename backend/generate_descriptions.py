#!/usr/bin/env python3
"""
Generate contextual descriptions for barbershops based on available data.
This script analyzes existing barbershop data to create meaningful descriptions
rather than random ones.
"""

import json
import random
import re
from typing import Dict, List, Any

def analyze_location_context(address: str) -> Dict[str, str]:
    """Extract location context from address."""
    context = {
        'area_type': 'urban',
        'region': 'general',
        'sophistication': 'standard'
    }
    
    address_lower = address.lower()
    
    # Determine area type
    if any(term in address_lower for term in ['mall', 'plaza', 'center', 'square']):
        context['area_type'] = 'commercial'
    elif any(term in address_lower for term in ['village', 'kampung', 'desa']):
        context['area_type'] = 'residential'
    elif any(term in address_lower for term in ['jakarta', 'bandung', 'surabaya', 'medan']):
        context['area_type'] = 'metropolitan'
    
    # Determine region sophistication
    if any(term in address_lower for term in ['central', 'pusat', 'utama', 'premium']):
        context['sophistication'] = 'premium'
    elif any(term in address_lower for term in ['south', 'north', 'barat', 'timur']):
        context['sophistication'] = 'established'
    
    return context

def analyze_name_style(name: str) -> Dict[str, str]:
    """Analyze barbershop name to understand style and target audience."""
    style_info = {
        'style': 'classic',
        'target': 'general',
        'vibe': 'traditional'
    }
    
    name_lower = name.lower()
    
    # Modern/trendy indicators
    if any(term in name_lower for term in ['modern', 'studio', 'lounge', 'salon', 'gallery']):
        style_info['style'] = 'modern'
        style_info['vibe'] = 'contemporary'
    
    # Premium indicators  
    if any(term in name_lower for term in ['royal', 'king', 'premium', 'exclusive', 'luxury']):
        style_info['target'] = 'premium'
        style_info['vibe'] = 'upscale'
    
    # Traditional indicators
    if any(term in name_lower for term in ['traditional', 'klasik', 'heritage', 'vintage']):
        style_info['style'] = 'traditional'
        style_info['vibe'] = 'classic'
    
    # Family/community indicators
    if any(term in name_lower for term in ['family', 'keluarga', 'community', 'neighborhood']):
        style_info['target'] = 'family'
        style_info['vibe'] = 'friendly'
    
    return style_info

def analyze_service_level(rating: float, reviews_count: int, hours: List[str]) -> str:
    """Determine service level based on rating, reviews, and operating hours."""
    # Handle None values
    rating = rating or 0.0
    reviews_count = reviews_count or 0
    
    if rating >= 4.7 and reviews_count >= 50:
        return 'excellent'
    elif rating >= 4.5 and reviews_count >= 20:
        return 'high_quality'
    elif rating >= 4.2:
        return 'reliable'
    else:
        return 'standard'

def get_operating_hours_context(hours: List[str]) -> Dict[str, Any]:
    """Analyze operating hours to understand service approach."""
    if not hours:
        return {'convenience': 'standard', 'dedication': 'normal'}
    
    # Count days open
    days_open = len([h for h in hours if 'Closed' not in h and h])
    
    # Check for extended hours (past 8 PM or before 8 AM)
    extended_hours = any(
        '9 PM' in hour or '10 PM' in hour or '11 PM' in hour or 
        '7 AM' in hour or '6 AM' in hour 
        for hour in hours
    )
    
    context = {
        'convenience': 'high' if extended_hours or days_open == 7 else 'standard',
        'dedication': 'high' if days_open >= 6 else 'normal'
    }
    
    return context

def generate_description_templates() -> Dict[str, List[str]]:
    """Generate description templates for different contexts."""
    return {
        'premium_modern': [
            "A sophisticated barbershop offering premium grooming services with modern styling techniques and attention to detail.",
            "Contemporary barbershop specializing in precision cuts and premium grooming experiences for the modern gentleman.",
            "Upscale grooming destination featuring skilled barbers and a refined atmosphere for discerning clients."
        ],
        'traditional_classic': [
            "Traditional barbershop providing classic cuts and time-honored grooming services with experienced craftsmanship.",
            "Established barbershop offering authentic styling and traditional barbering techniques in a classic setting.",
            "Classic barbershop experience featuring traditional cuts, hot towel shaves, and old-school barbering excellence."
        ],
        'family_friendly': [
            "Family-friendly neighborhood barbershop welcoming clients of all ages with affordable and reliable grooming services.",
            "Community-focused barbershop providing quality cuts and friendly service for the whole family.",
            "Local barbershop serving the community with consistent quality and a welcoming atmosphere for everyone."
        ],
        'convenient_accessible': [
            "Convenient barbershop with flexible hours and professional service for busy professionals and locals alike.",
            "Accessible neighborhood barbershop offering quality cuts with convenient scheduling and reliable service.",
            "Well-located barbershop providing professional grooming services with convenient hours for working professionals."
        ],
        'high_rated_quality': [
            "Highly-rated barbershop known for exceptional service, skilled craftsmanship, and customer satisfaction.",
            "Top-rated grooming destination praised for consistent quality and professional expertise by loyal customers.",
            "Excellence in barbering with a proven track record of satisfied customers and superior grooming services."
        ]
    }

def select_appropriate_template(barbershop: Dict[str, Any]) -> str:
    """Select the most appropriate description template based on barbershop data."""
    
    # Analyze various aspects
    location_ctx = analyze_location_context(barbershop.get('address', ''))
    name_style = analyze_name_style(barbershop.get('name', ''))
    service_level = analyze_service_level(
        barbershop.get('rating', 0), 
        barbershop.get('reviews_count', 0), 
        barbershop.get('open_hours', [])
    )
    hours_ctx = get_operating_hours_context(barbershop.get('open_hours', []))
    
    templates = generate_description_templates()
    
    # Decision logic for template selection
    rating = barbershop.get('rating') or 0.0
    reviews_count = barbershop.get('reviews_count') or 0
    
    # High quality establishments
    if rating >= 4.6 and reviews_count >= 30:
        return random.choice(templates['high_rated_quality'])
    
    # Premium/upscale based on name and location
    elif (name_style['target'] == 'premium' or name_style['vibe'] == 'upscale' or 
          location_ctx['sophistication'] == 'premium'):
        return random.choice(templates['premium_modern'])
    
    # Traditional style
    elif name_style['style'] == 'traditional' or name_style['vibe'] == 'classic':
        return random.choice(templates['traditional_classic'])
    
    # Family-oriented
    elif name_style['target'] == 'family' or name_style['vibe'] == 'friendly':
        return random.choice(templates['family_friendly'])
    
    # Convenient/accessible (extended hours, good location)
    elif hours_ctx['convenience'] == 'high' or location_ctx['area_type'] == 'commercial':
        return random.choice(templates['convenient_accessible'])
    
    # Default to family-friendly for general appeal
    else:
        return random.choice(templates['family_friendly'])

def generate_contextual_descriptions(input_file: str, output_file: str):
    """Generate contextual descriptions for all barbershops."""
    
    with open(input_file, 'r', encoding='utf-8') as f:
        barbershops = json.load(f)
    
    print(f"Processing {len(barbershops)} barbershops...")
    
    for i, barbershop in enumerate(barbershops):
        if barbershop.get('description') is None:
            description = select_appropriate_template(barbershop)
            barbershop['description'] = description
            
            if (i + 1) % 10 == 0:
                print(f"Processed {i + 1} barbershops...")
    
    # Save updated data
    with open(output_file, 'w', encoding='utf-8') as f:
        json.dump(barbershops, f, indent=2, ensure_ascii=False)
    
    print(f"Updated barbershop data saved to: {output_file}")
    
    # Show some examples
    print("\nExample generated descriptions:")
    for i in range(min(5, len(barbershops))):
        print(f"\n{barbershops[i]['name']}:")
        print(f"Rating: {barbershops[i]['rating']} ({barbershops[i]['reviews_count']} reviews)")
        print(f"Description: {barbershops[i]['description']}")

if __name__ == "__main__":
    input_file = "barbershops_data_with_image_links.json"
    output_file = "barbershops_data_with_descriptions.json"
    
    generate_contextual_descriptions(input_file, output_file)
