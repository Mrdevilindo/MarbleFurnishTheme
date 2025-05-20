<?php
/**
 * MarbleCraft Theme Customizer
 *
 * This file handles all theme customization options available in the WordPress Customizer.
 * It allows users to customize various aspects of the theme through the WordPress admin dashboard.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Register theme customizer settings
 */
function marblecraft_customize_register($wp_customize) {
    /**
     * Site Identity Section Extensions
     */

    // Logo Position
    $wp_customize->add_setting('logo_position', array(
        'default'           => 'left',
        'transport'         => 'refresh',
        'sanitize_callback' => 'marblecraft_sanitize_select',
    ));

    $wp_customize->add_control('logo_position', array(
        'label'       => __('Logo Position', 'marblecraft'),
        'description' => __('Choose the position of your logo in the header', 'marblecraft'),
        'section'     => 'title_tagline',
        'settings'    => 'logo_position',
        'type'        => 'select',
        'choices'     => array(
            'left'   => __('Left', 'marblecraft'),
            'center' => __('Center', 'marblecraft'),
        ),
        'priority'    => 9,
    ));

    // Header Text Color
    $wp_customize->add_setting('header_text_color', array(
        'default'           => '#333333',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'header_text_color', array(
        'label'       => __('Header Text Color', 'marblecraft'),
        'description' => __('Choose the color for header text', 'marblecraft'),
        'section'     => 'title_tagline',
        'settings'    => 'header_text_color',
        'priority'    => 11,
    )));

    /**
     * Header Options Section
     */
    $wp_customize->add_section('header_options', array(
        'title'       => __('Header Options', 'marblecraft'),
        'description' => __('Customize header appearance and behavior', 'marblecraft'),
        'priority'    => 30,
    ));

    // Sticky Header
    $wp_customize->add_setting('sticky_header', array(
        'default'           => false,
        'transport'         => 'refresh',
        'sanitize_callback' => 'marblecraft_sanitize_checkbox',
    ));

    $wp_customize->add_control('sticky_header', array(
        'label'       => __('Enable Sticky Header', 'marblecraft'),
        'description' => __('Keep the header visible when scrolling down', 'marblecraft'),
        'section'     => 'header_options',
        'settings'    => 'sticky_header',
        'type'        => 'checkbox',
    ));

    // Header Style
    $wp_customize->add_setting('header_style', array(
        'default'           => 'standard',
        'transport'         => 'refresh',
        'sanitize_callback' => 'marblecraft_sanitize_select',
    ));

    $wp_customize->add_control('header_style', array(
        'label'       => __('Header Style', 'marblecraft'),
        'description' => __('Choose the header appearance style', 'marblecraft'),
        'section'     => 'header_options',
        'settings'    => 'header_style',
        'type'        => 'select',
        'choices'     => array(
            'standard' => __('Standard', 'marblecraft'),
            'minimal'  => __('Minimal', 'marblecraft'),
            'centered' => __('Centered', 'marblecraft'),
        ),
    ));

    /**
     * Social Media Links Section
     */
    $wp_customize->add_section('social_links', array(
        'title'       => __('Social Media Links', 'marblecraft'),
        'description' => __('Add links to your social media profiles', 'marblecraft'),
        'priority'    => 90,
    ));

    // Facebook
    $wp_customize->add_setting('social_facebook_url', array(
        'default'           => '#',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('social_facebook_url', array(
        'label'       => __('Facebook URL', 'marblecraft'),
        'description' => __('Enter your Facebook profile/page URL', 'marblecraft'),
        'section'     => 'social_links',
        'type'        => 'url',
    ));

    // Twitter
    $wp_customize->add_setting('social_twitter_url', array(
        'default'           => '#',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('social_twitter_url', array(
        'label'       => __('Twitter URL', 'marblecraft'),
        'description' => __('Enter your Twitter profile URL', 'marblecraft'),
        'section'     => 'social_links',
        'type'        => 'url',
    ));

    // Instagram
    $wp_customize->add_setting('social_instagram_url', array(
        'default'           => '#',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('social_instagram_url', array(
        'label'       => __('Instagram URL', 'marblecraft'),
        'description' => __('Enter your Instagram profile URL', 'marblecraft'),
        'section'     => 'social_links',
        'type'        => 'url',
    ));

    // LinkedIn
    $wp_customize->add_setting('social_linkedin_url', array(
        'default'           => '#',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('social_linkedin_url', array(
        'label'       => __('LinkedIn URL', 'marblecraft'),
        'description' => __('Enter your LinkedIn profile URL', 'marblecraft'),
        'section'     => 'social_links',
        'type'        => 'url',
    ));

    /**
     * Footer Customization Section
     */
    $wp_customize->add_section('footer_options', array(
        'title'       => __('Footer Options', 'marblecraft'),
        'description' => __('Customize footer content and appearance', 'marblecraft'),
        'priority'    => 100,
    ));

    // Footer About Title
    $wp_customize->add_setting('footer_about_title', array(
        'default'           => __('About Us', 'marblecraft'),
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('footer_about_title', array(
        'label'       => __('About Section Title', 'marblecraft'),
        'section'     => 'footer_options',
        'type'        => 'text',
    ));

    // Footer About Text
    $wp_customize->add_setting('footer_about_text', array(
        'default'           => '',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('footer_about_text', array(
        'label'       => __('About Section Text', 'marblecraft'),
        'section'     => 'footer_options',
        'type'        => 'textarea',
    ));

    /**
     * Contact Information Section
     */
    $wp_customize->add_section('contact_info', array(
        'title'       => __('Contact Information', 'marblecraft'),
        'description' => __('Enter your contact details', 'marblecraft'),
        'priority'    => 110,
    ));

    // Address
    $wp_customize->add_setting('contact_address', array(
        'default'           => __('123 Marble St, Stone City', 'marblecraft'),
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('contact_address', array(
        'label'       => __('Address', 'marblecraft'),
        'description' => __('Your business address', 'marblecraft'),
        'section'     => 'contact_info',
        'type'        => 'text',
    ));

    // Phone
    $wp_customize->add_setting('contact_phone', array(
        'default'           => __('+1 (123) 456-7890', 'marblecraft'),
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('contact_phone', array(
        'label'       => __('Phone Number', 'marblecraft'),
        'description' => __('Your business phone number', 'marblecraft'),
        'section'     => 'contact_info',
        'type'        => 'text',
    ));

    // Email
    $wp_customize->add_setting('contact_email', array(
        'default'           => 'info@marblecraft.com',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_email',
    ));

    $wp_customize->add_control('contact_email', array(
        'label'       => __('Email Address', 'marblecraft'),
        'description' => __('Your business email address', 'marblecraft'),
        'section'     => 'contact_info',
        'type'        => 'email',
    ));

    /**
     * Homepage Settings Section
     */
    $wp_customize->add_section('homepage_options', array(
        'title'       => __('Homepage Options', 'marblecraft'),
        'description' => __('Customize homepage content and layout', 'marblecraft'),
        'priority'    => 120,
    ));

    // Hero Title
    $wp_customize->add_setting('hero_title', array(
        'default'           => __('Exquisite Marble Furniture', 'marblecraft'),
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('hero_title', array(
        'label'       => __('Hero Title', 'marblecraft'),
        'description' => __('Main headline for the homepage', 'marblecraft'),
        'section'     => 'homepage_options',
        'type'        => 'text',
    ));

    // Hero Subtitle
    $wp_customize->add_setting('hero_subtitle', array(
        'default'           => __('Luxury craftsmanship for your home and office', 'marblecraft'),
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('hero_subtitle', array(
        'label'       => __('Hero Subtitle', 'marblecraft'),
        'description' => __('Secondary text for the homepage hero section', 'marblecraft'),
        'section'     => 'homepage_options',
        'type'        => 'text',
    ));

    // Hero Image
    $wp_customize->add_setting('hero_image', array(
        'default'           => '',
        'transport'         => 'refresh',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_image', array(
        'label'       => __('Hero Background Image', 'marblecraft'),
        'description' => __('Upload an image for the homepage hero background', 'marblecraft'),
        'section'     => 'homepage_options',
        'settings'    => 'hero_image',
    )));

    // Primary CTA Button Text
    $wp_customize->add_setting('hero_cta_text', array(
        'default'           => __('View Our Collection', 'marblecraft'),
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('hero_cta_text', array(
        'label'       => __('Primary Button Text', 'marblecraft'),
        'section'     => 'homepage_options',
        'type'        => 'text',
    ));

    // Primary CTA Button URL
    $wp_customize->add_setting('hero_cta_url', array(
        'default'           => home_url('/products/'),
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('hero_cta_url', array(
        'label'       => __('Primary Button URL', 'marblecraft'),
        'section'     => 'homepage_options',
        'type'        => 'url',
    ));

    // Secondary CTA Button Text
    $wp_customize->add_setting('hero_secondary_cta_text', array(
        'default'           => __('Contact Us', 'marblecraft'),
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('hero_secondary_cta_text', array(
        'label'       => __('Secondary Button Text', 'marblecraft'),
        'section'     => 'homepage_options',
        'type'        => 'text',
    ));

    // Secondary CTA Button URL
    $wp_customize->add_setting('hero_secondary_cta_url', array(
        'default'           => home_url('/contact/'),
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('hero_secondary_cta_url', array(
        'label'       => __('Secondary Button URL', 'marblecraft'),
        'section'     => 'homepage_options',
        'type'        => 'url',
    ));

    // Featured Section Title
    $wp_customize->add_setting('featured_section_title', array(
        'default'           => __('Featured Products', 'marblecraft'),
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('featured_section_title', array(
        'label'       => __('Featured Section Title', 'marblecraft'),
        'section'     => 'homepage_options',
        'type'        => 'text',
    ));

    // Featured Section Description
    $wp_customize->add_setting('featured_section_description', array(
        'default'           => __('Discover our handcrafted marble masterpieces', 'marblecraft'),
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('featured_section_description', array(
        'label'       => __('Featured Section Description', 'marblecraft'),
        'section'     => 'homepage_options',
        'type'        => 'textarea',
    ));

    // About Section Title
    $wp_customize->add_setting('about_section_title', array(
        'default'           => __('About MarbleCraft', 'marblecraft'),
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('about_section_title', array(
        'label'       => __('About Section Title', 'marblecraft'),
        'section'     => 'homepage_options',
        'type'        => 'text',
    ));

    // About Section Content
    $wp_customize->add_setting('about_section_content', array(
        'default'           => __('MarbleCraft has been creating luxury marble furniture for over two decades. Our craftsmen combine traditional techniques with modern design to produce unique pieces that elevate any space.', 'marblecraft'),
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('about_section_content', array(
        'label'       => __('About Section Content', 'marblecraft'),
        'section'     => 'homepage_options',
        'type'        => 'textarea',
    ));

    // About Section Image
    $wp_customize->add_setting('about_section_image', array(
        'default'           => '',
        'transport'         => 'refresh',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'about_section_image', array(
        'label'       => __('About Section Image', 'marblecraft'),
        'description' => __('Upload an image for the about section', 'marblecraft'),
        'section'     => 'homepage_options',
        'settings'    => 'about_section_image',
    )));

    /**
     * Language Settings
     */
    $wp_customize->add_section('language_settings', array(
        'title'       => __('Language Settings', 'marblecraft'),
        'description' => __('Configure multilingual support', 'marblecraft'),
        'priority'    => 130,
    ));

    // Enable Multilingual Support
    $wp_customize->add_setting('enable_multilingual', array(
        'default'           => true,
        'transport'         => 'refresh',
        'sanitize_callback' => 'marblecraft_sanitize_checkbox',
    ));

    $wp_customize->add_control('enable_multilingual', array(
        'label'       => __('Enable Multilingual Support', 'marblecraft'),
        'description' => __('Show language switcher in header and footer', 'marblecraft'),
        'section'     => 'language_settings',
        'type'        => 'checkbox',
    ));

    // Primary Language
    $wp_customize->add_setting('primary_language', array(
        'default'           => 'en',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('primary_language', array(
        'label'       => __('Primary Language', 'marblecraft'),
        'description' => __('Set the default language for your site', 'marblecraft'),
        'section'     => 'language_settings',
        'type'        => 'select',
        'choices'     => array(
            'en' => __('English', 'marblecraft'),
            'zh' => __('Chinese', 'marblecraft'),
            'es' => __('Spanish', 'marblecraft'),
            'fr' => __('French', 'marblecraft'),
            'de' => __('German', 'marblecraft'),
            'it' => __('Italian', 'marblecraft'),
            'ja' => __('Japanese', 'marblecraft'),
            'ar' => __('Arabic', 'marblecraft'),
            'ru' => __('Russian', 'marblecraft'),
        ),
    ));

    // Additional Languages
    $wp_customize->add_setting('additional_languages', array(
        'default'           => array('en', 'zh'),
        'transport'         => 'refresh',
        'sanitize_callback' => 'marblecraft_sanitize_multiple_select',
    ));

    $wp_customize->add_control('additional_languages', array(
        'label'       => __('Additional Languages', 'marblecraft'),
        'description' => __('Select languages to display in the language switcher (Ctrl+Click to select multiple)', 'marblecraft'),
        'section'     => 'language_settings',
        'type'        => 'text',
        'input_attrs' => array(
            'placeholder' => __('e.g., en,zh,es,fr', 'marblecraft'),
        ),
    ));
    
    /**
     * AI Integration Settings
     */
    $wp_customize->add_section('ai_integration', array(
        'title'       => __('AI Integration', 'marblecraft'),
        'description' => __('Configure AI integration settings for product descriptions', 'marblecraft'),
        'priority'    => 140,
    ));

    // OpenAI API Key
    $wp_customize->add_setting('openai_api_key', array(
        'default'           => '',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('openai_api_key', array(
        'label'       => __('OpenAI API Key', 'marblecraft'),
        'description' => __('Enter your OpenAI API key to enable AI features for product descriptions', 'marblecraft'),
        'section'     => 'ai_integration',
        'type'        => 'password',
    ));

    // Enable AI Features
    $wp_customize->add_setting('enable_ai_features', array(
        'default'           => true,
        'transport'         => 'refresh',
        'sanitize_callback' => 'marblecraft_sanitize_checkbox',
    ));

    $wp_customize->add_control('enable_ai_features', array(
        'label'       => __('Enable AI Features', 'marblecraft'),
        'description' => __('Use AI to generate product descriptions from images', 'marblecraft'),
        'section'     => 'ai_integration',
        'type'        => 'checkbox',
    ));
}
add_action('customize_register', 'marblecraft_customize_register');

/**
 * Sanitize select options
 */
function marblecraft_sanitize_select($input, $setting) {
    // Get the list of choices from the control associated with the setting
    $choices = $setting->manager->get_control($setting->id)->choices;
    // Return input if valid or return default option
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}

/**
 * Sanitize checkbox inputs
 */
function marblecraft_sanitize_checkbox($input) {
    return ($input === true || $input === '1') ? true : false;
}

/**
 * Sanitize multiple select options
 */
function marblecraft_sanitize_multiple_select($input) {
    if (!is_array($input)) {
        $input = explode(',', $input);
    }
    $valid_langs = array('en', 'zh', 'es', 'fr', 'de', 'it', 'ja', 'ar', 'ru');
    
    return array_filter($input, function($lang) use ($valid_langs) {
        return in_array($lang, $valid_langs);
    });
}

/**
 * Generate CSS for customizer options
 */
function marblecraft_customizer_css() {
    ?>
    <style type="text/css">
        /* Header Text Color */
        .site-title a, .site-description {
            color: <?php echo esc_attr(get_theme_mod('header_text_color', '#333333')); ?>;
        }
        
        /* Additional styles for customizer options will go here */
    </style>
    <?php
}
add_action('wp_head', 'marblecraft_customizer_css');