<?php
/**
 * MarbleCraft Custom Post Types
 *
 * This file registers custom post types and taxonomies for the theme.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Register custom post types and taxonomies
 */
function marblecraft_register_custom_post_types() {
    // Register Marble Products Post Type
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
        'rewrite'            => array('slug' => 'marble-products'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-format-gallery',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest'       => true,
    );

    register_post_type('marble_product', $args);

    // Register Product Category Taxonomy
    $cat_labels = array(
        'name'                       => _x('Product Categories', 'taxonomy general name', 'marblecraft'),
        'singular_name'              => _x('Product Category', 'taxonomy singular name', 'marblecraft'),
        'search_items'               => __('Search Product Categories', 'marblecraft'),
        'popular_items'              => __('Popular Product Categories', 'marblecraft'),
        'all_items'                  => __('All Product Categories', 'marblecraft'),
        'parent_item'                => __('Parent Product Category', 'marblecraft'),
        'parent_item_colon'          => __('Parent Product Category:', 'marblecraft'),
        'edit_item'                  => __('Edit Product Category', 'marblecraft'),
        'update_item'                => __('Update Product Category', 'marblecraft'),
        'add_new_item'               => __('Add New Product Category', 'marblecraft'),
        'new_item_name'              => __('New Product Category Name', 'marblecraft'),
        'separate_items_with_commas' => __('Separate product categories with commas', 'marblecraft'),
        'add_or_remove_items'        => __('Add or remove product categories', 'marblecraft'),
        'choose_from_most_used'      => __('Choose from the most used product categories', 'marblecraft'),
        'not_found'                  => __('No product categories found.', 'marblecraft'),
        'menu_name'                  => __('Product Categories', 'marblecraft'),
    );

    $cat_args = array(
        'hierarchical'          => true,
        'labels'                => $cat_labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'query_var'             => true,
        'rewrite'               => array('slug' => 'product-category'),
        'show_in_rest'          => true,
    );

    register_taxonomy('product_category', 'marble_product', $cat_args);

    // Register Material Taxonomy
    $material_labels = array(
        'name'                       => _x('Materials', 'taxonomy general name', 'marblecraft'),
        'singular_name'              => _x('Material', 'taxonomy singular name', 'marblecraft'),
        'search_items'               => __('Search Materials', 'marblecraft'),
        'popular_items'              => __('Popular Materials', 'marblecraft'),
        'all_items'                  => __('All Materials', 'marblecraft'),
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => __('Edit Material', 'marblecraft'),
        'update_item'                => __('Update Material', 'marblecraft'),
        'add_new_item'               => __('Add New Material', 'marblecraft'),
        'new_item_name'              => __('New Material Name', 'marblecraft'),
        'separate_items_with_commas' => __('Separate materials with commas', 'marblecraft'),
        'add_or_remove_items'        => __('Add or remove materials', 'marblecraft'),
        'choose_from_most_used'      => __('Choose from the most used materials', 'marblecraft'),
        'not_found'                  => __('No materials found.', 'marblecraft'),
        'menu_name'                  => __('Materials', 'marblecraft'),
    );

    $material_args = array(
        'hierarchical'          => false,
        'labels'                => $material_labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'query_var'             => true,
        'rewrite'               => array('slug' => 'material'),
        'show_in_rest'          => true,
    );

    register_taxonomy('material', 'marble_product', $material_args);

    // Flush rewrite rules only on theme activation
    if (get_option('marblecraft_flush_rewrite_rules')) {
        flush_rewrite_rules();
        delete_option('marblecraft_flush_rewrite_rules');
    }
}
add_action('init', 'marblecraft_register_custom_post_types');

/**
 * Set flag to flush rewrite rules on theme activation
 */
function marblecraft_rewrite_flush() {
    add_option('marblecraft_flush_rewrite_rules', true);
}
register_activation_hook(__FILE__, 'marblecraft_rewrite_flush');

/**
 * Add custom meta boxes for Marble Products
 */
function marblecraft_add_meta_boxes() {
    add_meta_box(
        'marble_product_details',
        __('Product Details', 'marblecraft'),
        'marblecraft_product_details_callback',
        'marble_product',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'marblecraft_add_meta_boxes');

/**
 * Product details meta box callback
 */
function marblecraft_product_details_callback($post) {
    // Add nonce for security
    wp_nonce_field('marblecraft_product_details_nonce', 'marblecraft_product_details_nonce');
    
    // Get stored meta values
    $price = get_post_meta($post->ID, '_price', true);
    $discount_price = get_post_meta($post->ID, '_discount_price', true);
    $sku = get_post_meta($post->ID, '_sku', true);
    $dimensions = get_post_meta($post->ID, '_dimensions', true);
    $weight = get_post_meta($post->ID, '_weight', true);
    $stock = get_post_meta($post->ID, '_stock', true);
    
    // Display fields
    ?>
    <div class="marble-product-details-wrap">
        <p>
            <label for="price"><?php _e('Price', 'marblecraft'); ?></label>
            <input type="text" id="price" name="price" value="<?php echo esc_attr($price); ?>" class="regular-text" />
        </p>
        
        <p>
            <label for="discount_price"><?php _e('Discount Price', 'marblecraft'); ?></label>
            <input type="text" id="discount_price" name="discount_price" value="<?php echo esc_attr($discount_price); ?>" class="regular-text" />
            <span class="description"><?php _e('Leave empty if no discount', 'marblecraft'); ?></span>
        </p>
        
        <p>
            <label for="sku"><?php _e('SKU', 'marblecraft'); ?></label>
            <input type="text" id="sku" name="sku" value="<?php echo esc_attr($sku); ?>" class="regular-text" />
        </p>
        
        <p>
            <label for="dimensions"><?php _e('Dimensions (L x W x H)', 'marblecraft'); ?></label>
            <input type="text" id="dimensions" name="dimensions" value="<?php echo esc_attr($dimensions); ?>" class="regular-text" />
            <span class="description"><?php _e('e.g. 80 x 40 x 75 cm', 'marblecraft'); ?></span>
        </p>
        
        <p>
            <label for="weight"><?php _e('Weight (kg)', 'marblecraft'); ?></label>
            <input type="text" id="weight" name="weight" value="<?php echo esc_attr($weight); ?>" class="regular-text" />
        </p>
        
        <p>
            <label for="stock"><?php _e('Stock Status', 'marblecraft'); ?></label>
            <select id="stock" name="stock">
                <option value="in_stock" <?php selected($stock, 'in_stock'); ?>><?php _e('In Stock', 'marblecraft'); ?></option>
                <option value="out_of_stock" <?php selected($stock, 'out_of_stock'); ?>><?php _e('Out of Stock', 'marblecraft'); ?></option>
                <option value="pre_order" <?php selected($stock, 'pre_order'); ?>><?php _e('Pre-Order', 'marblecraft'); ?></option>
            </select>
        </p>
    </div>
    <?php
}

/**
 * Save product details meta box data
 */
function marblecraft_save_product_details($post_id) {
    // Check if nonce is set
    if (!isset($_POST['marblecraft_product_details_nonce'])) {
        return;
    }
    
    // Verify that the nonce is valid
    if (!wp_verify_nonce($_POST['marblecraft_product_details_nonce'], 'marblecraft_product_details_nonce')) {
        return;
    }
    
    // If this is an autosave, don't do anything
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check the user's permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Sanitize and save the data
    if (isset($_POST['price'])) {
        update_post_meta($post_id, '_price', sanitize_text_field($_POST['price']));
    }
    
    if (isset($_POST['discount_price'])) {
        update_post_meta($post_id, '_discount_price', sanitize_text_field($_POST['discount_price']));
    }
    
    if (isset($_POST['sku'])) {
        update_post_meta($post_id, '_sku', sanitize_text_field($_POST['sku']));
    }
    
    if (isset($_POST['dimensions'])) {
        update_post_meta($post_id, '_dimensions', sanitize_text_field($_POST['dimensions']));
    }
    
    if (isset($_POST['weight'])) {
        update_post_meta($post_id, '_weight', sanitize_text_field($_POST['weight']));
    }
    
    if (isset($_POST['stock'])) {
        update_post_meta($post_id, '_stock', sanitize_text_field($_POST['stock']));
    }
}
add_action('save_post_marble_product', 'marblecraft_save_product_details');

/**
 * Add custom columns to product admin list
 */
function marblecraft_product_columns($columns) {
    $new_columns = array();
    // Insert thumbnail after checkbox
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key === 'cb') {
            $new_columns['thumbnail'] = __('Image', 'marblecraft');
        }
    }
    
    // Add price column
    $new_columns['price'] = __('Price', 'marblecraft');
    
    // Add stock status
    $new_columns['stock'] = __('Stock Status', 'marblecraft');
    
    return $new_columns;
}
add_filter('manage_marble_product_posts_columns', 'marblecraft_product_columns');

/**
 * Display custom columns content
 */
function marblecraft_product_custom_column($column, $post_id) {
    switch ($column) {
        case 'thumbnail':
            echo get_the_post_thumbnail($post_id, array(50, 50));
            break;
            
        case 'price':
            $price = get_post_meta($post_id, '_price', true);
            $discount_price = get_post_meta($post_id, '_discount_price', true);
            
            if (!empty($price)) {
                echo esc_html($price);
                
                if (!empty($discount_price)) {
                    echo ' <span class="discount-price">(' . esc_html($discount_price) . ')</span>';
                }
            } else {
                echo '-';
            }
            break;
            
        case 'stock':
            $stock = get_post_meta($post_id, '_stock', true);
            
            switch ($stock) {
                case 'in_stock':
                    echo '<span class="stock-status in-stock">' . __('In Stock', 'marblecraft') . '</span>';
                    break;
                    
                case 'out_of_stock':
                    echo '<span class="stock-status out-of-stock">' . __('Out of Stock', 'marblecraft') . '</span>';
                    break;
                    
                case 'pre_order':
                    echo '<span class="stock-status pre-order">' . __('Pre-Order', 'marblecraft') . '</span>';
                    break;
                    
                default:
                    echo '-';
                    break;
            }
            break;
    }
}
add_action('manage_marble_product_posts_custom_column', 'marblecraft_product_custom_column', 10, 2);

/**
 * Make custom columns sortable
 */
function marblecraft_product_sortable_columns($columns) {
    $columns['price'] = 'price';
    $columns['stock'] = 'stock';
    return $columns;
}
add_filter('manage_edit-marble_product_sortable_columns', 'marblecraft_product_sortable_columns');