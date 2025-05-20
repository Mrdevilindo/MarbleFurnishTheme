<?php
/**
 * Template part for displaying product cards
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('product-card bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:-translate-y-1 hover:shadow-lg'); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <a href="<?php the_permalink(); ?>" class="block aspect-w-4 aspect-h-3 overflow-hidden">
            <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover transition-transform duration-500 hover:scale-105']); ?>
        </a>
    <?php else : ?>
        <a href="<?php the_permalink(); ?>" class="block aspect-w-4 aspect-h-3 bg-gray-200 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image text-gray-400">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                <polyline points="21 15 16 10 5 21"></polyline>
            </svg>
        </a>
    <?php endif; ?>
    
    <div class="p-4">
        <header class="mb-2">
            <h2 class="entry-title text-xl font-bold">
                <a href="<?php the_permalink(); ?>" class="hover:text-blue-600 transition-colors">
                    <?php the_title(); ?>
                </a>
            </h2>
        </header>
        
        <?php
        // Display product categories
        $categories = get_the_terms(get_the_ID(), 'product_category');
        if ($categories && !is_wp_error($categories)) :
        ?>
            <div class="categories mb-3">
                <div class="flex flex-wrap gap-1">
                    <?php foreach ($categories as $category) : ?>
                        <a href="<?php echo esc_url(get_term_link($category)); ?>" class="text-xs bg-gray-200 hover:bg-gray-300 text-gray-800 px-2 py-1 rounded-full">
                            <?php echo esc_html($category->name); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="excerpt text-gray-600 mb-4">
            <?php
            $excerpt = get_the_excerpt();
            echo wp_trim_words($excerpt, 12, '...');
            ?>
        </div>
        
        <?php
        // Display price if available
        $price = get_post_meta(get_the_ID(), '_product_price', true);
        $currency = get_post_meta(get_the_ID(), '_product_currency', true);
        
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
            <div class="price text-lg font-bold text-blue-600 mb-3">
                <?php echo esc_html($currency_symbol . $price); ?>
            </div>
        <?php endif; ?>
        
        <div class="actions flex justify-between">
            <a href="<?php the_permalink(); ?>" class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm py-2 px-4 rounded-md transition duration-300">
                <?php esc_html_e('View Details', 'marblecraft'); ?>
            </a>
            
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm py-2 px-4 rounded-md transition duration-300">
                <?php esc_html_e('Inquire', 'marblecraft'); ?>
            </a>
        </div>
    </div>
</article>
