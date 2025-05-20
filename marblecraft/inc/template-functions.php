<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function marblecraft_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'marblecraft_pingback_header');

/**
 * Adds custom classes to the array of body classes.
 */
function marblecraft_body_classes($classes) {
    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter('body_class', 'marblecraft_body_classes');

/**
 * Add appropriate title tag classes based on default/custom
 */
function marblecraft_site_title_classes() {
    $classes = 'text-2xl font-bold';
    
    if (has_custom_logo()) {
        $classes .= ' screen-reader-text';
    }
    
    return $classes;
}

/**
 * Add custom query vars for filtering products
 */
function marblecraft_query_vars($vars) {
    $vars[] = 'category';
    $vars[] = 'material';
    $vars[] = 'orderby';
    $vars[] = 'order';
    return $vars;
}
add_filter('query_vars', 'marblecraft_query_vars');

/**
 * Modify the main query for marble products archive
 */
function marblecraft_pre_get_posts($query) {
    // Only modify the main query on the marble_product archive page
    if (!is_admin() && $query->is_main_query() && (is_post_type_archive('marble_product') || is_tax(array('product_category', 'material')))) {
        // Set posts per page
        $query->set('posts_per_page', 12);
        
        // Set orderby parameter
        $orderby = get_query_var('orderby');
        if (!empty($orderby)) {
            $query->set('orderby', sanitize_text_field($orderby));
        }
        
        // Set order parameter
        $order = get_query_var('order');
        if (!empty($order)) {
            $query->set('order', sanitize_text_field($order));
        }
        
        // Category filter
        $category = get_query_var('category');
        if (!empty($category) && is_numeric($category)) {
            $tax_query = array(
                array(
                    'taxonomy' => 'product_category',
                    'field'    => 'term_id',
                    'terms'    => (int) $category,
                ),
            );
            
            $query->set('tax_query', $tax_query);
        }
        
        // Material filter
        $material = get_query_var('material');
        if (!empty($material) && is_numeric($material)) {
            $current_tax_query = $query->get('tax_query', array());
            $current_tax_query[] = array(
                'taxonomy' => 'material',
                'field'    => 'term_id',
                'terms'    => (int) $material,
            );
            
            if (!empty($current_tax_query)) {
                // If we already have a tax query for category, we need to add a relation
                if (count($current_tax_query) > 1) {
                    $current_tax_query['relation'] = 'AND';
                }
                
                $query->set('tax_query', $current_tax_query);
            }
        }
    }
    
    return $query;
}
add_action('pre_get_posts', 'marblecraft_pre_get_posts');

/**
 * Register Tailwind CSS classes to be allowed in wp_kses functions
 */
function marblecraft_kses_allowed_html($allowed, $context) {
    if (is_array($context)) {
        return $allowed;
    }

    if ($context === 'tailwind') {
        $allowed = wp_kses_allowed_html('post');
        
        // Allow classes on elements
        foreach ($allowed as &$element) {
            $element['class'] = true;
        }
        
        // Allow SVG
        $allowed['svg'] = array(
            'xmlns' => true,
            'width' => true,
            'height' => true,
            'viewbox' => true,
            'class' => true,
            'fill' => true,
            'stroke' => true,
            'stroke-width' => true,
            'stroke-linecap' => true,
            'stroke-linejoin' => true,
        );
        
        $allowed['path'] = array(
            'd' => true,
            'fill' => true,
            'fill-rule' => true,
            'clip-rule' => true,
            'stroke' => true,
        );
        
        $allowed['circle'] = array(
            'cx' => true,
            'cy' => true,
            'r' => true,
            'stroke' => true,
            'fill' => true,
        );
        
        $allowed['line'] = array(
            'x1' => true,
            'y1' => true,
            'x2' => true,
            'y2' => true,
            'stroke' => true,
        );
        
        $allowed['rect'] = array(
            'x' => true,
            'y' => true,
            'width' => true,
            'height' => true,
            'rx' => true,
            'ry' => true,
            'fill' => true,
            'stroke' => true,
        );
        
        $allowed['polyline'] = array(
            'points' => true,
            'stroke' => true,
            'fill' => true,
        );
    }
    
    return $allowed;
}
add_filter('wp_kses_allowed_html', 'marblecraft_kses_allowed_html', 10, 2);

/**
 * Append query args to pagination links
 */
function marblecraft_pagination_filter($link) {
    // Get the current query vars that should be maintained in pagination
    $params_to_keep = array('category', 'material', 'orderby', 'order');
    
    // Initialize an array to store modified query args
    $modified_query_args = array();
    
    // Loop through each query var and add it to our array if it exists
    foreach ($params_to_keep as $param) {
        $value = get_query_var($param);
        if (!empty($value)) {
            $modified_query_args[$param] = sanitize_text_field($value);
        }
    }
    
    // If we have query args to add, add them to the pagination link
    if (!empty($modified_query_args)) {
        $link = add_query_arg($modified_query_args, $link);
    }
    
    return $link;
}
add_filter('paginate_links', 'marblecraft_pagination_filter');

/**
 * Generate schema markup for products
 */
function marblecraft_product_schema() {
    // Only add schema on marble product pages
    if (!is_singular('marble_product')) {
        return;
    }
    
    $post_id = get_the_ID();
    
    // Get product details
    $name = get_the_title();
    $description = wp_strip_all_tags(get_the_content());
    $price = get_post_meta($post_id, '_price', true);
    $discount_price = get_post_meta($post_id, '_discount_price', true);
    $sku = get_post_meta($post_id, '_sku', true);
    $stock = get_post_meta($post_id, '_stock', true);
    
    // Determine stock status
    $stock_status = 'https://schema.org/InStock';
    if ($stock === 'out_of_stock') {
        $stock_status = 'https://schema.org/OutOfStock';
    } elseif ($stock === 'pre_order') {
        $stock_status = 'https://schema.org/PreOrder';
    }
    
    // Get product image
    $image = get_the_post_thumbnail_url($post_id, 'full');
    if (!$image) {
        $image = '';
    }
    
    // Determine price
    $price_to_show = !empty($discount_price) ? $discount_price : $price;
    $price_to_show = preg_replace('/[^0-9.]/', '', $price_to_show);
    
    // Create schema
    $schema = array(
        '@context' => 'https://schema.org/',
        '@type' => 'Product',
        'name' => $name,
        'description' => $description,
        'sku' => $sku,
        'image' => $image,
        'offers' => array(
            '@type' => 'Offer',
            'url' => get_permalink(),
            'price' => $price_to_show,
            'priceCurrency' => 'USD',
            'availability' => $stock_status,
            'seller' => array(
                '@type' => 'Organization',
                'name' => get_bloginfo('name')
            )
        )
    );
    
    // Output schema as JSON
    echo '<script type="application/ld+json">' . json_encode($schema) . '</script>';
}
add_action('wp_head', 'marblecraft_product_schema');