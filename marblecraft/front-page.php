<?php
/**
 * Template for the front page
 */

get_header();
?>

<?php
// Get hero background image
$hero_bg = get_theme_mod('hero_background_image', get_template_directory_uri() . '/assets/images/hero-placeholder.svg');
$hero_style = $hero_bg ? 'background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(' . esc_url($hero_bg) . ');' : '';
?>
<div class="hero-section relative h-screen min-h-[500px] flex items-center justify-center text-center" style="<?php echo $hero_style; ?>">
    <div class="absolute inset-0 bg-gradient-to-r from-gray-900 to-transparent opacity-70"></div>
    <div class="container mx-auto px-4 z-10">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">
            <?php 
            // Get language-specific hero title
            $current_lang = 'en'; // Default language
            
            if (function_exists('pll_current_language')) {
                $current_lang = pll_current_language();
            } elseif (function_exists('icl_object_id') && defined('ICL_LANGUAGE_CODE')) {
                $current_lang = ICL_LANGUAGE_CODE;
            }
            
            if ($current_lang == 'zh') {
                echo esc_html(get_theme_mod('hero_title_zh', __('优雅的大理石家具', 'marblecraft')));
            } elseif ($current_lang == 'es') {
                echo esc_html(get_theme_mod('hero_title_es', __('Muebles de Mármol Elegantes', 'marblecraft')));
            } else {
                echo esc_html(get_theme_mod('hero_title_en', __('Elegant Marble Furniture', 'marblecraft')));
            }
            ?>
        </h1>
        
        <div class="language-specific-content">
            <p class="text-xl md:text-2xl text-white mb-8 max-w-3xl mx-auto">
                <?php
                if ($current_lang == 'zh') {
                    echo esc_html(get_theme_mod('hero_subtitle_zh', __('发现我们手工制作的大理石家具，永恒的优雅与现代设计相结合。', 'marblecraft')));
                } elseif ($current_lang == 'es') {
                    echo esc_html(get_theme_mod('hero_subtitle_es', __('Descubra nuestros muebles de mármol hechos a mano, donde la elegancia atemporal se une al diseño moderno.', 'marblecraft')));
                } else {
                    echo esc_html(get_theme_mod('hero_subtitle_en', __('Discover our handcrafted marble furniture, where timeless elegance meets modern design.', 'marblecraft')));
                }
                ?>
            </p>
        </div>
        
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="<?php echo esc_url(get_theme_mod('hero_button1_url', get_permalink(get_page_by_path('products')))); ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                <?php echo esc_html(get_theme_mod('hero_button1_text', __('View Our Collection', 'marblecraft'))); ?>
            </a>
            <a href="<?php echo esc_url(get_theme_mod('hero_button2_url', get_permalink(get_page_by_path('contact')))); ?>" class="bg-transparent hover:bg-white text-white hover:text-blue-600 font-bold py-3 px-6 rounded-lg border-2 border-white transition duration-300">
                <?php echo esc_html(get_theme_mod('hero_button2_text', __('Contact Us', 'marblecraft'))); ?>
            </a>
        </div>
    </div>
</div>

<section class="featured-products py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12">
            <?php echo esc_html(get_theme_mod('featured_products_title', __('Featured Products', 'marblecraft'))); ?>
        </h2>
        
        <?php 
        $count = get_theme_mod('featured_products_count', 3);
        echo do_shortcode('[marblecraft_featured_products count="' . esc_attr($count) . '"]'); 
        ?>
        
        <div class="text-center mt-12">
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('products'))); ?>" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                <?php echo esc_html(get_theme_mod('featured_products_button_text', __('View All Products', 'marblecraft'))); ?>
            </a>
        </div>
    </div>
</section>

<section class="about-section py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold mb-6">
                    <?php echo esc_html(get_theme_mod('about_section_title', __('Craftsmanship Beyond Compare', 'marblecraft'))); ?>
                </h2>
                
                <div class="text-lg text-gray-700 mb-6">
                    <?php echo wp_kses_post(get_theme_mod('about_section_content', __('At MarbleCraft, we transform natural marble into exquisite furniture pieces that bring timeless elegance to any space. Each piece is carefully crafted by skilled artisans with decades of experience working with this precious stone.', 'marblecraft'))); ?>
                </div>
                
                <a href="<?php echo esc_url(get_theme_mod('about_section_button_url', get_permalink(get_page_by_path('about-us')))); ?>" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                    <?php echo esc_html(get_theme_mod('about_section_button_text', __('Learn More About Us', 'marblecraft'))); ?>
                </a>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="grid grid-cols-2 gap-4">
                    <?php for ($i = 1; $i <= 4; $i++) : ?>
                        <div class="aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg overflow-hidden">
                            <?php 
                            $gallery_image = get_theme_mod("about_gallery_image_{$i}", '');
                            if (!empty($gallery_image)) : 
                            ?>
                                <img src="<?php echo esc_url($gallery_image); ?>" alt="<?php echo esc_attr(sprintf(__('Gallery Image %d', 'marblecraft'), $i)); ?>" class="w-full h-full object-cover">
                            <?php else : ?>
                                <div class="w-full h-full flex items-center justify-center text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="testimonials py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12">
            <?php esc_html_e('What Our Clients Say', 'marblecraft'); ?>
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Testimonial 1 -->
            <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                <div class="text-yellow-500 flex mb-4">
                    <?php for ($i = 0; $i < 5; $i++) : ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" stroke="none">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                        </svg>
                    <?php endfor; ?>
                </div>
                <p class="text-gray-700 mb-4">"<?php esc_html_e('The marble dining table we purchased is absolutely stunning. The craftsmanship is exceptional, and it has become the centerpiece of our dining room. Highly recommended!', 'marblecraft'); ?>"</p>
                <div class="font-bold">- John D., <?php esc_html_e('New York', 'marblecraft'); ?></div>
            </div>
            
            <!-- Testimonial 2 -->
            <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                <div class="text-yellow-500 flex mb-4">
                    <?php for ($i = 0; $i < 5; $i++) : ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" stroke="none">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                        </svg>
                    <?php endfor; ?>
                </div>
                <p class="text-gray-700 mb-4">"<?php esc_html_e('We ordered custom marble side tables for our hotel lobby. The quality exceeded our expectations, and the communication throughout the process was excellent.', 'marblecraft'); ?>"</p>
                <div class="font-bold">- Maria S., <?php esc_html_e('Barcelona', 'marblecraft'); ?></div>
            </div>
            
            <!-- Testimonial 3 -->
            <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                <div class="text-yellow-500 flex mb-4">
                    <?php for ($i = 0; $i < 5; $i++) : ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" stroke="none">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                        </svg>
                    <?php endfor; ?>
                </div>
                <p class="text-gray-700 mb-4">"<?php esc_html_e('The marble coffee table I purchased is a true work of art. The veining in the marble is beautiful, and the design is both elegant and functional. Worth every penny.', 'marblecraft'); ?>"</p>
                <div class="font-bold">- Wei C., <?php esc_html_e('Shanghai', 'marblecraft'); ?></div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section py-16 bg-blue-600 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">
            <?php echo esc_html(get_theme_mod('cta_section_title', __('Ready to Transform Your Space?', 'marblecraft'))); ?>
        </h2>
        <p class="text-xl mb-8 max-w-3xl mx-auto">
            <?php echo esc_html(get_theme_mod('cta_section_description', __('Contact us today to discuss your custom marble furniture needs or explore our collection of ready-made pieces.', 'marblecraft'))); ?>
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="<?php echo esc_url(get_theme_mod('cta_button1_url', get_permalink(get_page_by_path('products')))); ?>" class="bg-white hover:bg-gray-100 text-blue-600 font-bold py-3 px-6 rounded-lg transition duration-300">
                <?php echo esc_html(get_theme_mod('cta_button1_text', __('Browse Products', 'marblecraft'))); ?>
            </a>
            <a href="<?php echo esc_url(get_theme_mod('cta_button2_url', get_permalink(get_page_by_path('contact')))); ?>" class="bg-transparent hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg border-2 border-white transition duration-300">
                <?php echo esc_html(get_theme_mod('cta_button2_text', __('Get in Touch', 'marblecraft'))); ?>
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
