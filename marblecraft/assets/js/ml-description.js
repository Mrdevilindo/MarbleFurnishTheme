/**
 * MarbleCraft ML Description Generator
 * 
 * Handles the client-side functionality for generating product descriptions
 * from images using OpenAI's API.
 */

(function($) {
    'use strict';
    
    // Initialize once the DOM is fully loaded
    $(document).ready(function() {
        // Elements
        const $generateBtn = $('#generate-ml-description');
        const $languageSelect = $('#description-language');
        const $lengthSelect = $('#description-length');
        const $resultContainer = $('#ml-description-result');
        const $resultText = $('#ml-description-text');
        const $useAsContentBtn = $('#use-as-content');
        const $useAsExcerptBtn = $('#use-as-excerpt');
        const $loader = $('#ml-loader');
        const $apiNotice = $('#ml-api-notice');
        
        // Check if API key is available
        if (!marblecraftML.has_api_key) {
            $apiNotice.show();
            $generateBtn.prop('disabled', true);
        }
        
        // Handle generate button click
        $generateBtn.on('click', function() {
            // Check for API key again
            if (!marblecraftML.has_api_key) {
                alert(marblecraftML.alert_api_key);
                return;
            }
            
            // Start the generation process
            generateDescription();
        });
        
        // Handle "Use as Content" button click
        $useAsContentBtn.on('click', function() {
            const generatedText = $resultText.html();
            
            // If we're using the block editor (Gutenberg)
            if (wp.data && wp.data.select('core/editor')) {
                const { insertBlocks, removeAllBlocks } = wp.data.dispatch('core/editor');
                const { createBlock } = wp.blocks;
                
                // Remove existing blocks (optional, depends on your preference)
                // removeAllBlocks();
                
                // Create a new paragraph block with the generated text
                const newBlock = createBlock('core/paragraph', {
                    content: generatedText,
                });
                
                // Insert the new block
                insertBlocks(newBlock);
            } 
            // If we're using the classic editor
            else if (typeof tinyMCE !== 'undefined' && tinyMCE.activeEditor && !tinyMCE.activeEditor.isHidden()) {
                tinyMCE.activeEditor.setContent(generatedText);
            } 
            // Fallback to directly updating the textarea
            else if ($('#content').length) {
                $('#content').val(generatedText);
            }
            
            // Show success message
            alert('Content updated with generated description!');
        });
        
        // Handle "Use as Excerpt" button click
        $useAsExcerptBtn.on('click', function() {
            const generatedText = $resultText.text();
            
            // Get excerpt (either Gutenberg or classic)
            if ($('#excerpt').length) {
                $('#excerpt').val(generatedText);
            } else if (wp.data && wp.data.select('core/editor')) {
                wp.data.dispatch('core/editor').editPost({ excerpt: generatedText });
            }
            
            // Show success message
            alert('Excerpt updated with generated description!');
        });
        
        // Function to generate description
        function generateDescription() {
            // Show loading state
            $loader.css('visibility', 'visible');
            $generateBtn.prop('disabled', true);
            $resultContainer.hide();
            
            // Get values
            const language = $languageSelect.val();
            const length = $lengthSelect.val();
            
            // Make AJAX request
            $.ajax({
                url: marblecraftML.ajaxurl,
                type: 'POST',
                data: {
                    action: 'generate_description_from_image',
                    nonce: marblecraftML.nonce,
                    post_id: marblecraftML.post_id,
                    language: language,
                    length: length
                },
                success: function(response) {
                    // Reset loading state
                    $loader.css('visibility', 'hidden');
                    $generateBtn.prop('disabled', false);
                    
                    if (response.success) {
                        // Show the result
                        $resultText.html(response.data.replace(/\n/g, '<br>'));
                        $resultContainer.show();
                    } else {
                        // Show error
                        if (response.data === 'No featured image set') {
                            alert(marblecraftML.alert_no_image);
                        } else {
                            alert(marblecraftML.error + ' ' + response.data);
                        }
                    }
                },
                error: function() {
                    // Reset loading state
                    $loader.css('visibility', 'hidden');
                    $generateBtn.prop('disabled', false);
                    
                    // Show error
                    alert(marblecraftML.error);
                }
            });
        }
    });
    
})(jQuery);