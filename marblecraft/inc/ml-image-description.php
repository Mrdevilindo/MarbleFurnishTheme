<?php
/**
 * Machine Learning Image Description Generator
 * 
 * This file handles the integration with OpenAI's API to generate
 * product descriptions based on uploaded images.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Class for handling the ML image description generation
 */
class MarbleCraft_ML_Image_Description {
    
    /**
     * Initialize the class
     */
    public static function init() {
        // Add metabox to the marble_product post type
        add_action('add_meta_boxes', array(__CLASS__, 'add_ml_description_metabox'));
        
        // Handle the AJAX request for generating descriptions
        add_action('wp_ajax_generate_description_from_image', array(__CLASS__, 'ajax_generate_description'));
        
        // Enqueue scripts for the admin
        add_action('admin_enqueue_scripts', array(__CLASS__, 'enqueue_scripts'));
    }
    
    /**
     * Add metabox to the product edit screen
     */
    public static function add_ml_description_metabox() {
        add_meta_box(
            'marblecraft_ml_description',
            __('AI Product Description Generator', 'marblecraft'),
            array(__CLASS__, 'render_ml_description_metabox'),
            'marble_product',
            'normal',
            'high'
        );
    }
    
    /**
     * Render the metabox content
     */
    public static function render_ml_description_metabox($post) {
        // Security nonce
        wp_nonce_field('marblecraft_ml_description_nonce', 'marblecraft_ml_description_nonce');
        
        ?>
        <div class="ml-description-generator">
            <p><?php _e('Generate a product description automatically from the product image using AI.', 'marblecraft'); ?></p>
            
            <div class="ml-description-controls">
                <button type="button" id="generate-ml-description" class="button button-primary">
                    <?php _e('Generate Description from Image', 'marblecraft'); ?>
                </button>
                
                <span id="ml-loader" class="spinner" style="float: none; visibility: hidden;"></span>
                
                <select id="description-language" name="description_language">
                    <option value="en"><?php _e('English', 'marblecraft'); ?></option>
                    <option value="zh"><?php _e('Chinese', 'marblecraft'); ?></option>
                    <option value="es"><?php _e('Spanish', 'marblecraft'); ?></option>
                    <option value="fr"><?php _e('French', 'marblecraft'); ?></option>
                    <option value="de"><?php _e('German', 'marblecraft'); ?></option>
                    <option value="it"><?php _e('Italian', 'marblecraft'); ?></option>
                    <option value="ja"><?php _e('Japanese', 'marblecraft'); ?></option>
                    <option value="ar"><?php _e('Arabic', 'marblecraft'); ?></option>
                    <option value="ru"><?php _e('Russian', 'marblecraft'); ?></option>
                </select>
                
                <select id="description-length" name="description_length">
                    <option value="short"><?php _e('Short Description', 'marblecraft'); ?></option>
                    <option value="medium" selected><?php _e('Medium Description', 'marblecraft'); ?></option>
                    <option value="long"><?php _e('Long Description', 'marblecraft'); ?></option>
                </select>
            </div>
            
            <div id="ml-description-result" class="ml-description-result" style="margin-top: 15px; display: none;">
                <h4><?php _e('Generated Description:', 'marblecraft'); ?></h4>
                <div id="ml-description-text" class="ml-description-text" style="padding: 10px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 4px;"></div>
                
                <div class="ml-description-actions" style="margin-top: 10px;">
                    <button type="button" id="use-as-content" class="button">
                        <?php _e('Use as Main Content', 'marblecraft'); ?>
                    </button>
                    <button type="button" id="use-as-excerpt" class="button">
                        <?php _e('Use as Excerpt', 'marblecraft'); ?>
                    </button>
                </div>
            </div>
            
            <div id="ml-api-notice" style="margin-top: 15px; display: none; color: #d63638; background: #fcf0f1; padding: 10px; border-left: 4px solid #d63638;">
                <?php _e('API Key Missing: Please add your OpenAI API key in the theme settings to use this feature.', 'marblecraft'); ?>
            </div>
        </div>
        <?php
    }
    
    /**
     * Enqueue scripts for the admin
     */
    public static function enqueue_scripts($hook) {
        global $post;
        
        // Only enqueue on the post edit screen for marble_product post type
        if (!($hook == 'post.php' || $hook == 'post-new.php') || !is_object($post) || $post->post_type != 'marble_product') {
            return;
        }
        
        // Register and enqueue the script
        wp_register_script(
            'marblecraft-ml-description',
            get_template_directory_uri() . '/assets/js/ml-description.js',
            array('jquery'),
            MARBLECRAFT_VERSION,
            true
        );
        
        // Localize the script with data
        wp_localize_script(
            'marblecraft-ml-description',
            'marblecraftML',
            array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('marblecraft_ml_description_nonce'),
                'post_id' => $post->ID,
                'has_api_key' => !empty(get_theme_mod('openai_api_key', '')),
                'alert_api_key' => __('Please add your OpenAI API key in the theme settings to use this feature.', 'marblecraft'),
                'alert_no_image' => __('Please set a featured image first.', 'marblecraft'),
                'generating' => __('Generating description...', 'marblecraft'),
                'error' => __('Error generating description. Please try again.', 'marblecraft'),
            )
        );
        
        wp_enqueue_script('marblecraft-ml-description');
    }
    
    /**
     * Handle AJAX request for generating description
     */
    public static function ajax_generate_description() {
        // Check nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'marblecraft_ml_description_nonce')) {
            wp_send_json_error('Security check failed');
        }
        
        // Check post ID
        if (!isset($_POST['post_id']) || empty($_POST['post_id'])) {
            wp_send_json_error('Invalid post ID');
        }
        
        $post_id = intval($_POST['post_id']);
        $language = isset($_POST['language']) ? sanitize_text_field($_POST['language']) : 'en';
        $length = isset($_POST['length']) ? sanitize_text_field($_POST['length']) : 'medium';
        
        // Check if post has featured image
        if (!has_post_thumbnail($post_id)) {
            wp_send_json_error('No featured image set');
        }
        
        // Get OpenAI API key
        $api_key = get_theme_mod('openai_api_key', '');
        if (empty($api_key)) {
            wp_send_json_error('OpenAI API key is missing');
        }
        
        // Get featured image URL
        $image_url = get_the_post_thumbnail_url($post_id, 'full');
        if (empty($image_url)) {
            wp_send_json_error('Failed to get image URL');
        }
        
        // Get image as base64
        $image_data = self::get_image_base64($image_url);
        if ($image_data === false) {
            wp_send_json_error('Failed to process image');
        }
        
        // Generate description
        $description = self::generate_description_from_image($api_key, $image_data, $language, $length, $post_id);
        
        if ($description === false) {
            wp_send_json_error('Failed to generate description');
        }
        
        wp_send_json_success($description);
    }
    
    /**
     * Get image as base64 encoded string
     */
    private static function get_image_base64($image_url) {
        // For WordPress uploads, convert URL to local path
        $uploads_dir = wp_upload_dir();
        $base_url = $uploads_dir['baseurl'];
        $base_dir = $uploads_dir['basedir'];
        
        if (strpos($image_url, $base_url) === 0) {
            $file_path = str_replace($base_url, $base_dir, $image_url);
            
            if (file_exists($file_path)) {
                $file_content = file_get_contents($file_path);
                if ($file_content !== false) {
                    return base64_encode($file_content);
                }
            }
        }
        
        // If not a local file or couldn't read it, try remote URL
        $response = wp_remote_get($image_url);
        if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
            return false;
        }
        
        $image_data = wp_remote_retrieve_body($response);
        if (empty($image_data)) {
            return false;
        }
        
        return base64_encode($image_data);
    }
    
    /**
     * Generate description from image using OpenAI API
     */
    private static function generate_description_from_image($api_key, $image_base64, $language, $length, $post_id) {
        // Get post title
        $post_title = get_the_title($post_id);
        
        // Set prompt based on language and length
        $prompt = self::get_prompt_for_language_and_length($language, $length, $post_title);
        
        // Set up the API request
        $url = 'https://api.openai.com/v1/chat/completions';
        
        // Build the message with the image
        $messages = array(
            array(
                'role' => 'system',
                'content' => 'You are a luxury furniture expert specializing in marble products. Create detailed, appealing product descriptions highlighting the craftsmanship, materials, and elegance of marble furniture items.'
            ),
            array(
                'role' => 'user',
                'content' => array(
                    array(
                        'type' => 'text',
                        'text' => $prompt
                    ),
                    array(
                        'type' => 'image_url',
                        'image_url' => array(
                            'url' => 'data:image/jpeg;base64,' . $image_base64
                        )
                    )
                )
            )
        );
        
        // Prepare the body of the request
        $body = array(
            'model' => 'gpt-4o', // the newest OpenAI model is "gpt-4o" which was released May 13, 2024. do not change this unless explicitly requested by the user
            'messages' => $messages,
            'max_tokens' => ($length == 'short' ? 250 : ($length == 'medium' ? 500 : 750)),
            'temperature' => 0.7,
        );
        
        // Send the request
        $response = wp_remote_post($url, array(
            'method' => 'POST',
            'timeout' => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $api_key,
            ),
            'body' => json_encode($body),
            'cookies' => array()
        ));
        
        // Check for error
        if (is_wp_error($response)) {
            error_log('OpenAI API Error: ' . $response->get_error_message());
            return false;
        }
        
        $response_code = wp_remote_retrieve_response_code($response);
        if ($response_code !== 200) {
            error_log('OpenAI API Error: ' . wp_remote_retrieve_body($response));
            return false;
        }
        
        // Decode the response
        $response_body = json_decode(wp_remote_retrieve_body($response), true);
        
        if (!isset($response_body['choices'][0]['message']['content'])) {
            error_log('OpenAI API Error: Unexpected response format');
            return false;
        }
        
        return $response_body['choices'][0]['message']['content'];
    }
    
    /**
     * Get prompt based on language and length
     */
    private static function get_prompt_for_language_and_length($language, $length, $title) {
        $length_desc = '';
        switch ($length) {
            case 'short':
                $length_desc = 'Keep the description concise, around 100 words.';
                break;
            case 'medium':
                $length_desc = 'Provide a moderate-length description, around 200-250 words.';
                break;
            case 'long':
                $length_desc = 'Create a detailed, comprehensive description, around 350-400 words.';
                break;
        }
        
        $language_name = '';
        $language_instruction = '';
        
        switch ($language) {
            case 'en':
                $language_name = 'English';
                break;
            case 'zh':
                $language_name = 'Chinese';
                $language_instruction = 'Please write the description in Chinese (Simplified).';
                break;
            case 'es':
                $language_name = 'Spanish';
                $language_instruction = 'Please write the description in Spanish.';
                break;
            case 'fr':
                $language_name = 'French';
                $language_instruction = 'Please write the description in French.';
                break;
            case 'de':
                $language_name = 'German';
                $language_instruction = 'Please write the description in German.';
                break;
            case 'it':
                $language_name = 'Italian';
                $language_instruction = 'Please write the description in Italian.';
                break;
            case 'ja':
                $language_name = 'Japanese';
                $language_instruction = 'Please write the description in Japanese.';
                break;
            case 'ar':
                $language_name = 'Arabic';
                $language_instruction = 'Please write the description in Arabic.';
                break;
            case 'ru':
                $language_name = 'Russian';
                $language_instruction = 'Please write the description in Russian.';
                break;
            default:
                $language_name = 'English';
                break;
        }
        
        $base_prompt = "Analyze this image of a marble furniture product titled '{$title}' and generate a compelling product description. Focus on the design, materials, craftsmanship, and potential uses in luxury spaces. Highlight any special features visible in the image and explain the benefits of this piece. {$length_desc}";
        
        if (!empty($language_instruction)) {
            $base_prompt .= " {$language_instruction}";
        }
        
        return $base_prompt;
    }
}

// Initialize the class
MarbleCraft_ML_Image_Description::init();