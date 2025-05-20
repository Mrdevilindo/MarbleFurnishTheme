<?php
/**
 * Custom Post Types for MarbleCraft Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Custom Post Type for Marble Products
 */
function marblecraft_register_product_cpt() {
    $labels = array(
        'name'                  => _x('Marble Products', 'Post type general name', 'marblecraft'),
        'singular_name'         => _x('Marble Product', 'Post type singular name', 'marblecraft'),
        'menu_name'             => _x('Marble Products', 'Admin Menu text', 'marblecraft'),
        'name_admin_bar'        => _x('Marble Product', 'Add New on Toolbar', 'marblecraft'),
        'add_new'               => __('Add New', 'marblecraft'),
        'add_new_item'          => __('Add New Marble Product', 'marblecraft'),
        'new_item'              => __('New Marble Product', 'marblecraft'),
        'edit_item'             => __('Edit Marble Product', 'marblecraft'),
        'view_item'             => __('View Marble Product', 'marblecraft'),
        'all_items'             => __('All Marble Products', 'marblecraft'),
        'search_items'          => __('Search Marble Products', 'marblecraft'),
        'parent_item_colon'     => __('Parent Marble Products:', 'marblecraft'),
        'not_found'             => __('No marble products found.', 'marblecraft'),
        'not_found_in_trash'    => __('No marble products found in Trash.', 'marblecraft'),
        'featured_image'        => __('Product Image', 'marblecraft'),
        'set_featured_image'    => __('Set product image', 'marblecraft'),
        'remove_featured_image' => __('Remove product image', 'marblecraft'),
        'use_featured_image'    => __('Use as product image', 'marblecraft'),
        'archives'              => __('Marble Product archives', 'marblecraft'),
        'insert_into_item'      => __('Insert into marble product', 'marblecraft'),
        'uploaded_to_this_item' => __('Uploaded to this marble product', 'marblecraft'),
        'filter_items_list'     => __('Filter marble products list', 'marblecraft'),
        'items_list_navigation' => __('Marble Products list navigation', 'marblecraft'),
        'items_list'            => __('Marble Products list', 'marblecraft'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'products'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-store',
        'supports'           => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'),
        'show_in_rest'       => true,
    );

    register_post_type('marble_product', $args);
}
add_action('init', 'marblecraft_register_product_cpt');

/**
 * Register Product Category Taxonomy
 */
function marblecraft_register_product_category_taxonomy() {
    $labels = array(
        'name'              => _x('Product Categories', 'taxonomy general name', 'marblecraft'),
        'singular_name'     => _x('Product Category', 'taxonomy singular name', 'marblecraft'),
        'search_items'      => __('Search Product Categories', 'marblecraft'),
        'all_items'         => __('All Product Categories', 'marblecraft'),
        'parent_item'       => __('Parent Product Category', 'marblecraft'),
        'parent_item_colon' => __('Parent Product Category:', 'marblecraft'),
        'edit_item'         => __('Edit Product Category', 'marblecraft'),
        'update_item'       => __('Update Product Category', 'marblecraft'),
        'add_new_item'      => __('Add New Product Category', 'marblecraft'),
        'new_item_name'     => __('New Product Category Name', 'marblecraft'),
        'menu_name'         => __('Product Categories', 'marblecraft'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'product-category'),
        'show_in_rest'      => true,
    );

    register_taxonomy('product_category', array('marble_product'), $args);
}
add_action('init', 'marblecraft_register_product_category_taxonomy');

/**
 * Add custom meta boxes for product prices
 */
function marblecraft_add_price_meta_box() {
    add_meta_box(
        'marblecraft_product_price',
        __('Product Details', 'marblecraft'),
        'marblecraft_product_price_callback',
        'marble_product',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'marblecraft_add_price_meta_box');

/**
 * Meta box callback function
 */
function marblecraft_product_price_callback($post) {
    // Add nonce for security
    wp_nonce_field('marblecraft_product_price_nonce', 'marblecraft_price_nonce');
    
    // Get existing values
    $price = get_post_meta($post->ID, '_product_price', true);
    $currency = get_post_meta($post->ID, '_product_currency', true) ?: 'USD';
    $is_featured = get_post_meta($post->ID, '_is_featured', true) ?: '0';
    
    ?>
    <p>
        <label for="marblecraft_price"><?php esc_html_e('Price:', 'marblecraft'); ?></label>
        <input type="text" id="marblecraft_price" name="marblecraft_price" value="<?php echo esc_attr($price); ?>" class="regular-text">
    </p>
    <p>
        <label for="marblecraft_currency"><?php esc_html_e('Currency:', 'marblecraft'); ?></label>
        <select id="marblecraft_currency" name="marblecraft_currency">
            <option value="USD" <?php selected($currency, 'USD'); ?>>USD ($)</option>
            <option value="EUR" <?php selected($currency, 'EUR'); ?>>EUR (€)</option>
            <option value="CNY" <?php selected($currency, 'CNY'); ?>>CNY (¥)</option>
        </select>
    </p>
    <p>
        <label for="marblecraft_is_featured">
            <input type="checkbox" id="marblecraft_is_featured" name="marblecraft_is_featured" value="1" <?php checked($is_featured, '1'); ?>>
            <?php esc_html_e('Feature this product on homepage', 'marblecraft'); ?>
        </label>
    </p>
    <?php
}

/**
 * Save meta box data
 */
function marblecraft_save_product_price($post_id) {
    // Check if nonce is set
    if (!isset($_POST['marblecraft_price_nonce'])) {
        return;
    }
    
    // Verify nonce
    if (!wp_verify_nonce($_POST['marblecraft_price_nonce'], 'marblecraft_product_price_nonce')) {
        return;
    }
    
    // Check if autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save price
    if (isset($_POST['marblecraft_price'])) {
        update_post_meta(
            $post_id,
            '_product_price',
            sanitize_text_field($_POST['marblecraft_price'])
        );
    }
    
    // Save currency
    if (isset($_POST['marblecraft_currency'])) {
        update_post_meta(
            $post_id,
            '_product_currency',
            sanitize_text_field($_POST['marblecraft_currency'])
        );
    }
    
    // Save featured status
    $is_featured = isset($_POST['marblecraft_is_featured']) ? '1' : '0';
    update_post_meta($post_id, '_is_featured', $is_featured);
}
add_action('save_post_marble_product', 'marblecraft_save_product_price');
