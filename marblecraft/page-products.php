<?php
/**
 * Template Name: Products Page
 */

get_header();
?>

<main id="main" class="site-main container mx-auto my-8 px-4">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('mb-8'); ?>>
            <div class="entry-content prose max-w-none mb-8">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; endif; ?>
    
    <div class="product-filters mb-8">
        <h3 class="text-xl font-bold mb-4"><?php esc_html_e('Filter Products', 'marblecraft'); ?></h3>
        
        <?php
        // Get all product categories
        $categories = get_terms(array(
            'taxonomy' => 'product_category',
            'hide_empty' => true,
        ));
        
        // Current category from URL
        $current_category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
        ?>
        
        <div class="flex flex-wrap gap-2">
            <a href="<?php echo esc_url(remove_query_arg('category')); ?>" class="inline-block px-4 py-2 rounded-md text-sm <?php echo empty($current_category) ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300 text-gray-800'; ?>">
                <?php esc_html_e('All', 'marblecraft'); ?>
            </a>
            
            <?php foreach ($categories as $category) : ?>
                <a href="<?php echo esc_url(add_query_arg('category', $category->slug)); ?>" class="inline-block px-4 py-2 rounded-md text-sm <?php echo $current_category === $category->slug ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300 text-gray-800'; ?>">
                    <?php echo esc_html($category->name); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    
    <?php
    // Set up the query
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    
    $args = array(
        'post_type' => 'marble_product',
        'posts_per_page' => 9,
        'paged' => $paged,
    );
    
    // Add category filter if set
    if (!empty($current_category)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_category',
                'field' => 'slug',
                'terms' => $current_category,
            ),
        );
    }
    
    $products_query = new WP_Query($args);
    
    if ($products_query->have_posts()) :
    ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php while ($products_query->have_posts()) : $products_query->the_post(); ?>
                <?php get_template_part('template-parts/product-card'); ?>
            <?php endwhile; ?>
        </div>
        
        <div class="pagination-container mt-8">
            <?php
            $big = 999999999; // an unlikely integer
            
            echo paginate_links(array(
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format' => '?paged=%#%',
                'current' => max(1, get_query_var('paged')),
                'total' => $products_query->max_num_pages,
                'prev_text' => '&laquo; ' . __('Previous', 'marblecraft'),
                'next_text' => __('Next', 'marblecraft') . ' &raquo;',
                'type' => 'list',
                'end_size' => 3,
                'mid_size' => 3,
            ));
            ?>
        </div>
        
        <?php wp_reset_postdata(); ?>
    <?php else : ?>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <p><?php esc_html_e('No products found.', 'marblecraft'); ?></p>
        </div>
    <?php endif; ?>

</main>

<?php get_footer(); ?>
