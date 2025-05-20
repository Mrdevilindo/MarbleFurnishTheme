/**
 * Main JavaScript file for MarbleCraft WordPress theme
 *
 * Handles:
 * - Mobile menu toggle
 * - Contact form submission and validation
 * - Product gallery image switching
 * - Share functionality
 */

(function($) {
    'use strict';

    /**
     * Mobile Menu Toggle
     */
    function initMobileMenu() {
        const menuToggle = $('#mobile-menu-toggle');
        const mobileMenu = $('#mobile-menu');

        if (menuToggle.length && mobileMenu.length) {
            menuToggle.on('click', function() {
                mobileMenu.toggleClass('hidden');
            });
        }
    }

    /**
     * Contact Form Handling
     */
    function initContactForm() {
        const form = $('#contact-form');
        const response = $('#form-response');

        if (form.length) {
            form.on('submit', function(e) {
                e.preventDefault();

                // Clear previous responses
                response.removeClass('bg-green-100 text-green-700 bg-red-100 text-red-700').addClass('hidden');

                // Validate form fields
                const name = $('#name').val().trim();
                const email = $('#email').val().trim();
                const country = $('#country').val().trim();
                const message = $('#message').val().trim();
                let isValid = true;
                let errorMessages = [];

                if (!name) {
                    isValid = false;
                    errorMessages.push('Please enter your name.');
                    $('#name').addClass('border-red-500');
                } else {
                    $('#name').removeClass('border-red-500');
                }

                if (!email) {
                    isValid = false;
                    errorMessages.push('Please enter your email address.');
                    $('#email').addClass('border-red-500');
                } else if (!isValidEmail(email)) {
                    isValid = false;
                    errorMessages.push('Please enter a valid email address.');
                    $('#email').addClass('border-red-500');
                } else {
                    $('#email').removeClass('border-red-500');
                }

                if (!country) {
                    isValid = false;
                    errorMessages.push('Please enter your country.');
                    $('#country').addClass('border-red-500');
                } else {
                    $('#country').removeClass('border-red-500');
                }

                if (!message) {
                    isValid = false;
                    errorMessages.push('Please enter your message.');
                    $('#message').addClass('border-red-500');
                } else {
                    $('#message').removeClass('border-red-500');
                }

                // Check if reCAPTCHA is enabled and verified
                if ($('.g-recaptcha').length && typeof grecaptcha !== 'undefined') {
                    const recaptchaResponse = grecaptcha.getResponse();
                    if (!recaptchaResponse) {
                        isValid = false;
                        errorMessages.push('Please complete the reCAPTCHA verification.');
                    }
                }

                if (!isValid) {
                    displayError('Please correct the following errors:', errorMessages);
                    return;
                }

                // Show loading state
                form.find('button[type="submit"]').prop('disabled', true)
                    .html('<svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Sending...');

                // Prepare form data
                const formData = new FormData(form[0]);
                formData.append('action', 'marblecraft_submit_form');
                formData.append('nonce', marblecraftData.nonce);

                // Submit form via AJAX
                $.ajax({
                    url: marblecraftData.ajaxurl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.success) {
                            // Show success message
                            form[0].reset();
                            displaySuccess(res.data.message);
                            
                            // Reset reCAPTCHA if it exists
                            if (typeof grecaptcha !== 'undefined') {
                                grecaptcha.reset();
                            }
                        } else {
                            // Show error message
                            displayError(res.data.message, res.data.errors);
                        }
                    },
                    error: function() {
                        displayError('An error occurred. Please try again later.');
                    },
                    complete: function() {
                        // Reset button state
                        form.find('button[type="submit"]').prop('disabled', false)
                            .text('Send Message');
                    }
                });
            });
        }

        // Helper function to validate email
        function isValidEmail(email) {
            const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }

        // Helper function to display error message
        function displayError(message, errors = []) {
            let errorHtml = '<p>' + message + '</p>';
            
            if (errors.length) {
                errorHtml += '<ul class="list-disc pl-5 mt-2">';
                errors.forEach(function(error) {
                    errorHtml += '<li>' + error + '</li>';
                });
                errorHtml += '</ul>';
            }
            
            response.html(errorHtml)
                .removeClass('hidden bg-green-100 text-green-700')
                .addClass('bg-red-100 text-red-700');
        }

        // Helper function to display success message
        function displaySuccess(message) {
            response.html('<p>' + message + '</p>')
                .removeClass('hidden bg-red-100 text-red-700')
                .addClass('bg-green-100 text-green-700');
        }
    }

    /**
     * Product Gallery Image Switching
     */
    function initProductGallery() {
        // This would be expanded in a real implementation with actual gallery images
        $('.additional-images div').on('click', function() {
            // In a real implementation, this would switch the main image
            console.log('Thumbnail clicked');
        });
    }

    /**
     * Share Product Functionality
     */
    function initShareProduct() {
        const shareButton = $('#share-product');
        
        if (shareButton.length) {
            shareButton.on('click', function() {
                if (navigator.share) {
                    // Use Web Share API if available
                    navigator.share({
                        title: document.title,
                        url: window.location.href
                    }).catch(console.error);
                } else {
                    // Fallback to copy to clipboard
                    const tempInput = document.createElement('input');
                    tempInput.value = window.location.href;
                    document.body.appendChild(tempInput);
                    tempInput.select();
                    document.execCommand('copy');
                    document.body.removeChild(tempInput);
                    
                    // Show copied message
                    const originalText = shareButton.html();
                    shareButton.html('<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check mr-2"><polyline points="20 6 9 17 4 12"></polyline></svg> Copied!');
                    
                    setTimeout(function() {
                        shareButton.html(originalText);
                    }, 2000);
                }
            });
        }
    }

    /**
     * Initialize all functions on document ready
     */
    $(document).ready(function() {
        initMobileMenu();
        initContactForm();
        initProductGallery();
        initShareProduct();
    });

})(jQuery);
