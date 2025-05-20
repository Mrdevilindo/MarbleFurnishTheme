<?php
/**
 * Template part for displaying the language switcher
 */
?>

<div class="language-switcher">
    <?php
    // WPML language switcher
    if (function_exists('icl_get_languages')) {
        $languages = icl_get_languages('skip_missing=0');
        
        if (!empty($languages)) {
            echo '<div class="flex space-x-2">';
            
            foreach ($languages as $lang) {
                $active_class = $lang['active'] ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300 text-gray-800';
                
                echo '<a href="' . esc_url($lang['url']) . '" class="inline-block px-2 py-1 rounded-md text-sm ' . $active_class . '">';
                
                if ($lang['language_code'] == 'en') {
                    echo 'EN';
                } elseif ($lang['language_code'] == 'zh-hans' || $lang['language_code'] == 'zh') {
                    echo '中文';
                } elseif ($lang['language_code'] == 'es') {
                    echo 'ES';
                } else {
                    echo strtoupper($lang['language_code']);
                }
                
                echo '</a>';
            }
            
            echo '</div>';
        }
    }
    // Polylang language switcher
    elseif (function_exists('pll_the_languages')) {
        $args = array(
            'show_flags' => 0,
            'show_names' => 1,
            'display_names_as' => 'slug',
            'hide_if_empty' => 0,
            'echo' => 0,
        );
        
        $languages = pll_the_languages($args);
        
        if (!empty($languages)) {
            echo '<div class="flex space-x-2">';
            echo $languages;
            echo '</div>';
        }
    }
    // Fallback if no language plugin is active
    else {
        echo '<div class="flex space-x-2">';
        echo '<a href="#" class="inline-block px-2 py-1 rounded-md text-sm bg-blue-600 text-white">EN</a>';
        echo '<a href="#" class="inline-block px-2 py-1 rounded-md text-sm bg-gray-200 hover:bg-gray-300 text-gray-800">中文</a>';
        echo '<a href="#" class="inline-block px-2 py-1 rounded-md text-sm bg-gray-200 hover:bg-gray-300 text-gray-800">ES</a>';
        echo '</div>';
    }
    ?>
</div>
