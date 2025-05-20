<?php
/**
 * MarbleCraft Theme Functions
 * 
 * Main functionality for the MarbleCraft WordPress theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define theme constants
define('MARBLECRAFT_VERSION', '1.0.0');
define('MARBLECRAFT_DIR', get_template_directory());
define('MARBLECRAFT_URI', get_template_directory_uri());

/**
 * Theme setup
 */
function marblecraft_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'marblecraft'),
        'footer'  => esc_html__('Footer Menu', 'marblecraft'),
    ));

    // Load text domain for translations
    load_theme_textdomain('marblecraft', MARBLECRAFT_DIR . '/languages');
}
add_action('after_setup_theme', 'marblecraft_setup');

/**
 * Enqueue styles and scripts
 */
function marblecraft_enqueue_assets() {
    // Enqueue Tailwind CSS from CDN
    wp_enqueue_style('tailwind', 'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css', array(), '2.2.19');
    
    // Enqueue custom styles
    wp_enqueue_style('marblecraft-custom-style', MARBLECRAFT_URI . '/assets/css/custom.css', array('tailwind'), MARBLECRAFT_VERSION);
    
    // Enqueue main theme stylesheet
    wp_enqueue_style('marblecraft-style', get_stylesheet_uri(), array('tailwind', 'marblecraft-custom-style'), MARBLECRAFT_VERSION);
    
    // Enqueue jQuery
    wp_enqueue_script('jquery');
    
    // Enqueue main JS file
    wp_enqueue_script('marblecraft-script', MARBLECRAFT_URI . '/assets/js/main.js', array('jquery'), MARBLECRAFT_VERSION, true);
    
    // Localize script for AJAX
    wp_localize_script('marblecraft-script', 'marblecraftData', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('marblecraft_form_nonce'),
    ));
    
    // reCAPTCHA (only on contact page)
    if (is_page('contact')) {
        wp_enqueue_script('recaptcha', 'https://www.google.com/recaptcha/api.js', array(), null, true);
    }
}
add_action('wp_enqueue_scripts', 'marblecraft_enqueue_assets');

/**
 * Include custom files
 */
require_once MARBLECRAFT_DIR . '/inc/custom-post-types.php';
require_once MARBLECRAFT_DIR . '/inc/form-handler.php';
require_once MARBLECRAFT_DIR . '/inc/admin-submissions.php';
require_once MARBLECRAFT_DIR . '/inc/theme-customizer.php';

/**
 * Create custom database table for form submissions on theme activation
 */
function marblecraft_create_submission_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'marblecraft_submissions';
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        country varchar(100) NOT NULL,
        message text NOT NULL,
        submission_date datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'marblecraft_create_submission_table');

/**
 * Add hreflang tags for multilingual SEO
 */
function marblecraft_add_hreflang_tags() {
    // Check if WPML is active
    if (function_exists('icl_get_languages')) {
        $languages = icl_get_languages('skip_missing=0');
        
        if (!empty($languages)) {
            foreach ($languages as $language) {
                echo '<link rel="alternate" href="' . esc_url($language['url']) . '" hreflang="' . esc_attr($language['language_code']) . '" />' . "\n";
            }
        }
    }
    // Check if Polylang is active
    else if (function_exists('pll_languages_list') && function_exists('pll_current_language') && function_exists('pll_home_url')) {
        $languages = pll_languages_list(array('fields' => 'slug'));
        
        if (!empty($languages)) {
            foreach ($languages as $lang) {
                echo '<link rel="alternate" href="' . esc_url(pll_home_url($lang)) . '" hreflang="' . esc_attr($lang) . '" />' . "\n";
            }
        }
    }
}
add_action('wp_head', 'marblecraft_add_hreflang_tags');

/**
 * Contact form shortcode
 */
function marblecraft_contact_form_shortcode() {
    ob_start();
    include MARBLECRAFT_DIR . '/template-parts/contact-form.php';
    return ob_get_clean();
}
add_shortcode('marblecraft_contact_form', 'marblecraft_contact_form_shortcode');

/**
 * Featured products shortcode
 */
function marblecraft_featured_products_shortcode($atts) {
    $atts = shortcode_atts(array(
        'count' => 3,
    ), $atts);
    
    $count = intval($atts['count']);
    
    ob_start();
    
    $args = array(
        'post_type' => 'marble_product',
        'posts_per_page' => $count,
        'meta_query' => array(
            array(
                'key' => '_is_featured',
                'value' => '1',
                'compare' => '=',
            ),
        ),
    );
    
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        echo '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">';
        while ($query->have_posts()) {
            $query->the_post();
            include MARBLECRAFT_DIR . '/template-parts/product-card.php';
        }
        echo '</div>';
        wp_reset_postdata();
    } else {
        echo '<p>' . esc_html__('No featured products found.', 'marblecraft') . '</p>';
    }
    
    return ob_get_clean();
}
add_shortcode('marblecraft_featured_products', 'marblecraft_featured_products_shortcode');
