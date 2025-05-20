<?php
/**
 * Header template for MarbleCraft theme
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
</head>

<body <?php body_class('bg-gray-100 font-sans'); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site flex flex-col min-h-screen">
    <?php 
    // Get logo position from customizer
    $logo_position = get_theme_mod('logo_position', 'left');
    $header_classes = ($logo_position == 'center') ? 'text-center' : '';
    $container_classes = ($logo_position == 'center') ? 'flex-col items-center' : 'flex-col md:flex-row md:justify-between md:items-center';
    ?>

    <header id="masthead" class="site-header bg-white shadow-md <?php echo esc_attr($header_classes); ?>">
        <div class="container mx-auto px-4 py-4">
            <div class="flex <?php echo esc_attr($container_classes); ?>">
                <!-- Site Branding/Logo -->
                <div class="site-branding <?php echo ($logo_position == 'center') ? 'mb-4 text-center w-full' : 'flex items-center justify-between'; ?>">
                    <?php if (has_custom_logo()) : ?>
                        <div class="<?php echo ($logo_position == 'center') ? 'mx-auto' : ''; ?>">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else : ?>
                        <h1 class="site-title font-bold text-2xl">
                            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="text-gray-800 hover:text-blue-600">
                                <?php bloginfo('name'); ?>
                            </a>
                        </h1>
                    <?php endif; ?>
                    
                    <?php if ($logo_position != 'center') : ?>
                        <button id="mobile-menu-toggle" class="md:hidden text-gray-600 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
                                <line x1="3" y1="12" x2="21" y2="12"></line>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <line x1="3" y1="18" x2="21" y2="18"></line>
                            </svg>
                        </button>
                    <?php endif; ?>
                </div>
                
                <!-- Primary Navigation -->
                <?php $nav_classes = ($logo_position == 'center') ? 'w-full' : 'hidden md:block'; ?>
                <nav id="site-navigation" class="main-navigation <?php echo esc_attr($nav_classes); ?>">
                    <?php
                    $menu_classes = ($logo_position == 'center') ? 
                        'flex md:flex-row flex-col space-y-4 md:space-y-0 md:space-x-6 text-lg justify-center' : 
                        'flex md:flex-row flex-col space-y-4 md:space-y-0 md:space-x-6 text-lg';
                        
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                        'menu_class'     => $menu_classes,
                        'fallback_cb'    => function() use ($menu_classes) {
                            echo '<ul class="' . esc_attr($menu_classes) . '">';
                            echo '<li><a href="' . esc_url(home_url('/')) . '" class="text-gray-800 hover:text-blue-600">' . esc_html__('Home', 'marblecraft') . '</a></li>';
                            echo '<li><a href="' . esc_url(home_url('/products/')) . '" class="text-gray-800 hover:text-blue-600">' . esc_html__('Products', 'marblecraft') . '</a></li>';
                            echo '<li><a href="' . esc_url(home_url('/contact/')) . '" class="text-gray-800 hover:text-blue-600">' . esc_html__('Contact', 'marblecraft') . '</a></li>';
                            echo '</ul>';
                        },
                    ));
                    ?>
                </nav>
                
                <!-- Language Switcher (side layout) -->
                <?php if ($logo_position != 'center') : ?>
                    <div class="language-switcher hidden md:block">
                        <?php get_template_part('template-parts/language-switcher'); ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Language Switcher (center layout) -->
            <?php if ($logo_position == 'center') : ?>
                <div class="language-switcher-center flex justify-center mt-4">
                    <?php get_template_part('template-parts/language-switcher'); ?>
                </div>
                
                <!-- Mobile menu toggle for centered layout -->
                <div class="text-center mt-3 mb-2 md:hidden">
                    <button id="mobile-menu-toggle" class="text-gray-600 focus:outline-none inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>
                </div>
            <?php endif; ?>
            
            <!-- Mobile Menu -->
            <div id="mobile-menu" class="md:hidden mt-4 hidden">
                <nav class="mobile-navigation mb-4">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'mobile-menu',
                        'container'      => false,
                        'menu_class'     => 'flex flex-col space-y-4 text-lg',
                        'fallback_cb'    => function() {
                            echo '<ul class="flex flex-col space-y-4 text-lg">';
                            echo '<li><a href="' . esc_url(home_url('/')) . '" class="text-gray-800 hover:text-blue-600">' . esc_html__('Home', 'marblecraft') . '</a></li>';
                            echo '<li><a href="' . esc_url(home_url('/products/')) . '" class="text-gray-800 hover:text-blue-600">' . esc_html__('Products', 'marblecraft') . '</a></li>';
                            echo '<li><a href="' . esc_url(home_url('/contact/')) . '" class="text-gray-800 hover:text-blue-600">' . esc_html__('Contact', 'marblecraft') . '</a></li>';
                            echo '</ul>';
                        },
                    ));
                    ?>
                </nav>
                
                <div class="mobile-language-switcher">
                    <?php get_template_part('template-parts/language-switcher'); ?>
                </div>
            </div>
        </div>
    </header>

    <?php if (!is_front_page() && !is_home()) : ?>
        <div class="page-header bg-gray-200 py-6">
            <div class="container mx-auto px-4">
                <?php
                if (is_archive()) {
                    the_archive_title('<h1 class="page-title text-3xl font-bold">', '</h1>');
                    the_archive_description('<div class="archive-description mt-2 text-gray-600">', '</div>');
                } elseif (is_search()) {
                    echo '<h1 class="page-title text-3xl font-bold">';
                    printf(esc_html__('Search Results for: %s', 'marblecraft'), '<span>' . get_search_query() . '</span>');
                    echo '</h1>';
                } elseif (is_singular('post') || is_singular('marble_product')) {
                    // For single posts and products, title is displayed in the content
                } else {
                    echo '<h1 class="page-title text-3xl font-bold">' . get_the_title() . '</h1>';
                }
                ?>
                
                <?php if (function_exists('yoast_breadcrumb')) : ?>
                    <div class="breadcrumbs mt-2 text-sm">
                        <?php yoast_breadcrumb(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>