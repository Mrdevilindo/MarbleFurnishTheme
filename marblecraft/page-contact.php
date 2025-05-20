<?php
/**
 * Template Name: Contact Page
 *
 * The template for displaying the contact page.
 */

get_header();

// Get contact information from theme options
$contact_address = get_theme_mod('contact_address', __('123 Marble St, Stone City', 'marblecraft'));
$contact_phone = get_theme_mod('contact_phone', __('+1 (123) 456-7890', 'marblecraft'));
$contact_email = get_theme_mod('contact_email', 'info@marblecraft.com');

// Get form pre-filled product from query string if available
$pre_filled_product = isset($_GET['product']) ? sanitize_text_field($_GET['product']) : '';
?>

<main id="main" class="site-main container mx-auto my-8 px-4">
    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-lg shadow-lg overflow-hidden'); ?>>
            <!-- Page Header -->
            <header class="entry-header bg-gray-800 text-white p-8">
                <h1 class="entry-title text-3xl font-bold mb-4"><?php the_title(); ?></h1>
                <?php if (has_excerpt()) : ?>
                    <div class="entry-subtitle text-lg text-gray-300">
                        <?php the_excerpt(); ?>
                    </div>
                <?php endif; ?>
            </header>

            <div class="entry-content p-8">
                <!-- Content before the contact form -->
                <?php the_content(); ?>

                <!-- Contact Section -->
                <div class="contact-section mt-8 grid md:grid-cols-2 gap-12">
                    <!-- Contact Form -->
                    <div class="contact-form-container">
                        <h2 class="text-2xl font-bold mb-6"><?php _e('Send Us a Message', 'marblecraft'); ?></h2>
                        
                        <form id="contact-form" class="space-y-6">
                            <input type="hidden" name="action" value="marblecraft_contact_form">
                            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('marblecraft-nonce'); ?>">
                            
                            <div class="form-group">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1"><?php _e('Your Name', 'marblecraft'); ?> <span class="text-red-500">*</span></label>
                                <input type="text" id="name" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div class="form-group">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1"><?php _e('Your Email', 'marblecraft'); ?> <span class="text-red-500">*</span></label>
                                <input type="email" id="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div class="form-group">
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-1"><?php _e('Subject', 'marblecraft'); ?></label>
                                <input type="text" id="subject" name="subject" value="<?php echo esc_attr($pre_filled_product ? __('Inquiry about', 'marblecraft') . ': ' . $pre_filled_product : ''); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div class="form-group">
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1"><?php _e('Your Message', 'marblecraft'); ?> <span class="text-red-500">*</span></label>
                                <textarea id="message" name="message" rows="6" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>
                            
                            <?php if (get_theme_mod('enable_recaptcha', false) && get_theme_mod('recaptcha_site_key', '')) : ?>
                                <div class="form-group">
                                    <div class="g-recaptcha" data-sitekey="<?php echo esc_attr(get_theme_mod('recaptcha_site_key')); ?>"></div>
                                </div>
                                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                            <?php endif; ?>
                            
                            <div class="form-group">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-md transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    <?php _e('Send Message', 'marblecraft'); ?>
                                </button>
                            </div>
                            
                            <div id="form-response" class="hidden mt-4 p-4 rounded-md"></div>
                        </form>
                    </div>
                    
                    <!-- Contact Information -->
                    <div class="contact-info">
                        <h2 class="text-2xl font-bold mb-6"><?php _e('Contact Information', 'marblecraft'); ?></h2>
                        
                        <div class="space-y-8">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-blue-100 rounded-full p-3 mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin text-blue-600">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-2"><?php _e('Our Address', 'marblecraft'); ?></h3>
                                    <p class="text-gray-600"><?php echo esc_html($contact_address); ?></p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-blue-100 rounded-full p-3 mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone text-blue-600">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-2"><?php _e('Phone Number', 'marblecraft'); ?></h3>
                                    <p class="text-gray-600"><?php echo esc_html($contact_phone); ?></p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-blue-100 rounded-full p-3 mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail text-blue-600">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                        <polyline points="22,6 12,13 2,6"></polyline>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-2"><?php _e('Email Address', 'marblecraft'); ?></h3>
                                    <p class="text-gray-600"><a href="mailto:<?php echo esc_attr($contact_email); ?>" class="hover:text-blue-600"><?php echo esc_html($contact_email); ?></a></p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-blue-100 rounded-full p-3 mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock text-blue-600">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-2"><?php _e('Business Hours', 'marblecraft'); ?></h3>
                                    <p class="text-gray-600"><?php _e('Monday - Friday: 9:00 AM - 6:00 PM', 'marblecraft'); ?></p>
                                    <p class="text-gray-600"><?php _e('Saturday: 10:00 AM - 4:00 PM', 'marblecraft'); ?></p>
                                    <p class="text-gray-600"><?php _e('Sunday: Closed', 'marblecraft'); ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Social Media Links -->
                        <div class="social-links mt-10">
                            <h3 class="text-lg font-semibold mb-4"><?php _e('Follow Us', 'marblecraft'); ?></h3>
                            <div class="flex space-x-4">
                                <?php
                                $social_platforms = [
                                    'facebook' => [
                                        'url' => get_theme_mod('social_facebook_url', '#'),
                                        'icon' => '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>'
                                    ],
                                    'twitter' => [
                                        'url' => get_theme_mod('social_twitter_url', '#'),
                                        'icon' => '<path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>'
                                    ],
                                    'instagram' => [
                                        'url' => get_theme_mod('social_instagram_url', '#'),
                                        'icon' => '<rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>'
                                    ],
                                    'linkedin' => [
                                        'url' => get_theme_mod('social_linkedin_url', '#'),
                                        'icon' => '<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle>'
                                    ]
                                ];
                                
                                foreach ($social_platforms as $platform => $data) :
                                    if (!empty($data['url']) && $data['url'] !== '#') :
                                ?>
                                    <a href="<?php echo esc_url($data['url']); ?>" target="_blank" rel="noopener noreferrer" class="bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-full p-3 transition duration-300">
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
                    </div>
                </div>
                
                <!-- Google Map (if available) -->
                <?php 
                $map_embed_code = get_theme_mod('google_map_embed_code', '');
                if (!empty($map_embed_code)) : 
                ?>
                    <div class="map-container mt-12 rounded-lg overflow-hidden shadow-lg">
                        <h2 class="text-2xl font-bold mb-6"><?php _e('Find Us on the Map', 'marblecraft'); ?></h2>
                        <div class="map-embed aspect-w-16 aspect-h-9">
                            <?php echo $map_embed_code; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contact-form');
    const formResponse = document.getElementById('form-response');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Clear previous response
            formResponse.innerHTML = '';
            formResponse.className = 'hidden mt-4 p-4 rounded-md';
            
            // Create form data object
            const formData = new FormData(contactForm);
            
            // Show loading indicator
            formResponse.innerHTML = '<div class="flex items-center"><svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><?php _e('Sending...', 'marblecraft'); ?></div>';
            formResponse.classList.remove('hidden');
            
            // Send AJAX request
            fetch(marblecraftVars.ajaxurl, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    formResponse.innerHTML = '<div class="text-green-700">' + data.data + '</div>';
                    formResponse.className = 'mt-4 p-4 rounded-md bg-green-100 border border-green-200';
                    contactForm.reset();
                } else {
                    formResponse.innerHTML = '<div class="text-red-700">' + data.data + '</div>';
                    formResponse.className = 'mt-4 p-4 rounded-md bg-red-100 border border-red-200';
                }
            })
            .catch(error => {
                formResponse.innerHTML = '<div class="text-red-700"><?php _e('An error occurred. Please try again later.', 'marblecraft'); ?></div>';
                formResponse.className = 'mt-4 p-4 rounded-md bg-red-100 border border-red-200';
            });
        });
    }
});
</script>

<?php get_footer(); ?>