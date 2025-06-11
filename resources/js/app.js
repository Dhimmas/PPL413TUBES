import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Mobile theme toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners for mobile theme toggles
    const mobileToggle = document.getElementById('mobile-theme-toggle');
    const mobileToggleGuest = document.getElementById('mobile-theme-toggle-guest');
    
    if (mobileToggle) {
        mobileToggle.addEventListener('click', function() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            applyTheme(newTheme);
            localStorage.setItem('theme', newTheme);
            updateAllToggleButtons(newTheme);
        });
    }
    
    if (mobileToggleGuest) {
        mobileToggleGuest.addEventListener('click', function() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            applyTheme(newTheme);
            localStorage.setItem('theme', newTheme);
            updateAllToggleButtons(newTheme);
        });
    }
});

// Update all toggle buttons (desktop and mobile)
function updateAllToggleButtons(theme) {
    // Desktop toggle
    updateToggleButton(theme);
    
    // Mobile toggle (authenticated)
    const mobileIcon = document.getElementById('mobile-theme-icon');
    const mobileText = document.getElementById('mobile-theme-text');
    
    if (mobileIcon && mobileText) {
        if (theme === 'dark') {
            mobileIcon.textContent = '☀️';
            mobileText.textContent = 'Light Mode';
        } else {
            mobileIcon.textContent = '🌙';
            mobileText.textContent = 'Dark Mode';
        }
    }
    
    // Mobile toggle (guest)
    const mobileIconGuest = document.getElementById('mobile-theme-icon-guest');
    const mobileTextGuest = document.getElementById('mobile-theme-text-guest');
    
    if (mobileIconGuest && mobileTextGuest) {
        if (theme === 'dark') {
            mobileIconGuest.textContent = '☀️';
            mobileTextGuest.textContent = 'Light Mode';
        } else {
            mobileIconGuest.textContent = '🌙';
            mobileTextGuest.textContent = 'Dark Mode';
        }
    }
}
