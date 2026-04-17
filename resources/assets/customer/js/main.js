import $ from 'jquery';

(function ($) {
    'use strict';

    console.log('Main.js loaded');

    // Spinner
    var spinner = function () {
        console.log('Spinner function called');
        setTimeout(function () {
            console.log('Removing spinner');
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
                console.log('Spinner removed');
            }
        }, 1000);
    };
    
    // Wait for DOM
    $(document).ready(function() {
        console.log('DOM ready');
        spinner();
    });

    // Fixed Navbar
    $(window).scroll(function () {
        if ($(window).width() < 992) {
            if ($(this).scrollTop() > 55) {
                $('.fixed-top').addClass('shadow');
            } else {
                $('.fixed-top').removeClass('shadow');
            }
        } else {
            if ($(this).scrollTop() > 55) {
                $('.fixed-top').addClass('shadow').css('top', -55);
            } else {
                $('.fixed-top').removeClass('shadow').css('top', 0);
            }
        }
    });

    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });

    $('.back-to-top').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 1500, 'easeInOutExpo');
        return false;
    });

    if ($.fn.owlCarousel) {
        // Testimonial carousel
        $('.testimonial-carousel').owlCarousel({
            autoplay: true,
            smartSpeed: 2000,
            center: false,
            dots: true,
            loop: true,
            margin: 25,
            nav: true,
            navText: [
                '<i class="bi bi-arrow-left"></i>',
                '<i class="bi bi-arrow-right"></i>'
            ],
            responsiveClass: true,
            responsive: {
                0: { items: 1 },
                576: { items: 1 },
                768: { items: 1 },
                992: { items: 2 },
                1200: { items: 2 }
            }
        });

        // Vegetable carousel
        $('.vegetable-carousel').owlCarousel({
            autoplay: true,
            smartSpeed: 1500,
            center: false,
            dots: true,
            loop: true,
            margin: 25,
            nav: true,
            navText: [
                '<i class="bi bi-arrow-left"></i>',
                '<i class="bi bi-arrow-right"></i>'
            ],
            responsiveClass: true,
            responsive: {
                0: { items: 1 },
                576: { items: 1 },
                768: { items: 2 },
                992: { items: 3 },
                1200: { items: 4 }
            }
        });
    }

    // Modal Video
    $(document).ready(function () {
        var $videoSrc;

        $('.btn-play').click(function () {
            $videoSrc = $(this).data('src');
        });

        $('#videoModal').on('shown.bs.modal', function () {
            $('#video').attr('src', $videoSrc + '?autoplay=1&amp;modestbranding=1&amp;showinfo=0');
        });

        $('#videoModal').on('hide.bs.modal', function () {
            $('#video').attr('src', $videoSrc);
        });
    });

    // Product Quantity
    $('.quantity button').on('click', function () {
        var button = $(this);
        var oldValue = button.parent().parent().find('input').val();
        var newVal;

        if (button.hasClass('btn-plus')) {
            newVal = parseFloat(oldValue) + 1;
        } else {
            if (oldValue > 0) {
                newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }

        button.parent().parent().find('input').val(newVal);
    });

    // Add to Cart functionality
    $('.btn').on('click', function(e) {
        if ($(this).text().includes('Add to Cart')) {
            e.preventDefault();
            
            var button = $(this);
            var originalText = button.html();
            
            // Show loading state
            button.html('<i class="fa fa-spinner fa-spin me-2"></i> Adding...');
            button.prop('disabled', true);
            
            // Simulate adding to cart
            setTimeout(function() {
                button.html('<i class="fa fa-check me-2 text-success"></i> Added!');
                button.removeClass('text-primary').addClass('text-success');
                
                // Update cart count
                updateCartCount();
                
                // Reset button after 2 seconds
                setTimeout(function() {
                    button.html(originalText);
                    button.removeClass('text-success').addClass('text-primary');
                    button.prop('disabled', false);
                }, 2000);
            }, 500);
        }
    });

    // Update cart count function
    function updateCartCount() {
        var cartIcon = $('.fa-shopping-bag').parent();
        var badge = cartIcon.find('.badge');
        
        if (badge.length === 0) {
            cartIcon.append('<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">1</span>');
        } else {
            var count = parseInt(badge.text());
            badge.text(count + 1);
        }
    }
})($);
