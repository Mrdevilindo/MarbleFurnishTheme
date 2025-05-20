<?php
/**
 * Template part for displaying the contact form
 */
?>

<div id="marblecraft-contact-form" class="contact-form">
    <form id="contact-form" class="space-y-4">
        <?php wp_nonce_field('marblecraft_form_nonce', 'marblecraft_nonce'); ?>
        
        <div class="form-group">
            <label for="name" class="block text-gray-700 font-medium mb-2"><?php esc_html_e('Your Name', 'marblecraft'); ?> <span class="text-red-600">*</span></label>
            <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" required>
        </div>
        
        <div class="form-group">
            <label for="email" class="block text-gray-700 font-medium mb-2"><?php esc_html_e('Email Address', 'marblecraft'); ?> <span class="text-red-600">*</span></label>
            <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" required>
        </div>
        
        <div class="form-group">
            <label for="country" class="block text-gray-700 font-medium mb-2"><?php esc_html_e('Country', 'marblecraft'); ?> <span class="text-red-600">*</span></label>
            <input type="text" id="country" name="country" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" required>
        </div>
        
        <div class="form-group">
            <label for="message" class="block text-gray-700 font-medium mb-2"><?php esc_html_e('Message', 'marblecraft'); ?> <span class="text-red-600">*</span></label>
            <textarea id="message" name="message" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" required></textarea>
        </div>
        
        <?php 
        // Check if reCAPTCHA site key is set
        $recaptcha_site_key = get_option('marblecraft_recaptcha_site_key', '');
        if (!empty($recaptcha_site_key)) :
        ?>
            <div class="form-group">
                <div class="g-recaptcha" data-sitekey="<?php echo esc_attr($recaptcha_site_key); ?>"></div>
            </div>
        <?php endif; ?>
        
        <div class="form-group">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-md transition duration-300">
                <?php esc_html_e('Send Message', 'marblecraft'); ?>
            </button>
        </div>
        
        <div id="form-response" class="form-response hidden rounded-md p-4"></div>
    </form>
</div>
