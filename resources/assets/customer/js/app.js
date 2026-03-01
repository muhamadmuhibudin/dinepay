// Customer App JavaScript

// Import dependencies
import $ from 'jquery';
import 'bootstrap';

// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize components
    initializeSpinner();
    initializeBackToTop();
    initializeCart();
    initializeYear();
});

// Spinner functionality
function initializeSpinner() {
    const spinner = document.getElementById('spinner');
    if (spinner) {
        // Hide spinner when page is fully loaded
        window.addEventListener('load', function() {
            setTimeout(function() {
                spinner.classList.remove('show');
                spinner.style.display = 'none';
            }, 500);
        });
    }
}

// Back to top button
function initializeBackToTop() {
    const backToTopButton = document.querySelector('.back-to-top');
    
    if (backToTopButton) {
        // Show/hide button based on scroll position
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.style.display = 'flex';
            } else {
                backToTopButton.style.display = 'none';
            }
        });

        // Smooth scroll to top
        backToTopButton.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
}

// Cart functionality
function initializeCart() {
    // Add to cart buttons
    const addToCartButtons = document.querySelectorAll('a[href="#"]');
    
    addToCartButtons.forEach(button => {
        if (button.textContent.includes('Add to Cart')) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Add visual feedback
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fa fa-check me-2 text-success"></i> Added!';
                button.classList.add('btn-success');
                button.classList.remove('btn-outline-primary');
                
                // Reset after 2 seconds
                setTimeout(function() {
                    button.innerHTML = originalText;
                    button.classList.remove('btn-success');
                    button.classList.add('btn-outline-primary');
                }, 2000);
                
                // Update cart count (if cart element exists)
                updateCartCount();
            });
        }
    });
}

// Update cart count
function updateCartCount() {
    // This would typically update from a server call
    // For now, we'll just show a simple increment
    const cartIcon = document.querySelector('.fa-shopping-bag');
    if (cartIcon && !cartIcon.parentElement.querySelector('.cart-count')) {
        const count = document.createElement('span');
        count.className = 'cart-count position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger';
        count.textContent = '1';
        cartIcon.parentElement.appendChild(count);
    } else {
        const existingCount = document.querySelector('.cart-count');
        if (existingCount) {
            const currentCount = parseInt(existingCount.textContent);
            existingCount.textContent = currentCount + 1;
        }
    }
}

// Set current year
function initializeYear() {
    const yearElement = document.getElementById('currentYear');
    if (yearElement) {
        yearElement.textContent = new Date().getFullYear();
    }
}

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href !== '#' && document.querySelector(href)) {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    });
});

// Navbar scroll effect
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        if (window.scrollY > 50) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
        }
    }
});

// Add navbar scrolled style dynamically
const style = document.createElement('style');
style.textContent = `
    .navbar-scrolled {
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: box-shadow 0.3s ease;
    }
`;
document.head.appendChild(style);

// Export functions for potential use in other modules
export {
    initializeSpinner,
    initializeBackToTop,
    initializeCart,
    updateCartCount
};
