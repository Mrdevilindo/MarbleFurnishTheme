<?php
/**
 * Shortcodes for MarbleCraft theme
 *
 * Register custom shortcodes for use in pages and posts
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Display featured products 
 * 
 * Usage: [featured_products count="4" category="table" material="marble"]
 */
function marblecraft_featured_products_shortcode($atts) {
    $atts = shortcode_atts(array(
        'count' => 4,
        'category' => '',
        'material' => '',
        'orderby' => 'date',
        'order' => 'DESC',
        'columns' => 4
    ), $atts, 'featured_products');
    
    // Query args
    $args = array(
        'post_type' => 'marble_product',
        'posts_per_page' => intval($atts['count']),
        'orderby' => sanitize_text_field($atts['orderby']),
        'order' => sanitize_text_field($atts['order']),
    );
    
    // Add tax query if category or material is specified
    $tax_query = array();
    
    if (!empty($atts['category'])) {
        $tax_query[] = array(
            'taxonomy' => 'product_category',
            'field' => 'slug',
            'terms' => sanitize_text_field($atts['category']),
        );
    }
    
    if (!empty($atts['material'])) {
        $tax_query[] = array(
            'taxonomy' => 'material',
            'field' => 'slug',
            'terms' => sanitize_text_field($atts['material']),
        );
    }
    
    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
        
        if (count($tax_query) > 1) {
            $args['tax_query']['relation'] = 'AND';
        }
    }
    
    // Run the query
    $products = new WP_Query($args);
    
    // Start output buffer
    ob_start();
    
    if ($products->have_posts()) :
        // Determine column classes based on columns attribute
        $column_classes = '';
        switch (intval($atts['columns'])) {
            case 1:
                $column_classes = 'grid-cols-1';
                break;
            case 2:
                $column_classes = 'grid-cols-1 sm:grid-cols-2';
                break;
            case 3:
                $column_classes = 'grid-cols-1 sm:grid-cols-2 md:grid-cols-3';
                break;
            case 4:
            default:
                $column_classes = 'grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4';
                break;
        }
    ?>
        <div class="featured-products">
            <div class="grid <?php echo esc_attr($column_classes); ?> gap-6">
                <?php while ($products->have_posts()) : $products->the_post(); 
                    $post_id = get_the_ID();
                    $price = get_post_meta($post_id, '_price', true);
                    $discount_price = get_post_meta($post_id, '_discount_price', true);
                    $stock = get_post_meta($post_id, '_stock', true);
                ?>
                    <div class="product-card bg-white rounded-lg shadow-md overflow-hidden transition duration-300 hover:shadow-lg">
                        <a href="<?php the_permalink(); ?>" class="block relative">
                            <?php if (has_post_thumbnail()) : ?>
                                <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-56 object-cover transition duration-300 hover:scale-105" />
                            <?php else : ?>
                                <div class="w-full h-56 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400">No image</span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($stock === 'out_of_stock') : ?>
                                <span class="absolute top-0 right-0 bg-red-500 text-white text-xs font-bold px-3 py-1 m-2 rounded-full">
                                    Out of Stock
                                </span>
                            <?php endif; ?>
                        </a>
                        
                        <div class="p-4">
                            <h3 class="product-title text-lg font-semibold mb-2 hover:text-blue-600">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            
                            <?php if (!empty($price)) : ?>
                                <div class="product-price mb-3">
                                    <?php if (!empty($discount_price)) : ?>
                                        <span class="text-lg font-semibold text-blue-600"><?php echo esc_html($discount_price); ?></span>
                                        <span class="text-sm text-gray-500 line-through ml-2"><?php echo esc_html($price); ?></span>
                                    <?php else : ?>
                                        <span class="text-lg font-semibold text-blue-600"><?php echo esc_html($price); ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="product-excerpt text-sm text-gray-600 mb-4">
                                <?php echo wp_trim_words(get_the_excerpt(), 12, '...'); ?>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <a href="<?php the_permalink(); ?>" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    View Details
                                </a>
                                
                                <?php if ($stock !== 'out_of_stock') : ?>
                                    <a href="<?php the_permalink(); ?>" class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm py-1 px-3 rounded-md transition duration-150 ease-in-out">
                                        Add to Cart
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php else : ?>
        <div class="no-products bg-white p-6 rounded-lg shadow-md text-center">
            <p class="text-gray-600">No products found.</p>
        </div>
    <?php
    endif;
    
    // Reset post data
    wp_reset_postdata();
    
    // Return the output buffer content
    return ob_get_clean();
}
add_shortcode('featured_products', 'marblecraft_featured_products_shortcode');

/**
 * Display a call to action banner
 * 
 * Usage: [cta_banner title="Contact Us Today" button_text="Get in Touch" button_url="/contact/" bg_color="#f0f9ff" text_color="#1e40af"]Your content here[/cta_banner]
 */
function marblecraft_cta_banner_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
        'title' => 'Get in Touch',
        'button_text' => 'Contact Us',
        'button_url' => '/contact/',
        'bg_color' => '#f0f9ff',
        'text_color' => '#1e40af',
        'alignment' => 'center'
    ), $atts, 'cta_banner');
    
    // Define alignment classes
    $align_class = 'text-center';
    if ($atts['alignment'] === 'left') {
        $align_class = 'text-left';
    } elseif ($atts['alignment'] === 'right') {
        $align_class = 'text-right';
    }
    
    // Inline styles for custom colors
    $bg_style = 'background-color: ' . esc_attr($atts['bg_color']) . ';';
    $text_style = 'color: ' . esc_attr($atts['text_color']) . ';';
    
    // Start output buffer
    ob_start();
    ?>
    <div class="cta-banner py-12 px-6 rounded-lg my-8 <?php echo esc_attr($align_class); ?>" style="<?php echo $bg_style; ?>">
        <h3 class="text-2xl font-bold mb-4" style="<?php echo $text_style; ?>"><?php echo esc_html($atts['title']); ?></h3>
        
        <?php if (!empty($content)) : ?>
            <div class="cta-content mb-6" style="<?php echo $text_style; ?>">
                <?php echo wp_kses_post($content); ?>
            </div>
        <?php endif; ?>
        
        <a href="<?php echo esc_url($atts['button_url']); ?>" class="inline-block bg-white hover:bg-gray-100 font-semibold py-3 px-6 rounded-md transition duration-300 ease-in-out" style="<?php echo $text_style; ?>">
            <?php echo esc_html($atts['button_text']); ?>
        </a>
    </div>
    <?php
    
    // Return the output buffer content
    return ob_get_clean();
}
add_shortcode('cta_banner', 'marblecraft_cta_banner_shortcode');

/**
 * Display a testimonial grid or slider
 * 
 * Usage: [testimonials count="3" layout="grid"]
 */
function marblecraft_testimonials_shortcode($atts) {
    $atts = shortcode_atts(array(
        'count' => 3,
        'layout' => 'grid', // grid or slider
        'columns' => 3,
    ), $atts, 'testimonials');
    
    // Query args to get testimonials
    $args = array(
        'post_type' => 'post',
        'category_name' => 'testimonial',
        'posts_per_page' => intval($atts['count']),
        'orderby' => 'date',
        'order' => 'DESC',
    );
    
    // Run the query
    $testimonials = new WP_Query($args);
    
    // Start output buffer
    ob_start();
    
    if ($testimonials->have_posts()) :
        // Determine column classes based on columns attribute
        $column_classes = '';
        switch (intval($atts['columns'])) {
            case 1:
                $column_classes = 'grid-cols-1';
                break;
            case 2:
                $column_classes = 'grid-cols-1 md:grid-cols-2';
                break;
            case 3:
            default:
                $column_classes = 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3';
                break;
            case 4:
                $column_classes = 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4';
                break;
        }
        
        // Add container based on layout
        if ($atts['layout'] === 'slider') {
            echo '<div class="testimonial-slider relative overflow-hidden">';
            echo '<div class="testimonial-slides flex">';
        } else {
            echo '<div class="testimonial-grid grid ' . esc_attr($column_classes) . ' gap-6">';
        }
        
        while ($testimonials->have_posts()) : $testimonials->the_post();
            // Testimonial card markup
            ?>
            <div class="testimonial-card bg-white rounded-lg shadow-md p-6 <?php echo ($atts['layout'] === 'slider') ? 'w-full flex-shrink-0' : ''; ?>">
                <div class="testimonial-content mb-4">
                    <svg class="text-blue-200 h-8 w-8 mb-2" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                        <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                    </svg>
                    <?php the_content(); ?>
                </div>
                
                <div class="testimonial-meta flex items-center">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="testimonial-avatar mr-4">
                            <?php the_post_thumbnail('thumbnail', array('class' => 'h-12 w-12 rounded-full')); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="testimonial-author">
                        <div class="font-medium text-gray-900"><?php the_title(); ?></div>
                        <?php 
                        $client_company = get_post_meta(get_the_ID(), '_client_company', true);
                        if (!empty($client_company)) : 
                        ?>
                            <div class="text-gray-500"><?php echo esc_html($client_company); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php
        endwhile;
        
        // Close container
        echo '</div>';
        
        // Add slider navigation if needed
        if ($atts['layout'] === 'slider') {
            ?>
            <button class="slider-nav prev absolute top-1/2 left-2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button class="slider-nav next absolute top-1/2 right-2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const slider = document.querySelector('.testimonial-slider');
                    const slides = slider.querySelector('.testimonial-slides');
                    const prevBtn = slider.querySelector('.slider-nav.prev');
                    const nextBtn = slider.querySelector('.slider-nav.next');
                    let currentSlide = 0;
                    const slideCount = slides.children.length;
                    
                    // Set up initial slides
                    function setupSlides() {
                        const slideWidth = slider.offsetWidth;
                        Array.from(slides.children).forEach(slide => {
                            slide.style.minWidth = `${slideWidth}px`;
                        });
                    }
                    
                    // Navigate to a specific slide
                    function goToSlide(index) {
                        if (index < 0) index = 0;
                        if (index >= slideCount) index = slideCount - 1;
                        
                        currentSlide = index;
                        const offset = -currentSlide * slider.offsetWidth;
                        slides.style.transform = `translateX(${offset}px)`;
                    }
                    
                    // Initialize slider
                    setupSlides();
                    window.addEventListener('resize', setupSlides);
                    
                    // Add event listeners for navigation
                    prevBtn.addEventListener('click', () => goToSlide(currentSlide - 1));
                    nextBtn.addEventListener('click', () => goToSlide(currentSlide + 1));
                });
            </script>
            <?php
        }
    else :
        echo '<div class="no-testimonials bg-white p-6 rounded-lg shadow-md text-center">';
        echo '<p class="text-gray-600">No testimonials found.</p>';
        echo '</div>';
    endif;
    
    // Reset post data
    wp_reset_postdata();
    
    // Return the output buffer content
    return ob_get_clean();
}
add_shortcode('testimonials', 'marblecraft_testimonials_shortcode');