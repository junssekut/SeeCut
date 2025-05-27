import os
import re
from pathlib import Path

def extract_font_info(filename):
    """Extract font family and style from filename"""
    # Remove file extension
    name_without_ext = Path(filename).stem
    
    # Common font weight/style patterns
    style_patterns = {
        'thin': 100,
        'extralight': 200,
        'ultralight': 200,
        'light': 300,
        'regular': 400,
        'normal': 400,
        'medium': 500,
        'semibold': 600,
        'demibold': 600,
        'bold': 700,
        'extrabold': 800,
        'ultrabold': 800,
        'black': 900,
        'heavy': 900
    }
    
    # Extract font family (everything before the first dash or weight indicator)
    # Handle patterns like "Poppins-Bold", "Kuunari-BoldCondensed", etc.
    parts = re.split(r'[-_\s]', name_without_ext)
    font_family = parts[0]
    
    # Join remaining parts to analyze style
    style_part = '-'.join(parts[1:]).lower() if len(parts) > 1 else 'regular'
    
    # Determine font weight
    font_weight = 400  # default
    font_style = 'normal'
    
    # Check for italic
    if 'italic' in style_part:
        font_style = 'italic'
        style_part = style_part.replace('italic', '')
    
    # Check for weights
    for weight_name, weight_value in style_patterns.items():
        if weight_name in style_part:
            font_weight = weight_value
            break
    
    return font_family, font_weight, font_style

def get_font_format(file_extension):
    """Get CSS format string based on file extension"""
    format_map = {
        '.ttf': 'truetype',
        '.otf': 'opentype',
        '.woff': 'woff',
        '.woff2': 'woff2',
        '.eot': 'embedded-opentype'
    }
    return format_map.get(file_extension.lower(), 'truetype')

def generate_font_css(directory_path='.'):
    """Generate CSS @font-face declarations and Tailwind config"""
    
    # Supported font file extensions
    font_extensions = {'.ttf', '.otf', '.woff', '.woff2', '.eot'}
    
    # Find all font files
    font_files = []
    for file in os.listdir(directory_path):
        if Path(file).suffix.lower() in font_extensions:
            font_files.append(file)
    
    if not font_files:
        print("No font files found in the current directory.")
        return
    
    # Group fonts by family
    font_families = {}
    
    for font_file in font_files:
        family, weight, style = extract_font_info(font_file)
        
        if family not in font_families:
            font_families[family] = []
        
        font_families[family].append({
            'file': font_file,
            'weight': weight,
            'style': style,
            'format': get_font_format(Path(font_file).suffix)
        })
    
    # Generate CSS @font-face declarations
    css_output = []
    css_output.append("/* CSS @font-face declarations */")
    
    for family, fonts in font_families.items():
        for font in fonts:
            css_output.append(f"""
@font-face {{
    font-family: '{family}';
    font-weight: {font['weight']};
    font-style: {font['style']};
    src: url('/public/assets/fonts/{family}/{font['file']}') format('{font['format']}');
}}""")
    
    # Generate Tailwind CSS fontFamily config
    css_output.append("\n\n/* Tailwind CSS fontFamily configuration */")
    css_output.append("fontFamily: {")
    
    for family in font_families.keys():
        css_output.append(f"    '{family}': ['{family}'],")
    
    css_output.append("},")
    
    # Print results
    result = '\n'.join(css_output)
    print(result)
    
    # Also save to file
    with open('font-declarations.css', 'w') as f:
        f.write(result)
    
    print(f"\n\nFound {len(font_files)} font files from {len(font_families)} font families.")
    print("Output saved to 'font-declarations.css'")
    
    return result

if __name__ == "__main__":
    print("Font CSS Generator")
    print("=" * 50)
    
    # You can specify a different directory path here if needed
    directory = input("Enter directory path (press Enter for current directory): ").strip()
    if not directory:
        directory = "."
    
    if not os.path.exists(directory):
        print(f"Directory '{directory}' does not exist.")
    else:
        generate_font_css(directory)