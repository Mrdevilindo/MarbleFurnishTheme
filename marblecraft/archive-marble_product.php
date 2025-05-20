<?php
/**
 * The template for displaying marble product archives
 */

get_header();
?>

<main id="main" class="site-main container mx-auto my-8 px-4">

    <header class="archive-header mb-8">
        <h1 class="page-title text-3xl font-bold">
            <?php
            if (is_tax('product_category')) {
                single_term_title();
            } else {
                esc_html_e('Marble Products', 'marblecraft');
            }
            ?>
        </h1>
        
        <?php
        // Show term description if available
        if (is_tax('product_category')) {
            $term_description = term_description();
            if (!empty($term_description)) {
                echo '<div class="term-description my-4 text-gray-600">' . $term_description . '</div>';
            }
        }
        ?>
    </header>
    
    <div class="product-filters mb-8">
        <h3 class="text-xl font-bold mb-4"><?php esc_html_e('Filter Products', 'marblecraft'); ?></h3>
        
        <?php
        // Get all product categories
        $categories = get_terms(array(
            'taxonomy' => 'product_category',
            'hide_empty' => true,
        ));
        
        // Current category
        $current_term = get_queried_object();
        $current_term_id = is_tax('product_category') ? $current_term->term_id : 0;
        ?>
        
        <div class="flex flex-wrap gap-2">
            <a href="<?php echo esc_url(get_post_type_archive_link('marble_product')); ?>" class="inline-block px-4 py-2 rounded-md text-sm <?php echo !is_tax('product_category') ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300 text-gray-800'; ?>">
                <?php esc_html_e('All', 'marblecraft'); ?>
            </a>
            
            <?php foreach ($categories as $category) : ?>
                <a href="<?php echo esc_url(get_term_link($category)); ?>" class="inline-block px-4 py-2 rounded-md text-sm <?php echo $current_term_id === $category->term_id ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300 text-gray-800'; ?>">
                    <?php echo esc_html($category->name); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    
    <?php if (have_posts()) : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/product-card'); ?>
            <?php endwhile; ?>
        </div>
        
        <div class="pagination-container mt-8">
            <?php
            the_posts_pagination(array(
                'mid_size'  => 2,
                'prev_text' => __('Previous', 'marblecraft'),
                'next_text' => __('Next', 'marblecraft'),
                'class'     => 'flex justify-center',
            ));
            ?>
        </div>
    <?php else : ?>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <p><?php esc_html_e('No products found.', 'marblecraft'); ?></p>
        </div>
    <?php endif; ?>

</main>

<?php get_footer(); ?>
