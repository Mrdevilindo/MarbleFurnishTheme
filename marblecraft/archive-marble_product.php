<?php
/**
 * The template for displaying marble product archive
 */

get_header();
?>

<main id="main" class="site-main container mx-auto my-8 px-4">
    <header class="page-header mb-8">
        <h1 class="page-title text-3xl font-bold">
            <?php
            if (is_tax('product_category')) {
                single_term_title();
            } elseif (is_tax('material')) {
                printf(__('%s Products', 'marblecraft'), single_term_title('', false));
            } else {
                _e('Marble Products', 'marblecraft');
            }
            ?>
        </h1>

        <?php
        // Show category/term description if available
        $term_description = term_description();
        if (!empty($term_description)) : ?>
            <div class="archive-description mt-4 text-gray-600">
                <?php echo wp_kses_post($term_description); ?>
            </div>
        <?php endif; ?>
    </header>

    <?php
    // Filter and sort controls
    $current_orderby = isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : 'date';
    $current_order = isset($_GET['order']) ? sanitize_text_field($_GET['order']) : 'desc';
    $current_category = isset($_GET['category']) ? (int) $_GET['category'] : 0;
    $current_material = isset($_GET['material']) ? (int) $_GET['material'] : 0;

    // Get all product categories and materials for filters
    $categories = get_terms([
        'taxonomy' => 'product_category',
        'hide_empty' => true,
    ]);

    $materials = get_terms([
        'taxonomy' => 'material',
        'hide_empty' => true,
    ]);
    ?>

    <div class="product-filters bg-white rounded-lg shadow-md p-4 mb-8">
        <form method="get" action="<?php echo esc_url(get_post_type_archive_link('marble_product')); ?>" class="grid md:grid-cols-4 gap-4">
            <div class="filter-group">
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1"><?php _e('Category', 'marblecraft'); ?></label>
                <select name="category" id="category" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value=""><?php _e('All Categories', 'marblecraft'); ?></option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo esc_attr($category->term_id); ?>" <?php selected($current_category, $category->term_id); ?>>
                            <?php echo esc_html($category->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <label for="material" class="block text-sm font-medium text-gray-700 mb-1"><?php _e('Material', 'marblecraft'); ?></label>
                <select name="material" id="material" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value=""><?php _e('All Materials', 'marblecraft'); ?></option>
                    <?php foreach ($materials as $material) : ?>
                        <option value="<?php echo esc_attr($material->term_id); ?>" <?php selected($current_material, $material->term_id); ?>>
                            <?php echo esc_html($material->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <label for="orderby" class="block text-sm font-medium text-gray-700 mb-1"><?php _e('Sort By', 'marblecraft'); ?></label>
                <select name="orderby" id="orderby" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="date" <?php selected($current_orderby, 'date'); ?>><?php _e('Date', 'marblecraft'); ?></option>
                    <option value="title" <?php selected($current_orderby, 'title'); ?>><?php _e('Name', 'marblecraft'); ?></option>
                    <option value="menu_order" <?php selected($current_orderby, 'menu_order'); ?>><?php _e('Featured', 'marblecraft'); ?></option>
                </select>
            </div>

            <div class="filter-group">
                <label for="order" class="block text-sm font-medium text-gray-700 mb-1"><?php _e('Order', 'marblecraft'); ?></label>
                <select name="order" id="order" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="desc" <?php selected($current_order, 'desc'); ?>><?php _e('Descending', 'marblecraft'); ?></option>
                    <option value="asc" <?php selected($current_order, 'asc'); ?>><?php _e('Ascending', 'marblecraft'); ?></option>
                </select>
            </div>

            <div class="md:col-span-4 flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <?php _e('Apply Filters', 'marblecraft'); ?>
                </button>
            </div>
        </form>
    </div>

    <?php if (have_posts()) : ?>
        <div class="products-grid grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php while (have_posts()) : the_post(); 
                // Get product price
                $price = get_post_meta(get_the_ID(), '_price', true);
                $discount_price = get_post_meta(get_the_ID(), '_discount_price', true);
                $stock = get_post_meta(get_the_ID(), '_stock', true);
            ?>
                <div class="product-card bg-white rounded-lg shadow-md overflow-hidden transition duration-300 hover:shadow-lg">
                    <a href="<?php the_permalink(); ?>" class="block relative">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('marblecraft-product-thumbnail', array('class' => 'w-full h-56 object-cover transition duration-300 hover:scale-105')); ?>
                        <?php else : ?>
                            <div class="w-full h-56 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400"><?php _e('No image', 'marblecraft'); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($stock === 'out_of_stock') : ?>
                            <span class="absolute top-0 right-0 bg-red-500 text-white text-xs font-bold px-3 py-1 m-2 rounded-full">
                                <?php _e('Out of Stock', 'marblecraft'); ?>
                            </span>
                        <?php endif; ?>
                    </a>
                    
                    <div class="p-4">
                        <h2 class="product-title text-lg font-semibold mb-2 hover:text-blue-600">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        
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
                            <?php the_excerpt(); ?>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <a href="<?php the_permalink(); ?>" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                <?php _e('View Details', 'marblecraft'); ?>
                            </a>
                            
                            <?php if ($stock !== 'out_of_stock') : ?>
                                <button type="button" class="quick-add-to-cart bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm py-1 px-3 rounded-md transition duration-150 ease-in-out">
                                    <?php _e('Add to Cart', 'marblecraft'); ?>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <?php 
        // Pagination
        $pagination = get_the_posts_pagination(array(
            'mid_size'  => 2,
            'prev_text' => __('Previous', 'marblecraft'),
            'next_text' => __('Next', 'marblecraft'),
            'screen_reader_text' => __('Products navigation', 'marblecraft'),
        ));
        
        if ($pagination) : ?>
            <div class="pagination-container mt-8">
                <?php echo $pagination; ?>
            </div>
        <?php endif; ?>

    <?php else : ?>
        <div class="no-products bg-white p-8 rounded-lg shadow-md text-center">
            <h2 class="text-xl font-bold mb-4"><?php _e('No products found', 'marblecraft'); ?></h2>
            <p class="text-gray-600"><?php _e('Sorry, no marble products match your criteria. Try different filters or browse our other collections.', 'marblecraft'); ?></p>
            
            <a href="<?php echo esc_url(get_post_type_archive_link('marble_product')); ?>" class="inline-block mt-6 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                <?php _e('View All Products', 'marblecraft'); ?>
            </a>
        </div>
    <?php endif; ?>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit filters on change (optional feature)
    const filterSelects = document.querySelectorAll('.product-filters select');
    const autoSubmit = false; // Set to true to enable auto-submit on filter change
    
    if (autoSubmit) {
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                this.closest('form').submit();
            });
        });
    }
    
    // Quick add to cart buttons
    const quickAddButtons = document.querySelectorAll('.quick-add-to-cart');
    quickAddButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get product link from parent card
            const productCard = this.closest('.product-card');
            const productLink = productCard.querySelector('a').getAttribute('href');
            
            // Navigate to product page
            window.location.href = productLink;
        });
    });
});
</script>

<?php get_footer(); ?>