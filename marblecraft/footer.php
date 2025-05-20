<?php
/**
 * The template for displaying the footer
 */
?>

    <footer id="colophon" class="site-footer bg-gray-800 text-white py-8 mt-auto">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Footer Column 1 -->
                <div class="footer-col">
                    <h3 class="text-xl font-bold mb-4"><?php echo esc_html(get_theme_mod('footer_about_title', __('About Us', 'marblecraft'))); ?></h3>
                    <p class="mb-4"><?php echo esc_html(get_theme_mod('footer_about_text', get_bloginfo('description'))); ?></p>
                    <div class="social-icons flex space-x-4">
                        <?php
                        $social_platforms = [
                            'facebook' => [
                                'label' => 'Facebook',
                                'icon' => '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>'
                            ],
                            'twitter' => [
                                'label' => 'Twitter',
                                'icon' => '<path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>'
                            ],
                            'instagram' => [
                                'label' => 'Instagram',
                                'icon' => '<rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>'
                            ],
                            'linkedin' => [
                                'label' => 'LinkedIn',
                                'icon' => '<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle>'
                            ]
                        ];
                        
                        foreach ($social_platforms as $platform => $data) :
                            $url = get_theme_mod("social_{$platform}_url", '#');
                            if (!empty($url)) :
                        ?>
                            <a href="<?php echo esc_url($url); ?>" class="text-white hover:text-blue-400" aria-label="<?php echo esc_attr($data['label']); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-<?php echo esc_attr($platform); ?>">
                                    <?php echo $data['icon']; ?>
                                </svg>
                            </a>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </div>
                </div>
                
                <!-- Footer Column 2 -->
                <div class="footer-col">
                    <h3 class="text-xl font-bold mb-4"><?php esc_html_e('Quick Links', 'marblecraft'); ?></h3>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'menu_class'     => 'footer-menu space-y-2',
                        'container'      => false,
                        'depth'          => 1,
                        'fallback_cb'    => function() {
                            echo '<ul class="footer-menu space-y-2">';
                            echo '<li><a href="' . esc_url(home_url('/')) . '" class="hover:text-blue-400">' . esc_html__('Home', 'marblecraft') . '</a></li>';
                            echo '<li><a href="' . esc_url(home_url('/products/')) . '" class="hover:text-blue-400">' . esc_html__('Products', 'marblecraft') . '</a></li>';
                            echo '<li><a href="' . esc_url(home_url('/contact/')) . '" class="hover:text-blue-400">' . esc_html__('Contact', 'marblecraft') . '</a></li>';
                            echo '</ul>';
                        },
                    ));
                    ?>
                </div>
                
                <!-- Footer Column 3 -->
                <div class="footer-col">
                    <h3 class="text-xl font-bold mb-4"><?php esc_html_e('Contact Us', 'marblecraft'); ?></h3>
                    <address class="not-italic space-y-2">
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin mr-2 mt-1">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <span><?php echo esc_html(get_theme_mod('contact_address', __('123 Marble St, Stone City', 'marblecraft'))); ?></span>
                        </div>
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone mr-2 mt-1">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                            <span><?php echo esc_html(get_theme_mod('contact_phone', __('+1 (123) 456-7890', 'marblecraft'))); ?></span>
                        </div>
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail mr-2 mt-1">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <span><a href="mailto:<?php echo esc_attr(get_theme_mod('contact_email', 'info@marblecraft.com')); ?>" class="hover:text-blue-400"><?php echo esc_html(get_theme_mod('contact_email', 'info@marblecraft.com')); ?></a></span>
                        </div>
                    </address>
                </div>
            </div>
            
            <hr class="border-gray-700 my-6">
            
            <div class="flex flex-col md:flex-row md:justify-between items-center">
                <div class="copyright mb-4 md:mb-0">
                    <p>&copy; <?php echo date_i18n('Y'); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('All rights reserved.', 'marblecraft'); ?></p>
                </div>
                
                <div class="payment-methods">
                    <p class="mb-2 text-center md:text-right"><?php esc_html_e('We accept:', 'marblecraft'); ?></p>
                    <div class="flex space-x-3">
                        <span class="bg-white text-gray-800 rounded px-2 py-1 text-sm">Visa</span>
                        <span class="bg-white text-gray-800 rounded px-2 py-1 text-sm">MasterCard</span>
                        <span class="bg-white text-gray-800 rounded px-2 py-1 text-sm">PayPal</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
