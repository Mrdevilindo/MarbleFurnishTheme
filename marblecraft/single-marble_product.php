<?php
/**
 * Template for displaying single marble product
 */

get_header();
?>

<main id="main" class="site-main container mx-auto my-8 px-4">

    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6">
                    <!-- Product Images -->
                    <div class="product-gallery">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="main-image mb-4">
                                <?php the_post_thumbnail('large', ['class' => 'w-full h-auto rounded-lg']); ?>
                            </div>
                            
                            <?php
                            // Get additional images (ACF gallery field or similar would be used in real implementation)
                            // This is a placeholder for demonstration
                            ?>
                            <div class="additional-images grid grid-cols-4 gap-2">
                                <div class="bg-gray-200 rounded-lg aspect-w-1 aspect-h-1 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image text-gray-500">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
                                </div>
                                <div class="bg-gray-200 rounded-lg aspect-w-1 aspect-h-1 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image text-gray-500">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
                                </div>
                                <div class="bg-gray-200 rounded-lg aspect-w-1 aspect-h-1 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image text-gray-500">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
                                </div>
                                <div class="bg-gray-200 rounded-lg aspect-w-1 aspect-h-1 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image text-gray-500">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="bg-gray-200 rounded-lg aspect-w-4 aspect-h-3 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image text-gray-500">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Product Details -->
                    <div class="product-details">
                        <h1 class="text-3xl font-bold mb-4"><?php the_title(); ?></h1>
                        
                        <?php
                        // Get product price and currency
                        $price = get_post_meta(get_the_ID(), '_product_price', true);
                        $currency = get_post_meta(get_the_ID(), '_product_currency', true);
                        
                        // Display price if available
                        if (!empty($price)) :
                            $currency_symbol = '';
                            switch ($currency) {
                                case 'USD':
                                    $currency_symbol = '$';
                                    break;
                                case 'EUR':
                                    $currency_symbol = '€';
                                    break;
                                case 'CNY':
                                    $currency_symbol = '¥';
                                    break;
                                default:
                                    $currency_symbol = '$';
                            }
                        ?>
                            <div class="price text-2xl font-bold text-blue-600 mb-4">
                                <?php echo esc_html($currency_symbol . $price); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="categories mb-4">
                            <?php
                            $categories = get_the_terms(get_the_ID(), 'product_category');
                            if ($categories && !is_wp_error($categories)) :
                            ?>
                                <div class="flex flex-wrap gap-2">
                                    <?php foreach ($categories as $category) : ?>
                                        <a href="<?php echo esc_url(get_term_link($category)); ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm px-3 py-1 rounded-full">
                                            <?php echo esc_html($category->name); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="description prose mb-6">
                            <?php the_content(); ?>
                        </div>
                        
                        <div class="actions flex flex-col space-y-4">
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="bg-blue-600 hover:bg-blue-700 text-white text-center font-bold py-3 px-6 rounded-lg transition duration-300">
                                <?php esc_html_e('Inquire About This Product', 'marblecraft'); ?>
                            </a>
                            
                            <button id="share-product" class="bg-gray-200 hover:bg-gray-300 text-gray-800 text-center font-bold py-3 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share-2 mr-2">
                                    <circle cx="18" cy="5" r="3"></circle>
                                    <circle cx="6" cy="12" r="3"></circle>
                                    <circle cx="18" cy="19" r="3"></circle>
                                    <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                                    <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                                </svg>
                                <?php esc_html_e('Share', 'marblecraft'); ?>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Additional Product Details -->
                <div class="p-6 border-t border-gray-200">
                    <h2 class="text-2xl font-bold mb-4"><?php esc_html_e('Product Specifications', 'marblecraft'); ?></h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-xl font-semibold mb-2"><?php esc_html_e('Material', 'marblecraft'); ?></h3>
                            <p><?php esc_html_e('Premium quality marble', 'marblecraft'); ?></p>
                        </div>
                        
                        <div>
                            <h3 class="text-xl font-semibold mb-2"><?php esc_html_e('Dimensions', 'marblecraft'); ?></h3>
                            <p><?php esc_html_e('Width x Depth x Height (Custom dimensions available upon request)', 'marblecraft'); ?></p>
                        </div>
                        
                        <div>
                            <h3 class="text-xl font-semibold mb-2"><?php esc_html_e('Weight', 'marblecraft'); ?></h3>
                            <p><?php esc_html_e('Varies by size and design', 'marblecraft'); ?></p>
                        </div>
                        
                        <div>
                            <h3 class="text-xl font-semibold mb-2"><?php esc_html_e('Care Instructions', 'marblecraft'); ?></h3>
                            <p><?php esc_html_e('Clean with mild soap and water. Avoid acidic cleaners.', 'marblecraft'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Related Products -->
            <?php
            $related_args = array(
                'post_type' => 'marble_product',
                'posts_per_page' => 3,
                'post__not_in' => array(get_the_ID()),
                'orderby' => 'rand',
            );
            
            // Get categories of current product to find related products
            $categories = get_the_terms(get_the_ID(), 'product_category');
            if ($categories && !is_wp_error($categories)) {
                $category_ids = array();
                foreach ($categories as $category) {
                    $category_ids[] = $category->term_id;
                }
                
                $related_args['tax_query'] = array(
                    array(
                        'taxonomy' => 'product_category',
                        'field' => 'term_id',
                        'terms' => $category_ids,
                    ),
                );
            }
            
            $related_query = new WP_Query($related_args);
            
            if ($related_query->have_posts()) :
            ?>
                <div class="related-products mt-8">
                    <h2 class="text-2xl font-bold mb-6"><?php esc_html_e('Related Products', 'marblecraft'); ?></h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
                            <?php get_template_part('template-parts/product-card'); ?>
                        <?php endwhile; ?>
                    </div>
                </div>
                
                <?php wp_reset_postdata(); ?>
            <?php endif; ?>
        </article>
    <?php endwhile; ?>

</main>

<?php get_footer(); ?>
