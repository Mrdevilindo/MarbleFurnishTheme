<?php
/**
 * MarbleCraft Theme Customizer
 * 
 * This file adds customizer settings to allow editing home page content
 * and other site elements from WordPress admin
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register theme customizer settings
 */
function marblecraft_customize_register($wp_customize) {
    
    // Add Site Identity section (already exists by default)
    // We'll just add custom controls to it

    // Logo position control
    $wp_customize->add_setting('logo_position', [
        'default' => 'left',
        'sanitize_callback' => 'marblecraft_sanitize_logo_position',
    ]);
    
    $wp_customize->add_control('logo_position', [
        'label' => __('Logo Position', 'marblecraft'),
        'section' => 'title_tagline',
        'type' => 'radio',
        'choices' => [
            'left' => __('Left', 'marblecraft'),
            'center' => __('Center', 'marblecraft'),
        ],
    ]);

    // Add Home Hero Section
    $wp_customize->add_section('marblecraft_home_hero', [
        'title' => __('Home Hero Section', 'marblecraft'),
        'description' => __('Customize the hero section on the home page', 'marblecraft'),
        'priority' => 30,
    ]);
    
    // Add Hero Title (English)
    $wp_customize->add_setting('hero_title_en', [
        'default' => __('Elegant Marble Furniture', 'marblecraft'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('hero_title_en', [
        'label' => __('Hero Title (English)', 'marblecraft'),
        'section' => 'marblecraft_home_hero',
        'type' => 'text',
    ]);
    
    // Add Hero Subtitle (English)
    $wp_customize->add_setting('hero_subtitle_en', [
        'default' => __('Discover our handcrafted marble furniture, where timeless elegance meets modern design.', 'marblecraft'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    
    $wp_customize->add_control('hero_subtitle_en', [
        'label' => __('Hero Subtitle (English)', 'marblecraft'),
        'section' => 'marblecraft_home_hero',
        'type' => 'textarea',
    ]);
    
    // Add Hero Title (Chinese)
    $wp_customize->add_setting('hero_title_zh', [
        'default' => __('优雅的大理石家具', 'marblecraft'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('hero_title_zh', [
        'label' => __('Hero Title (Chinese)', 'marblecraft'),
        'section' => 'marblecraft_home_hero',
        'type' => 'text',
    ]);
    
    // Add Hero Subtitle (Chinese)
    $wp_customize->add_setting('hero_subtitle_zh', [
        'default' => __('发现我们手工制作的大理石家具，永恒的优雅与现代设计相结合。', 'marblecraft'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    
    $wp_customize->add_control('hero_subtitle_zh', [
        'label' => __('Hero Subtitle (Chinese)', 'marblecraft'),
        'section' => 'marblecraft_home_hero',
        'type' => 'textarea',
    ]);
    
    // Add Hero Title (Spanish)
    $wp_customize->add_setting('hero_title_es', [
        'default' => __('Muebles de Mármol Elegantes', 'marblecraft'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('hero_title_es', [
        'label' => __('Hero Title (Spanish)', 'marblecraft'),
        'section' => 'marblecraft_home_hero',
        'type' => 'text',
    ]);
    
    // Add Hero Subtitle (Spanish)
    $wp_customize->add_setting('hero_subtitle_es', [
        'default' => __('Descubra nuestros muebles de mármol hechos a mano, donde la elegancia atemporal se une al diseño moderno.', 'marblecraft'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    
    $wp_customize->add_control('hero_subtitle_es', [
        'label' => __('Hero Subtitle (Spanish)', 'marblecraft'),
        'section' => 'marblecraft_home_hero',
        'type' => 'textarea',
    ]);
    
    // Add Hero Background Image
    $wp_customize->add_setting('hero_background_image', [
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_background_image', [
        'label' => __('Hero Background Image', 'marblecraft'),
        'section' => 'marblecraft_home_hero',
        'settings' => 'hero_background_image',
    ]));
    
    // Add Hero Button Text and URLs
    $wp_customize->add_setting('hero_button1_text', [
        'default' => __('View Our Collection', 'marblecraft'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('hero_button1_text', [
        'label' => __('First Button Text', 'marblecraft'),
        'section' => 'marblecraft_home_hero',
        'type' => 'text',
    ]);
    
    $wp_customize->add_setting('hero_button1_url', [
        'default' => home_url('/products/'),
        'sanitize_callback' => 'esc_url_raw',
    ]);
    
    $wp_customize->add_control('hero_button1_url', [
        'label' => __('First Button URL', 'marblecraft'),
        'section' => 'marblecraft_home_hero',
        'type' => 'url',
    ]);
    
    $wp_customize->add_setting('hero_button2_text', [
        'default' => __('Contact Us', 'marblecraft'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('hero_button2_text', [
        'label' => __('Second Button Text', 'marblecraft'),
        'section' => 'marblecraft_home_hero',
        'type' => 'text',
    ]);
    
    $wp_customize->add_setting('hero_button2_url', [
        'default' => home_url('/contact/'),
        'sanitize_callback' => 'esc_url_raw',
    ]);
    
    $wp_customize->add_control('hero_button2_url', [
        'label' => __('Second Button URL', 'marblecraft'),
        'section' => 'marblecraft_home_hero',
        'type' => 'url',
    ]);
    
    // Add Featured Products Section
    $wp_customize->add_section('marblecraft_featured_products', [
        'title' => __('Featured Products Section', 'marblecraft'),
        'description' => __('Customize the featured products section on the home page', 'marblecraft'),
        'priority' => 40,
    ]);
    
    $wp_customize->add_setting('featured_products_title', [
        'default' => __('Featured Products', 'marblecraft'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('featured_products_title', [
        'label' => __('Section Title', 'marblecraft'),
        'section' => 'marblecraft_featured_products',
        'type' => 'text',
    ]);
    
    $wp_customize->add_setting('featured_products_count', [
        'default' => 3,
        'sanitize_callback' => 'absint',
    ]);
    
    $wp_customize->add_control('featured_products_count', [
        'label' => __('Number of Products to Display', 'marblecraft'),
        'section' => 'marblecraft_featured_products',
        'type' => 'number',
        'input_attrs' => [
            'min' => 1,
            'max' => 12,
            'step' => 1,
        ],
    ]);
    
    $wp_customize->add_setting('featured_products_button_text', [
        'default' => __('View All Products', 'marblecraft'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('featured_products_button_text', [
        'label' => __('Button Text', 'marblecraft'),
        'section' => 'marblecraft_featured_products',
        'type' => 'text',
    ]);
    
    // Add About Section
    $wp_customize->add_section('marblecraft_about_section', [
        'title' => __('About Section', 'marblecraft'),
        'description' => __('Customize the about section on the home page', 'marblecraft'),
        'priority' => 50,
    ]);
    
    $wp_customize->add_setting('about_section_title', [
        'default' => __('Craftsmanship Beyond Compare', 'marblecraft'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('about_section_title', [
        'label' => __('Section Title', 'marblecraft'),
        'section' => 'marblecraft_about_section',
        'type' => 'text',
    ]);
    
    $wp_customize->add_setting('about_section_content', [
        'default' => __('At MarbleCraft, we transform natural marble into exquisite furniture pieces that bring timeless elegance to any space. Each piece is carefully crafted by skilled artisans with decades of experience working with this precious stone.', 'marblecraft'),
        'sanitize_callback' => 'wp_kses_post',
    ]);
    
    $wp_customize->add_control('about_section_content', [
        'label' => __('Section Content', 'marblecraft'),
        'section' => 'marblecraft_about_section',
        'type' => 'textarea',
    ]);
    
    $wp_customize->add_setting('about_section_button_text', [
        'default' => __('Learn More About Us', 'marblecraft'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('about_section_button_text', [
        'label' => __('Button Text', 'marblecraft'),
        'section' => 'marblecraft_about_section',
        'type' => 'text',
    ]);
    
    $wp_customize->add_setting('about_section_button_url', [
        'default' => home_url('/about-us/'),
        'sanitize_callback' => 'esc_url_raw',
    ]);
    
    $wp_customize->add_control('about_section_button_url', [
        'label' => __('Button URL', 'marblecraft'),
        'section' => 'marblecraft_about_section',
        'type' => 'url',
    ]);
    
    // Add gallery images for about section
    for ($i = 1; $i <= 4; $i++) {
        $wp_customize->add_setting("about_gallery_image_{$i}", [
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ]);
        
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "about_gallery_image_{$i}", [
            'label' => sprintf(__('Gallery Image %d', 'marblecraft'), $i),
            'section' => 'marblecraft_about_section',
            'settings' => "about_gallery_image_{$i}",
        ]));
    }
    
    // Add CTA Section
    $wp_customize->add_section('marblecraft_cta_section', [
        'title' => __('CTA Section', 'marblecraft'),
        'description' => __('Customize the call-to-action section on the home page', 'marblecraft'),
        'priority' => 60,
    ]);
    
    $wp_customize->add_setting('cta_section_title', [
        'default' => __('Ready to Transform Your Space?', 'marblecraft'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('cta_section_title', [
        'label' => __('CTA Title', 'marblecraft'),
        'section' => 'marblecraft_cta_section',
        'type' => 'text',
    ]);
    
    $wp_customize->add_setting('cta_section_description', [
        'default' => __('Contact us today to discuss your custom marble furniture needs or explore our collection of ready-made pieces.', 'marblecraft'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    
    $wp_customize->add_control('cta_section_description', [
        'label' => __('CTA Description', 'marblecraft'),
        'section' => 'marblecraft_cta_section',
        'type' => 'textarea',
    ]);
    
    $wp_customize->add_setting('cta_button1_text', [
        'default' => __('Browse Products', 'marblecraft'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('cta_button1_text', [
        'label' => __('First Button Text', 'marblecraft'),
        'section' => 'marblecraft_cta_section',
        'type' => 'text',
    ]);
    
    $wp_customize->add_setting('cta_button1_url', [
        'default' => home_url('/products/'),
        'sanitize_callback' => 'esc_url_raw',
    ]);
    
    $wp_customize->add_control('cta_button1_url', [
        'label' => __('First Button URL', 'marblecraft'),
        'section' => 'marblecraft_cta_section',
        'type' => 'url',
    ]);
    
    $wp_customize->add_setting('cta_button2_text', [
        'default' => __('Get in Touch', 'marblecraft'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('cta_button2_text', [
        'label' => __('Second Button Text', 'marblecraft'),
        'section' => 'marblecraft_cta_section',
        'type' => 'text',
    ]);
    
    $wp_customize->add_setting('cta_button2_url', [
        'default' => home_url('/contact/'),
        'sanitize_callback' => 'esc_url_raw',
    ]);
    
    $wp_customize->add_control('cta_button2_url', [
        'label' => __('Second Button URL', 'marblecraft'),
        'section' => 'marblecraft_cta_section',
        'type' => 'url',
    ]);
    
    // Add Footer Section
    $wp_customize->add_section('marblecraft_footer', [
        'title' => __('Footer Section', 'marblecraft'),
        'description' => __('Customize the footer content', 'marblecraft'),
        'priority' => 70,
    ]);
    
    $wp_customize->add_setting('footer_about_title', [
        'default' => __('About Us', 'marblecraft'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('footer_about_title', [
        'label' => __('About Column Title', 'marblecraft'),
        'section' => 'marblecraft_footer',
        'type' => 'text',
    ]);
    
    $wp_customize->add_setting('footer_about_text', [
        'default' => __('Premium marble furniture crafted with precision and care, designed to elevate any space with timeless elegance.', 'marblecraft'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    
    $wp_customize->add_control('footer_about_text', [
        'label' => __('About Column Text', 'marblecraft'),
        'section' => 'marblecraft_footer',
        'type' => 'textarea',
    ]);
    
    // Social Media URLs
    $social_platforms = ['facebook', 'twitter', 'instagram', 'linkedin'];
    
    foreach ($social_platforms as $platform) {
        $wp_customize->add_setting("social_{$platform}_url", [
            'default' => '#',
            'sanitize_callback' => 'esc_url_raw',
        ]);
        
        $wp_customize->add_control("social_{$platform}_url", [
            'label' => sprintf(__('%s URL', 'marblecraft'), ucfirst($platform)),
            'section' => 'marblecraft_footer',
            'type' => 'url',
        ]);
    }
    
    // Contact Information
    $wp_customize->add_setting('contact_address', [
        'default' => __('123 Marble St, Stone City', 'marblecraft'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('contact_address', [
        'label' => __('Address', 'marblecraft'),
        'section' => 'marblecraft_footer',
        'type' => 'text',
    ]);
    
    $wp_customize->add_setting('contact_phone', [
        'default' => __('+1 (123) 456-7890', 'marblecraft'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('contact_phone', [
        'label' => __('Phone Number', 'marblecraft'),
        'section' => 'marblecraft_footer',
        'type' => 'text',
    ]);
    
    $wp_customize->add_setting('contact_email', [
        'default' => 'info@marblecraft.com',
        'sanitize_callback' => 'sanitize_email',
    ]);
    
    $wp_customize->add_control('contact_email', [
        'label' => __('Email Address', 'marblecraft'),
        'section' => 'marblecraft_footer',
        'type' => 'email',
    ]);
}
add_action('customize_register', 'marblecraft_customize_register');

/**
 * Sanitization callback for logo position
 */
function marblecraft_sanitize_logo_position($value) {
    $valid = ['left', 'center'];
    if (in_array($value, $valid, true)) {
        return $value;
    }
    return 'left';
}