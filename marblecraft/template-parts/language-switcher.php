<?php
/**
 * Language switcher template part
 *
 * Displays a language selection dropdown for multilingual sites
 */

// Only show language switcher if multilingual support is enabled
if (!get_theme_mod('enable_multilingual', true)) {
    return;
}

// Get available languages
$languages = marblecraft_get_available_languages();
$current_language = marblecraft_get_current_language();

// Setup language display names
$language_names = array(
    'en' => __('English', 'marblecraft'),
    'zh' => __('Chinese', 'marblecraft'),
    'es' => __('Spanish', 'marblecraft'),
    'fr' => __('French', 'marblecraft'),
    'de' => __('German', 'marblecraft'),
    'it' => __('Italian', 'marblecraft'),
    'ja' => __('Japanese', 'marblecraft'),
    'ar' => __('Arabic', 'marblecraft'),
    'ru' => __('Russian', 'marblecraft'),
);

// Return if there's only one language
if (count($languages) <= 1) {
    return;
}

// Get current URL
$current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>

<div class="language-switcher">
    <div class="relative inline-block text-left">
        <div>
            <button type="button" id="language-menu-button" aria-expanded="true" aria-haspopup="true" class="inline-flex justify-center items-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <?php 
                $current_language_name = isset($language_names[$current_language]) ? $language_names[$current_language] : $current_language;
                echo esc_html($current_language_name);
                ?>
                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
        
        <div id="language-menu" class="hidden origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10" role="menu" aria-orientation="vertical" aria-labelledby="language-menu-button" tabindex="-1">
            <div class="py-1" role="none">
                <?php foreach ($languages as $lang) : 
                    // Skip current language
                    if ($lang === $current_language) {
                        continue;
                    }
                    
                    // Get translated URL
                    $translated_url = marblecraft_get_translated_url($current_url, $lang);
                    
                    // Get language name
                    $lang_name = isset($language_names[$lang]) ? $language_names[$lang] : $lang;
                ?>
                    <a href="<?php echo esc_url($translated_url); ?>" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100" role="menuitem" tabindex="-1">
                        <?php echo esc_html($lang_name); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
    // Language switcher dropdown toggle
    document.addEventListener('DOMContentLoaded', function() {
        const button = document.getElementById('language-menu-button');
        const menu = document.getElementById('language-menu');
        
        if (button && menu) {
            button.addEventListener('click', function() {
                menu.classList.toggle('hidden');
                button.setAttribute('aria-expanded', menu.classList.contains('hidden') ? 'false' : 'true');
            });
            
            // Close the dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!button.contains(event.target) && !menu.contains(event.target)) {
                    menu.classList.add('hidden');
                    button.setAttribute('aria-expanded', 'false');
                }
            });
        }
    });
</script>