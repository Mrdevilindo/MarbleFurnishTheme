<?php
/**
 * Template Name: Contact Page
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
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Contact Form -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-6"><?php esc_html_e('Get in Touch', 'marblecraft'); ?></h2>
            
            <?php echo do_shortcode('[marblecraft_contact_form]'); ?>
        </div>
        
        <!-- Contact Information -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-6"><?php esc_html_e('Contact Information', 'marblecraft'); ?></h2>
            
            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-2"><?php esc_html_e('Address', 'marblecraft'); ?></h3>
                <p class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin mr-2 mt-1 text-blue-600">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    <span>123 Marble St, Stone City, SC 12345</span>
                </p>
            </div>
            
            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-2"><?php esc_html_e('Phone', 'marblecraft'); ?></h3>
                <p class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone mr-2 mt-1 text-blue-600">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                    <span>+1 (123) 456-7890</span>
                </p>
            </div>
            
            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-2"><?php esc_html_e('Email', 'marblecraft'); ?></h3>
                <p class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail mr-2 mt-1 text-blue-600">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    <span><a href="mailto:info@marblecraft.com" class="text-blue-600 hover:underline">info@marblecraft.com</a></span>
                </p>
            </div>
            
            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-2"><?php esc_html_e('Hours', 'marblecraft'); ?></h3>
                <p class="mb-1"><strong><?php esc_html_e('Monday - Friday:', 'marblecraft'); ?></strong> 9:00 AM - 6:00 PM</p>
                <p class="mb-1"><strong><?php esc_html_e('Saturday:', 'marblecraft'); ?></strong> 10:00 AM - 4:00 PM</p>
                <p><strong><?php esc_html_e('Sunday:', 'marblecraft'); ?></strong> <?php esc_html_e('Closed', 'marblecraft'); ?></p>
            </div>
            
            <div>
                <h3 class="text-xl font-semibold mb-2"><?php esc_html_e('Connect With Us', 'marblecraft'); ?></h3>
                <div class="flex space-x-4">
                    <a href="#" class="text-blue-600 hover:text-blue-800" aria-label="Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                        </svg>
                    </a>
                    <a href="#" class="text-blue-400 hover:text-blue-600" aria-label="Twitter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter">
                            <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                        </svg>
                    </a>
                    <a href="#" class="text-pink-600 hover:text-pink-800" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-instagram">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                    </a>
                    <a href="#" class="text-red-600 hover:text-red-800" aria-label="YouTube">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-youtube">
                            <path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path>
                            <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6"><?php esc_html_e('Find Us', 'marblecraft'); ?></h2>
        <div class="map-container aspect-w-16 aspect-h-9 bg-gray-200 rounded-lg">
            <!-- Placeholder for map (in real implementation, you would use Google Maps or similar) -->
            <div class="w-full h-full flex items-center justify-center">
                <div class="text-center text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map mx-auto mb-4">
                        <polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon>
                        <line x1="8" y1="2" x2="8" y2="18"></line>
                        <line x1="16" y1="6" x2="16" y2="22"></line>
                    </svg>
                    <p><?php esc_html_e('Map loading...', 'marblecraft'); ?></p>
                    <p class="text-sm mt-2"><?php esc_html_e('(In a real implementation, a Google Map would be displayed here)', 'marblecraft'); ?></p>
                </div>
            </div>
        </div>
    </div>

</main>

<?php get_footer(); ?>
