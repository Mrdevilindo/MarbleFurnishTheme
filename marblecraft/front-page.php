<?php
/**
 * The template for displaying the front page
 */

get_header();

// Get hero section customizer settings
$hero_title = get_theme_mod('hero_title', __('Exquisite Marble Furniture', 'marblecraft'));
$hero_subtitle = get_theme_mod('hero_subtitle', __('Luxury craftsmanship for your home and office', 'marblecraft'));
$hero_image = get_theme_mod('hero_image', '');
$hero_cta_text = get_theme_mod('hero_cta_text', __('View Our Collection', 'marblecraft'));
$hero_cta_url = get_theme_mod('hero_cta_url', home_url('/products/'));
$hero_secondary_cta_text = get_theme_mod('hero_secondary_cta_text', __('Contact Us', 'marblecraft'));
$hero_secondary_cta_url = get_theme_mod('hero_secondary_cta_url', home_url('/contact/'));

// Get featured section customizer settings
$featured_section_title = get_theme_mod('featured_section_title', __('Featured Products', 'marblecraft'));
$featured_section_description = get_theme_mod('featured_section_description', __('Discover our handcrafted marble masterpieces', 'marblecraft'));

// Get about section customizer settings
$about_section_title = get_theme_mod('about_section_title', __('About MarbleCraft', 'marblecraft'));
$about_section_content = get_theme_mod('about_section_content', __('MarbleCraft has been creating luxury marble furniture for over two decades. Our craftsmen combine traditional techniques with modern design to produce unique pieces that elevate any space.', 'marblecraft'));
$about_section_image = get_theme_mod('about_section_image', '');
?>

<!-- Hero Section -->
<section class="hero-section relative <?php echo empty($hero_image) ? 'bg-gray-800' : ''; ?>">
    <?php if (!empty($hero_image)) : ?>
        <div class="absolute inset-0 z-0">
            <img src="<?php echo esc_url(wp_get_attachment_url($hero_image)); ?>" alt="<?php echo esc_attr($hero_title); ?>" class="w-full h-full object-cover" />
            <div class="absolute inset-0 bg-black opacity-40"></div>
        </div>
    <?php endif; ?>
    
    <div class="container mx-auto px-4 py-20 md:py-32 relative z-10">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 text-white"><?php echo esc_html($hero_title); ?></h1>
            <p class="text-xl text-white mb-8"><?php echo esc_html($hero_subtitle); ?></p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="<?php echo esc_url($hero_cta_url); ?>" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition duration-150 ease-in-out">
                    <?php echo esc_html($hero_cta_text); ?>
                </a>
                <a href="<?php echo esc_url($hero_secondary_cta_url); ?>" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-gray-50 transition duration-150 ease-in-out">
                    <?php echo esc_html($hero_secondary_cta_text); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="featured-products-section py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold mb-4"><?php echo esc_html($featured_section_title); ?></h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto"><?php echo esc_html($featured_section_description); ?></p>
        </div>
        
        <?php 
        // Display featured products
        echo do_shortcode('[featured_products count="4" orderby="date" order="DESC"]');
        ?>
        
        <div class="text-center mt-12">
            <a href="<?php echo esc_url(get_post_type_archive_link('marble_product')); ?>" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition duration-150 ease-in-out">
                <?php esc_html_e('View All Products', 'marblecraft'); ?>
            </a>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold mb-4"><?php esc_html_e('Product Categories', 'marblecraft'); ?></h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto"><?php esc_html_e('Browse our curated collections of marble furniture', 'marblecraft'); ?></p>
        </div>
        
        <?php
        $product_categories = get_terms(array(
            'taxonomy' => 'product_category',
            'hide_empty' => true,
            'parent' => 0,
        ));
        
        if (!empty($product_categories) && !is_wp_error($product_categories)) :
        ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($product_categories as $category) : 
                    // Get category image (ACF field) or use placeholder
                    $category_image = '';
                    if (function_exists('get_field')) {
                        $category_image = get_field('category_image', $category);
                    }
                ?>
                    <a href="<?php echo esc_url(get_term_link($category)); ?>" class="category-card group block relative overflow-hidden rounded-lg shadow-lg h-64">
                        <?php if (!empty($category_image)) : ?>
                            <img src="<?php echo esc_url($category_image); ?>" alt="<?php echo esc_attr($category->name); ?>" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" />
                        <?php else : ?>
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400"><?php esc_html_e('Category Image', 'marblecraft'); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent opacity-80"></div>
                        
                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                            <h3 class="text-xl font-bold mb-1"><?php echo esc_html($category->name); ?></h3>
                            <?php if (!empty($category->description)) : ?>
                                <p class="text-sm text-gray-200 mb-3"><?php echo esc_html($category->description); ?></p>
                            <?php endif; ?>
                            <span class="inline-flex items-center text-sm font-medium">
                                <?php esc_html_e('View Products', 'marblecraft'); ?>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="text-center text-gray-600">
                <p><?php esc_html_e('No product categories found.', 'marblecraft'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- About Section -->
<section class="about-section py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <?php if (!empty($about_section_image)) : ?>
                <div class="about-image rounded-lg overflow-hidden shadow-lg">
                    <img src="<?php echo esc_url(wp_get_attachment_url($about_section_image)); ?>" alt="<?php echo esc_attr($about_section_title); ?>" class="w-full h-auto" />
                </div>
            <?php endif; ?>
            
            <div class="about-content <?php echo empty($about_section_image) ? 'md:col-span-2 max-w-2xl mx-auto text-center' : ''; ?>">
                <h2 class="text-3xl font-bold mb-6"><?php echo esc_html($about_section_title); ?></h2>
                <div class="prose prose-lg max-w-none">
                    <?php echo wp_kses_post($about_section_content); ?>
                </div>
                
                <div class="mt-8">
                    <a href="<?php echo esc_url(home_url('/about/')); ?>" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-blue-600 bg-white hover:bg-gray-50 transition duration-150 ease-in-out">
                        <?php esc_html_e('Learn More About Us', 'marblecraft'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold mb-4"><?php esc_html_e('What Our Clients Say', 'marblecraft'); ?></h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto"><?php esc_html_e('Hear from our international customers about their experiences', 'marblecraft'); ?></p>
        </div>
        
        <?php 
        // Display testimonials
        echo do_shortcode('[testimonials count="3" layout="grid"]');
        ?>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section py-16 bg-blue-600 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-6"><?php esc_html_e('Ready to Transform Your Space?', 'marblecraft'); ?></h2>
        <p class="text-xl mb-8 max-w-2xl mx-auto"><?php esc_html_e('Contact us today to discuss your custom marble furniture needs or visit our showroom.', 'marblecraft'); ?></p>
        
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-gray-50 transition duration-150 ease-in-out">
                <?php esc_html_e('Contact Us', 'marblecraft'); ?>
            </a>
            <a href="<?php echo esc_url(get_post_type_archive_link('marble_product')); ?>" class="inline-flex items-center justify-center px-6 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-blue-700 transition duration-150 ease-in-out">
                <?php esc_html_e('Browse Products', 'marblecraft'); ?>
            </a>
        </div>
    </div>
</section>

<?php if (have_posts()) : ?>
    <section class="latest-news-section py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4"><?php esc_html_e('Latest News', 'marblecraft'); ?></h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto"><?php esc_html_e('Stay updated with our latest collections and industry insights', 'marblecraft'); ?></p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php 
                $latest_posts = new WP_Query(array(
                    'post_type' => 'post',
                    'posts_per_page' => 3,
                    'ignore_sticky_posts' => true,
                ));
                
                if ($latest_posts->have_posts()) :
                    while ($latest_posts->have_posts()) : $latest_posts->the_post();
                ?>
                    <article class="bg-white rounded-lg shadow-md overflow-hidden">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" class="block">
                                <?php the_post_thumbnail('medium', array('class' => 'w-full h-48 object-cover')); ?>
                            </a>
                        <?php endif; ?>
                        
                        <div class="p-6">
                            <div class="text-sm text-gray-500 mb-2"><?php echo get_the_date(); ?></div>
                            <h3 class="text-xl font-bold mb-3 hover:text-blue-600">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            
                            <div class="text-gray-600 mb-4">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                <?php esc_html_e('Read More', 'marblecraft'); ?>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </article>
                <?php 
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
            
            <div class="text-center mt-10">
                <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-blue-600 bg-white hover:bg-gray-50 transition duration-150 ease-in-out">
                    <?php esc_html_e('View All News', 'marblecraft'); ?>
                </a>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php get_footer(); ?>