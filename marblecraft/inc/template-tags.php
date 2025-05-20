<?php
/**
 * Custom template tags for MarbleCraft theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
if (!function_exists('marblecraft_posted_on')) :
    function marblecraft_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date('c')),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date('c')),
            esc_html(get_the_modified_date())
        );

        echo '<span class="posted-on">' . $time_string . '</span>';
    }
endif;

/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
if (!function_exists('marblecraft_entry_footer')) :
    function marblecraft_entry_footer() {
        // Hide category and tag text for pages.
        if ('post' === get_post_type()) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list(esc_html__(', ', 'marblecraft'));
            if ($categories_list) {
                printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'marblecraft') . '</span>', $categories_list);
            }

            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list('', esc_html__(', ', 'marblecraft'));
            if ($tags_list) {
                printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'marblecraft') . '</span>', $tags_list);
            }
        }

        if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
            echo '<span class="comments-link">';
            comments_popup_link(
                sprintf(
                    wp_kses(
                        /* translators: %s: post title */
                        __('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'marblecraft'),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    get_the_title()
                )
            );
            echo '</span>';
        }

        edit_post_link(
            sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                    __('Edit <span class="screen-reader-text">%s</span>', 'marblecraft'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }
endif;

/**
 * Display category list for a post
 */
if (!function_exists('marblecraft_post_categories')) :
    function marblecraft_post_categories() {
        if ('post' !== get_post_type()) {
            return;
        }
        
        $categories = get_the_category();
        if (empty($categories)) {
            return;
        }
        
        echo '<div class="post-categories">';
        foreach ($categories as $category) {
            echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="category-link">' . esc_html($category->name) . '</a>';
        }
        echo '</div>';
    }
endif;

/**
 * Display post thumbnail with responsive image sizes
 */
if (!function_exists('marblecraft_post_thumbnail')) :
    function marblecraft_post_thumbnail($size = 'post-thumbnail', $class = '') {
        if (!post_password_required() && !is_attachment() && has_post_thumbnail()) {
            echo '<div class="post-thumbnail ' . esc_attr($class) . '">';
            the_post_thumbnail($size);
            echo '</div>';
        }
    }
endif;

/**
 * Display breadcrumbs
 */
if (!function_exists('marblecraft_breadcrumbs')) :
    function marblecraft_breadcrumbs() {
        // Skip if we're on the home page
        if (is_front_page()) {
            return;
        }
        
        echo '<div class="breadcrumbs text-sm text-gray-600 mb-6">';
        
        // Home link
        echo '<a href="' . esc_url(home_url('/')) . '" rel="home">' . esc_html__('Home', 'marblecraft') . '</a>';
        
        // Separator
        echo ' <span class="separator">/</span> ';
        
        if (is_category() || is_single()) {
            if (is_single()) {
                // If it's a post, show the categories first
                $categories = get_the_category();
                if (!empty($categories)) {
                    echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a>';
                    echo ' <span class="separator">/</span> ';
                }
                // Then show the post title
                echo '<span class="current">' . get_the_title() . '</span>';
            } else {
                // If it's a category archive
                echo '<span class="current">' . single_cat_title('', false) . '</span>';
            }
        } elseif (is_tax()) {
            // Taxonomy archive
            $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
            echo '<span class="current">' . esc_html($term->name) . '</span>';
        } elseif (is_page()) {
            // If it's a page, show the page title
            echo '<span class="current">' . get_the_title() . '</span>';
        } elseif (is_search()) {
            // Search results page
            echo '<span class="current">' . esc_html__('Search Results', 'marblecraft') . '</span>';
        } elseif (is_404()) {
            // 404 page
            echo '<span class="current">' . esc_html__('Page Not Found', 'marblecraft') . '</span>';
        } elseif (is_archive()) {
            // Other archives
            echo '<span class="current">' . get_the_archive_title() . '</span>';
        }
        
        echo '</div>';
    }
endif;

/**
 * Get related products based on category
 */
if (!function_exists('marblecraft_get_related_products')) :
    function marblecraft_get_related_products($post_id, $number = 4) {
        $related_posts = array();
        
        // Get the current post type
        $post_type = get_post_type($post_id);
        
        // Only proceed if it's a marble_product
        if ($post_type === 'marble_product') {
            // Get categories of the current product
            $categories = get_the_terms($post_id, 'product_category');
            
            if (!empty($categories) && !is_wp_error($categories)) {
                $category_ids = wp_list_pluck($categories, 'term_id');
                
                // Query related products
                $args = array(
                    'post_type'      => 'marble_product',
                    'posts_per_page' => $number,
                    'post__not_in'   => array($post_id),
                    'tax_query'      => array(
                        array(
                            'taxonomy' => 'product_category',
                            'field'    => 'term_id',
                            'terms'    => $category_ids,
                        ),
                    ),
                );
                
                $related = new WP_Query($args);
                
                if ($related->have_posts()) {
                    while ($related->have_posts()) {
                        $related->the_post();
                        $related_posts[] = get_the_ID();
                    }
                }
                
                wp_reset_postdata();
            }
        }
        
        return $related_posts;
    }
endif;

/**
 * Get product price with format
 */
if (!function_exists('marblecraft_get_product_price_html')) :
    function marblecraft_get_product_price_html($post_id) {
        $price = get_post_meta($post_id, '_price', true);
        $discount_price = get_post_meta($post_id, '_discount_price', true);
        
        if (empty($price)) {
            return '';
        }
        
        $html = '';
        
        if (!empty($discount_price)) {
            $html .= '<span class="product-price">';
            $html .= '<span class="current-price">' . esc_html($discount_price) . '</span>';
            $html .= '<span class="regular-price">' . esc_html($price) . '</span>';
            $html .= '</span>';
        } else {
            $html .= '<span class="product-price">';
            $html .= '<span class="current-price">' . esc_html($price) . '</span>';
            $html .= '</span>';
        }
        
        return $html;
    }
endif;

/**
 * Get stock status html
 */
if (!function_exists('marblecraft_get_stock_status_html')) :
    function marblecraft_get_stock_status_html($post_id) {
        $stock = get_post_meta($post_id, '_stock', true);
        
        if (empty($stock)) {
            return '';
        }
        
        $html = '';
        
        switch ($stock) {
            case 'in_stock':
                $html = '<span class="stock-status in-stock">' . __('In Stock', 'marblecraft') . '</span>';
                break;
                
            case 'out_of_stock':
                $html = '<span class="stock-status out-of-stock">' . __('Out of Stock', 'marblecraft') . '</span>';
                break;
                
            case 'pre_order':
                $html = '<span class="stock-status pre-order">' . __('Pre-Order', 'marblecraft') . '</span>';
                break;
                
            default:
                break;
        }
        
        return $html;
    }
endif;