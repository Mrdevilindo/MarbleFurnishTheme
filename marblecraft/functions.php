<?php
/**
 * MarbleCraft Theme functions and definitions
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Define Constants
 */
define('MARBLECRAFT_VERSION', '1.0.0');
define('MARBLECRAFT_THEME_DIR', get_template_directory());
define('MARBLECRAFT_THEME_URI', get_template_directory_uri());

/**
 * Theme Setup
 */
function marblecraft_setup() {
    // Load theme text domain for translation
    load_theme_textdomain('marblecraft', MARBLECRAFT_THEME_DIR . '/languages');

    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');
    
    // Add support for responsive embeds
    add_theme_support('responsive-embeds');

    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 350,
        'flex-width'  => true,
        'flex-height' => true,
    ));

    // Register menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'marblecraft'),
        'footer'  => esc_html__('Footer Menu', 'marblecraft'),
    ));

    // Switch default core markup to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Add support for Block Styles
    add_theme_support('wp-block-styles');

    // Add support for full and wide align images
    add_theme_support('align-wide');

    // Set up the WordPress core custom background feature
    add_theme_support('custom-background', array(
        'default-color' => 'f5f5f5',
    ));

    // Set up the WordPress core custom header feature
    add_theme_support('custom-header', array(
        'default-image'      => '',
        'default-text-color' => '333333',
        'width'              => 1600,
        'height'             => 500,
        'flex-width'         => true,
        'flex-height'        => true,
    ));

    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');

    // Add image sizes
    add_image_size('marblecraft-featured', 1200, 600, true);
    add_image_size('marblecraft-product', 600, 600, true);
    add_image_size('marblecraft-product-thumbnail', 300, 300, true);
}
add_action('after_setup_theme', 'marblecraft_setup');

/**
 * Register widget area
 */
function marblecraft_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'marblecraft'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'marblecraft'),
        'before_widget' => '<section id="%1$s" class="widget %2$s mb-8">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title text-xl font-bold mb-4">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer 1', 'marblecraft'),
        'id'            => 'footer-1',
        'description'   => esc_html__('First footer widget area', 'marblecraft'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title text-xl font-bold mb-4">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer 2', 'marblecraft'),
        'id'            => 'footer-2',
        'description'   => esc_html__('Second footer widget area', 'marblecraft'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title text-xl font-bold mb-4">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer 3', 'marblecraft'),
        'id'            => 'footer-3',
        'description'   => esc_html__('Third footer widget area', 'marblecraft'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title text-xl font-bold mb-4">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'marblecraft_widgets_init');

/**
 * Enqueue scripts and styles
 */
function marblecraft_scripts() {
    // Enqueue Tailwind CSS
    wp_enqueue_style('marblecraft-tailwind', MARBLECRAFT_THEME_URI . '/assets/css/tailwind.min.css', array(), MARBLECRAFT_VERSION);
    
    // Enqueue theme stylesheet
    wp_enqueue_style('marblecraft-style', get_stylesheet_uri(), array(), MARBLECRAFT_VERSION);
    
    // Enqueue custom CSS
    wp_enqueue_style('marblecraft-custom', MARBLECRAFT_THEME_URI . '/assets/css/custom.css', array(), MARBLECRAFT_VERSION);
    
    // Enqueue main JavaScript file
    wp_enqueue_script('marblecraft-main', MARBLECRAFT_THEME_URI . '/assets/js/main.js', array('jquery'), MARBLECRAFT_VERSION, true);
    
    // If comments are open or we have at least one comment, load the comment-reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
    
    // Localize script for translations and AJAX
    wp_localize_script('marblecraft-main', 'marblecraftVars', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('marblecraft-nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'marblecraft_scripts');

/**
 * Admin scripts and styles
 */
function marblecraft_admin_scripts() {
    // Admin specific styles/scripts if needed
    wp_enqueue_style('marblecraft-admin', MARBLECRAFT_THEME_URI . '/assets/css/admin.css', array(), MARBLECRAFT_VERSION);
}
add_action('admin_enqueue_scripts', 'marblecraft_admin_scripts');

/**
 * Custom template tags for this theme
 */
require MARBLECRAFT_THEME_DIR . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress
 */
require MARBLECRAFT_THEME_DIR . '/inc/template-functions.php';

/**
 * Theme Customizer
 */
require MARBLECRAFT_THEME_DIR . '/inc/theme-customizer.php';

/**
 * Custom post types
 */
require MARBLECRAFT_THEME_DIR . '/inc/custom-post-types.php';

/**
 * Load shortcodes
 */
require MARBLECRAFT_THEME_DIR . '/inc/shortcodes.php';

/**
 * Load ML Image Description generator
 */
require MARBLECRAFT_THEME_DIR . '/inc/ml-image-description.php';

/**
 * Load WooCommerce compatibility file
 */
if (class_exists('WooCommerce')) {
    require MARBLECRAFT_THEME_DIR . '/inc/woocommerce.php';
}

/**
 * Custom excerpt length
 */
function marblecraft_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'marblecraft_excerpt_length');

/**
 * Change excerpt "Read More" text
 */
function marblecraft_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'marblecraft_excerpt_more');

/**
 * Handle AJAX Contact Form Submission
 */
function marblecraft_contact_form_submit() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'marblecraft-nonce')) {
        wp_send_json_error('Security check failed');
    }
    
    // Get form data
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $subject = sanitize_text_field($_POST['subject']);
    $message = sanitize_textarea_field($_POST['message']);
    
    // Validate form fields
    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error('Please fill in all required fields');
    }
    
    // Validate email
    if (!is_email($email)) {
        wp_send_json_error('Please enter a valid email address');
    }
    
    // Email settings
    $to = get_option('admin_email');
    $subject = !empty($subject) ? $subject : 'New Contact Form Submission';
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . $name . ' <' . $email . '>',
        'Reply-To: ' . $email,
    );
    
    // Prepare email content
    $email_content = '<p><strong>Name:</strong> ' . $name . '</p>';
    $email_content .= '<p><strong>Email:</strong> ' . $email . '</p>';
    $email_content .= '<p><strong>Message:</strong></p>';
    $email_content .= '<p>' . wpautop($message) . '</p>';
    
    // Send email
    $email_sent = wp_mail($to, $subject, $email_content, $headers);
    
    // Check if email was sent
    if ($email_sent) {
        wp_send_json_success('Thank you for your message. We will get back to you soon!');
    } else {
        wp_send_json_error('There was an error sending your message. Please try again later.');
    }
}
add_action('wp_ajax_marblecraft_contact_form', 'marblecraft_contact_form_submit');
add_action('wp_ajax_nopriv_marblecraft_contact_form', 'marblecraft_contact_form_submit');

/**
 * Register Custom Navigation Walker for Bootstrap/Tailwind
 */
if (!file_exists(MARBLECRAFT_THEME_DIR . '/inc/class-wp-bootstrap-navwalker.php')) {
    // Custom fallback walker if file doesn't exist
    function marblecraft_nav_menu_fallback($args) {
        echo '<ul class="navbar-nav ml-auto">';
        echo '<li class="nav-item"><a href="' . esc_url(home_url('/')) . '" class="nav-link">Home</a></li>';
        echo '</ul>';
    }
} else {
    // Include custom navigation walker
    require_once MARBLECRAFT_THEME_DIR . '/inc/class-wp-bootstrap-navwalker.php';
}

/**
 * Multilingual Support Functions
 */
function marblecraft_get_current_language() {
    $lang = '';
    
    // Check if Polylang is active
    if (function_exists('pll_current_language')) {
        $lang = pll_current_language();
    }
    // Check if WPML is active
    elseif (defined('ICL_LANGUAGE_CODE')) {
        $lang = ICL_LANGUAGE_CODE;
    }
    
    return $lang ? $lang : 'en';
}

function marblecraft_get_available_languages() {
    $languages = array();
    
    // Check if Polylang is active
    if (function_exists('pll_languages_list')) {
        $languages = pll_languages_list(array('fields' => 'slug'));
    }
    // Check if WPML is active
    elseif (function_exists('icl_get_languages')) {
        $wpml_languages = icl_get_languages('skip_missing=0');
        $languages = array_keys($wpml_languages);
    }
    // Fall back to array from theme customizer
    else {
        $additional_languages = get_theme_mod('additional_languages', array('en', 'zh'));
        if (is_string($additional_languages)) {
            $additional_languages = explode(',', $additional_languages);
        }
        $languages = array_map('trim', $additional_languages);
    }
    
    return !empty($languages) ? $languages : array('en');
}

/**
 * Get translated URL
 */
function marblecraft_get_translated_url($url, $lang) {
    // Check if Polylang is active
    if (function_exists('pll_get_post')) {
        $post_id = url_to_postid($url);
        if ($post_id) {
            $translated_id = pll_get_post($post_id, $lang);
            if ($translated_id) {
                return get_permalink($translated_id);
            }
        }
    }
    // Check if WPML is active
    elseif (function_exists('icl_object_id')) {
        $post_id = url_to_postid($url);
        if ($post_id) {
            $translated_id = icl_object_id($post_id, 'post', true, $lang);
            if ($translated_id) {
                return get_permalink($translated_id);
            }
        }
    }
    
    // If translation plugins aren't active or translation not found, add language parameter to URL
    $parsed_url = parse_url($url);
    $query = isset($parsed_url['query']) ? $parsed_url['query'] : '';
    parse_str($query, $query_params);
    $query_params['lang'] = $lang;
    $new_query = http_build_query($query_params);
    
    $scheme = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
    $host = isset($parsed_url['host']) ? $parsed_url['host'] : '';
    $path = isset($parsed_url['path']) ? $parsed_url['path'] : '';
    $query = !empty($new_query) ? '?' . $new_query : '';
    $fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';
    
    return $scheme . $host . $path . $query . $fragment;
}

/**
 * Add SVG support
 */
function marblecraft_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'marblecraft_mime_types');

/**
 * Enable post formats
 */
add_theme_support('post-formats', array(
    'aside',
    'gallery',
    'link',
    'image',
    'quote',
    'status',
    'video',
    'audio',
    'chat',
));