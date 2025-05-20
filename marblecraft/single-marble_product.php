<?php
/**
 * Template for displaying single marble product
 */

get_header();

// Get product meta data
$price = get_post_meta(get_the_ID(), '_price', true);
$discount_price = get_post_meta(get_the_ID(), '_discount_price', true);
$sku = get_post_meta(get_the_ID(), '_sku', true);
$dimensions = get_post_meta(get_the_ID(), '_dimensions', true);
$weight = get_post_meta(get_the_ID(), '_weight', true);
$stock = get_post_meta(get_the_ID(), '_stock', true);

// Get materials
$materials = get_the_terms(get_the_ID(), 'material');
$material_list = '';
if (!empty($materials) && !is_wp_error($materials)) {
    $material_names = array();
    foreach ($materials as $material) {
        $material_names[] = $material->name;
    }
    $material_list = implode(', ', $material_names);
}

// Get product categories
$categories = get_the_terms(get_the_ID(), 'product_category');
?>

<main id="main" class="site-main product-page container mx-auto my-8 px-4">
    <div class="product-container bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Product Gallery -->
            <div class="product-gallery p-6">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="product-main-image mb-4">
                        <?php the_post_thumbnail('large', array('class' => 'w-full h-auto rounded-lg')); ?>
                    </div>
                    
                    <?php
                    // Get gallery images
                    $gallery_ids = get_post_meta(get_the_ID(), '_product_image_gallery', true);
                    if (!empty($gallery_ids)) {
                        $gallery_ids = explode(',', $gallery_ids);
                        echo '<div class="product-thumbnails grid grid-cols-4 gap-2">';
                        echo '<div class="thumbnail-item cursor-pointer"><img src="' . esc_url(get_the_post_thumbnail_url(get_the_ID(), 'thumbnail')) . '" class="w-full h-auto rounded border-2 border-blue-500" data-full="' . esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')) . '" alt="' . esc_attr(get_the_title()) . '"></div>';
                        
                        foreach ($gallery_ids as $id) {
                            echo '<div class="thumbnail-item cursor-pointer"><img src="' . esc_url(wp_get_attachment_image_url($id, 'thumbnail')) . '" class="w-full h-auto rounded border-2 border-transparent hover:border-blue-500" data-full="' . esc_url(wp_get_attachment_image_url($id, 'large')) . '" alt="' . esc_attr(get_the_title()) . '"></div>';
                        }
                        echo '</div>';
                    }
                    ?>
                <?php else : ?>
                    <div class="product-no-image bg-gray-100 rounded-lg flex items-center justify-center h-96">
                        <span class="text-gray-400"><?php esc_html_e('No image available', 'marblecraft'); ?></span>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Product Information -->
            <div class="product-info p-6">
                <h1 class="product-title text-3xl font-bold mb-4"><?php the_title(); ?></h1>
                
                <?php if (!empty($categories) && !is_wp_error($categories)) : ?>
                    <div class="product-categories mb-3">
                        <span class="text-sm text-gray-600"><?php esc_html_e('Category:', 'marblecraft'); ?></span>
                        <?php foreach ($categories as $category) : ?>
                            <a href="<?php echo esc_url(get_term_link($category)); ?>" class="text-sm text-blue-600 hover:underline"><?php echo esc_html($category->name); ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($price)) : ?>
                    <div class="product-price mb-6">
                        <?php if (!empty($discount_price)) : ?>
                            <span class="text-2xl font-semibold text-blue-600"><?php echo esc_html($discount_price); ?></span>
                            <span class="text-lg text-gray-500 line-through ml-2"><?php echo esc_html($price); ?></span>
                        <?php else : ?>
                            <span class="text-2xl font-semibold text-blue-600"><?php echo esc_html($price); ?></span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <div class="product-stock-status mb-6">
                    <?php
                    switch ($stock) {
                        case 'in_stock':
                            echo '<span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">' . __('In Stock', 'marblecraft') . '</span>';
                            break;
                        case 'out_of_stock':
                            echo '<span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">' . __('Out of Stock', 'marblecraft') . '</span>';
                            break;
                        case 'pre_order':
                            echo '<span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">' . __('Pre-Order', 'marblecraft') . '</span>';
                            break;
                        default:
                            // Default case if stock status is not set
                            break;
                    }
                    ?>
                </div>
                
                <div class="product-description mb-6">
                    <?php the_content(); ?>
                </div>
                
                <div class="product-details mb-6">
                    <h3 class="text-xl font-bold mb-3"><?php esc_html_e('Product Details', 'marblecraft'); ?></h3>
                    <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                        <?php if (!empty($sku)) : ?>
                            <div class="product-info-item">
                                <span class="text-gray-600"><?php esc_html_e('SKU:', 'marblecraft'); ?></span>
                                <span class="font-medium"><?php echo esc_html($sku); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($dimensions)) : ?>
                            <div class="product-info-item">
                                <span class="text-gray-600"><?php esc_html_e('Dimensions:', 'marblecraft'); ?></span>
                                <span class="font-medium"><?php echo esc_html($dimensions); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($weight)) : ?>
                            <div class="product-info-item">
                                <span class="text-gray-600"><?php esc_html_e('Weight:', 'marblecraft'); ?></span>
                                <span class="font-medium"><?php echo esc_html($weight); ?> kg</span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($material_list)) : ?>
                            <div class="product-info-item">
                                <span class="text-gray-600"><?php esc_html_e('Material:', 'marblecraft'); ?></span>
                                <span class="font-medium"><?php echo esc_html($material_list); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <?php if ($stock !== 'out_of_stock') : ?>
                    <div class="product-actions mb-8">
                        <div class="flex">
                            <div class="quantity mr-3">
                                <label for="product-quantity" class="sr-only"><?php esc_html_e('Quantity', 'marblecraft'); ?></label>
                                <input type="number" id="product-quantity" name="quantity" min="1" value="1" class="w-20 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <button type="button" class="add-to-cart bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                                <?php esc_html_e('Add to Cart', 'marblecraft'); ?>
                            </button>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="product-inquiry">
                    <h3 class="text-xl font-bold mb-3"><?php esc_html_e('Product Inquiry', 'marblecraft'); ?></h3>
                    <p class="mb-4"><?php esc_html_e('Interested in this product? Contact us for more information or to place a custom order.', 'marblecraft'); ?></p>
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>?product=<?php echo esc_attr(get_the_title()); ?>" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                        <?php esc_html_e('Contact Us About This Product', 'marblecraft'); ?>
                    </a>
                </div>
                
                <!-- Social Sharing -->
                <div class="product-sharing mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold mb-3"><?php esc_html_e('Share This Product', 'marblecraft'); ?></h3>
                    <div class="flex space-x-4">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url(get_permalink()); ?>" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:text-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                            </svg>
                        </a>
                        <a href="https://twitter.com/intent/tweet?text=<?php echo esc_attr(get_the_title()); ?>&url=<?php echo esc_url(get_permalink()); ?>" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter">
                                <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                            </svg>
                        </a>
                        <a href="https://pinterest.com/pin/create/button/?url=<?php echo esc_url(get_permalink()); ?>&media=<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>&description=<?php echo esc_attr(get_the_title()); ?>" target="_blank" rel="noopener noreferrer" class="text-red-600 hover:text-red-800">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-instagram">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>
                        </a>
                        <a href="mailto:?subject=<?php echo esc_attr(get_the_title()); ?>&body=<?php echo esc_url(get_permalink()); ?>" class="text-gray-600 hover:text-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    <?php
    // Get related products from same category
    if (!empty($categories)) {
        $category_ids = wp_list_pluck($categories, 'term_id');
        
        $related_args = array(
            'post_type'      => 'marble_product',
            'posts_per_page' => 4,
            'post__not_in'   => array(get_the_ID()),
            'tax_query'      => array(
                array(
                    'taxonomy' => 'product_category',
                    'field'    => 'term_id',
                    'terms'    => $category_ids,
                ),
            ),
        );
        
        $related_products = new WP_Query($related_args);
        
        if ($related_products->have_posts()) :
    ?>
        <section class="related-products mt-12">
            <h2 class="text-2xl font-bold mb-6"><?php esc_html_e('Related Products', 'marblecraft'); ?></h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php while ($related_products->have_posts()) : $related_products->the_post(); 
                    $rel_price = get_post_meta(get_the_ID(), '_price', true);
                ?>
                    <div class="product-card bg-white rounded-lg shadow-md overflow-hidden transition duration-300 hover:shadow-lg">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" class="block overflow-hidden">
                                <?php the_post_thumbnail('medium', array('class' => 'w-full h-56 object-cover transition-transform duration-500 hover:scale-105')); ?>
                            </a>
                        <?php endif; ?>
                        
                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-2 hover:text-blue-600">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            
                            <?php if (!empty($rel_price)) : ?>
                                <div class="text-blue-600 font-semibold"><?php echo esc_html($rel_price); ?></div>
                            <?php endif; ?>
                            
                            <div class="mt-4">
                                <a href="<?php the_permalink(); ?>" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    <?php esc_html_e('View Details', 'marblecraft'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    <?php
        endif;
        wp_reset_postdata();
    }
    ?>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle product gallery
        const mainImage = document.querySelector('.product-main-image img');
        const thumbnails = document.querySelectorAll('.thumbnail-item img');
        
        if (thumbnails.length > 0) {
            thumbnails.forEach(function(thumbnail) {
                thumbnail.addEventListener('click', function() {
                    // Update main image source
                    mainImage.src = this.getAttribute('data-full');
                    
                    // Update active thumbnail
                    thumbnails.forEach(function(thumb) {
                        thumb.classList.remove('border-blue-500');
                        thumb.classList.add('border-transparent');
                    });
                    this.classList.remove('border-transparent');
                    this.classList.add('border-blue-500');
                });
            });
        }
    });
</script>

<?php get_footer(); ?>