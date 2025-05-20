<?php
/**
 * Form Handler for MarbleCraft Contact Form
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle contact form submission via AJAX
 */
function marblecraft_handle_form_submission() {
    // Verify nonce
    check_ajax_referer('marblecraft_form_nonce', 'nonce');
    
    // Form validation
    $errors = array();
    
    // Validate name
    if (empty($_POST['name']) || !sanitize_text_field($_POST['name'])) {
        $errors[] = __('Please enter your name.', 'marblecraft');
    }
    
    // Validate email
    if (empty($_POST['email']) || !is_email(sanitize_email($_POST['email']))) {
        $errors[] = __('Please enter a valid email address.', 'marblecraft');
    }
    
    // Validate country
    if (empty($_POST['country']) || !sanitize_text_field($_POST['country'])) {
        $errors[] = __('Please enter your country.', 'marblecraft');
    }
    
    // Validate message
    if (empty($_POST['message']) || !sanitize_textarea_field($_POST['message'])) {
        $errors[] = __('Please enter your message.', 'marblecraft');
    }
    
    // Validate reCAPTCHA if enabled
    if (isset($_POST['g-recaptcha-response'])) {
        $recaptcha_secret = get_option('marblecraft_recaptcha_secret_key', '');
        
        if (!empty($recaptcha_secret)) {
            $recaptcha_response = sanitize_text_field($_POST['g-recaptcha-response']);
            $recaptcha = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$recaptcha_response}");
            
            if (is_wp_error($recaptcha)) {
                $errors[] = __('reCAPTCHA verification failed. Please try again.', 'marblecraft');
            } else {
                $recaptcha = json_decode(wp_remote_retrieve_body($recaptcha));
                
                if (!$recaptcha->success) {
                    $errors[] = __('reCAPTCHA verification failed. Please try again.', 'marblecraft');
                }
            }
        }
    }
    
    // If there are errors, return them
    if (!empty($errors)) {
        wp_send_json_error(array(
            'message' => __('Please correct the following errors:', 'marblecraft'),
            'errors' => $errors,
        ));
    }
    
    // Process form data
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $country = sanitize_text_field($_POST['country']);
    $message = sanitize_textarea_field($_POST['message']);
    
    // Save to database
    global $wpdb;
    $table_name = $wpdb->prefix . 'marblecraft_submissions';
    
    $result = $wpdb->insert(
        $table_name,
        array(
            'name' => $name,
            'email' => $email,
            'country' => $country,
            'message' => $message,
            'submission_date' => current_time('mysql'),
        ),
        array('%s', '%s', '%s', '%s', '%s')
    );
    
    // Check if database insert was successful
    if ($result === false) {
        wp_send_json_error(array(
            'message' => __('There was an error saving your message. Please try again.', 'marblecraft'),
        ));
    }
    
    // Send email notifications
    $admin_email = get_option('admin_email');
    $site_name = get_bloginfo('name');
    
    // Email to admin
    $admin_subject = sprintf(__('[%s] New contact form submission', 'marblecraft'), $site_name);
    $admin_message = sprintf(
        __("New contact form submission:\n\nName: %s\nEmail: %s\nCountry: %s\nMessage:\n%s", 'marblecraft'),
        $name,
        $email,
        $country,
        $message
    );
    
    $admin_headers = array('Content-Type: text/plain; charset=UTF-8');
    
    $admin_mail_sent = wp_mail($admin_email, $admin_subject, $admin_message, $admin_headers);
    
    // Email to customer
    $customer_subject = sprintf(__('Thank you for contacting %s', 'marblecraft'), $site_name);
    $customer_message = sprintf(
        __("Dear %s,\n\nThank you for contacting %s. We have received your message and will respond to your inquiry as soon as possible.\n\nBest regards,\n%s Team", 'marblecraft'),
        $name,
        $site_name,
        $site_name
    );
    
    $customer_headers = array('Content-Type: text/plain; charset=UTF-8');
    
    $customer_mail_sent = wp_mail($email, $customer_subject, $customer_message, $customer_headers);
    
    // Return success message
    wp_send_json_success(array(
        'message' => __('Thank you for your message. We will contact you soon!', 'marblecraft'),
        'admin_mail_sent' => $admin_mail_sent,
        'customer_mail_sent' => $customer_mail_sent,
    ));
}
add_action('wp_ajax_marblecraft_submit_form', 'marblecraft_handle_form_submission');
add_action('wp_ajax_nopriv_marblecraft_submit_form', 'marblecraft_handle_form_submission');

/**
 * Add reCAPTCHA settings to WordPress admin
 */
function marblecraft_add_recaptcha_settings() {
    register_setting('general', 'marblecraft_recaptcha_site_key', 'sanitize_text_field');
    register_setting('general', 'marblecraft_recaptcha_secret_key', 'sanitize_text_field');
    
    add_settings_section(
        'marblecraft_recaptcha_settings',
        __('MarbleCraft reCAPTCHA Settings', 'marblecraft'),
        'marblecraft_recaptcha_settings_callback',
        'general'
    );
    
    add_settings_field(
        'marblecraft_recaptcha_site_key',
        __('reCAPTCHA Site Key', 'marblecraft'),
        'marblecraft_recaptcha_site_key_callback',
        'general',
        'marblecraft_recaptcha_settings'
    );
    
    add_settings_field(
        'marblecraft_recaptcha_secret_key',
        __('reCAPTCHA Secret Key', 'marblecraft'),
        'marblecraft_recaptcha_secret_key_callback',
        'general',
        'marblecraft_recaptcha_settings'
    );
}
add_action('admin_init', 'marblecraft_add_recaptcha_settings');

/**
 * reCAPTCHA settings section callback
 */
function marblecraft_recaptcha_settings_callback() {
    echo '<p>' . __('Enter your Google reCAPTCHA v2 keys here. You can get your keys from <a href="https://www.google.com/recaptcha/admin" target="_blank">Google reCAPTCHA</a>.', 'marblecraft') . '</p>';
}

/**
 * reCAPTCHA site key field callback
 */
function marblecraft_recaptcha_site_key_callback() {
    $site_key = get_option('marblecraft_recaptcha_site_key', '');
    echo '<input type="text" id="marblecraft_recaptcha_site_key" name="marblecraft_recaptcha_site_key" value="' . esc_attr($site_key) . '" class="regular-text">';
}

/**
 * reCAPTCHA secret key field callback
 */
function marblecraft_recaptcha_secret_key_callback() {
    $secret_key = get_option('marblecraft_recaptcha_secret_key', '');
    echo '<input type="text" id="marblecraft_recaptcha_secret_key" name="marblecraft_recaptcha_secret_key" value="' . esc_attr($secret_key) . '" class="regular-text">';
}
