// public/js/app.js

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initializeSidebar();
    initializeDropdowns();
    initializeAlerts();
    initializeTooltips();
    handleResponsiveLayout();
});

function initializeSidebar() {
    // Create mobile menu toggle button
    const menuToggle = document.createElement('button');
    menuToggle.className = 'menu-toggle';
    menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
    menuToggle.setAttribute('aria-label', 'Toggle Menu');

    if (!document.querySelector('.menu-toggle')) {
        document.body.appendChild(menuToggle);
    }

    // Handle menu toggle click
    menuToggle.addEventListener('click', function(e) {
        e.stopPropagation();
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('show');
    });

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        const sidebar = document.getElementById('sidebar');
        const menuToggle = document.querySelector('.menu-toggle');

        if (!sidebar.contains(e.target) &&
            !menuToggle.contains(e.target) &&
            window.innerWidth <= 768) {
            sidebar.classList.remove('show');
        }
    });
}

function initializeDropdowns() {
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = this.nextElementSibling;

            // Close all other dropdowns
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                if (menu !== dropdown) {
                    menu.classList.remove('show');
                }
            });

            dropdown.classList.toggle('show');
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.matches('.dropdown-toggle')) {
            document.querySelectorAll('.dropdown-menu').forEach(dropdown => {
                dropdown.classList.remove('show');
            });
        }
    });
}

function initializeAlerts() {
    const alerts = document.querySelectorAll('.alert');

    alerts.forEach(alert => {
        // Add close button
        const closeBtn = document.createElement('button');
        closeBtn.className = 'alert-close';
        closeBtn.innerHTML = '<i class="fas fa-times"></i>';
        closeBtn.setAttribute('aria-label', 'Close Alert');

        closeBtn.addEventListener('click', () => removeAlert(alert));
        alert.appendChild(closeBtn);

        // Auto-hide alerts after 5 seconds
        setTimeout(() => removeAlert(alert), 5000);
    });
}

function removeAlert(alert) {
    alert.style.opacity = '0';
    alert.style.transform = 'translateY(-10px)';

    setTimeout(() => {
        alert.remove();
    }, 300);
}

function initializeTooltips() {
    const tooltipTriggers = document.querySelectorAll('[data-tooltip]');

    tooltipTriggers.forEach(trigger => {
        trigger.addEventListener('mouseenter', function(e) {
            const tooltipText = this.getAttribute('data-tooltip');

            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = tooltipText;

            document.body.appendChild(tooltip);

            const triggerRect = this.getBoundingClientRect();
            const tooltipRect = tooltip.getBoundingClientRect();

            tooltip.style.top = `${triggerRect.top - tooltipRect.height - 10}px`;
            tooltip.style.left = `${triggerRect.left + (triggerRect.width - tooltipRect.width) / 2}px`;

            setTimeout(() => tooltip.classList.add('show'), 50);
        });

        trigger.addEventListener('mouseleave', function() {
            const tooltip = document.querySelector('.tooltip');
            if (tooltip) {
                tooltip.remove();
            }
        });
    });
}

function handleResponsiveLayout() {
    const handleResize = () => {
        const sidebar = document.getElementById('sidebar');
        if (window.innerWidth > 768) {
            sidebar.classList.remove('show');
        }
    };

    window.addEventListener('resize', handleResize);
    handleResize();
}

// Add CSRF token to all AJAX requests
const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
if (token) {
    window.axios = require('axios');
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
}
