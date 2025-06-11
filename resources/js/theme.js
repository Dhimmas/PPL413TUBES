// Theme management
document.addEventListener('DOMContentLoaded', function() {
    // Check for saved theme preference or default to 'light'
    const currentTheme = localStorage.getItem('theme') || 'light';
    
    // Apply theme on page load
    applyTheme(currentTheme);
    
    // Update toggle button state
    updateToggleButton(currentTheme);
    
    // Add event listener to theme toggle button
    const themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            applyTheme(newTheme);
            localStorage.setItem('theme', newTheme);
            updateToggleButton(newTheme);
        });
    }
});

function applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    
    // Update body classes for better theme support
    if (theme === 'dark') {
        document.body.classList.add('dark-mode');
        document.body.classList.remove('light-mode');
    } else {
        document.body.classList.add('light-mode');
        document.body.classList.remove('dark-mode');
    }
}

function updateToggleButton(theme) {
    const toggleButton = document.getElementById('theme-toggle');
    const toggleIcon = document.getElementById('theme-icon');
    const toggleText = document.getElementById('theme-text');
    
    if (toggleButton && toggleIcon && toggleText) {
        if (theme === 'dark') {
            toggleIcon.innerHTML = '☀️';
            toggleText.textContent = 'Light Mode';
            toggleButton.setAttribute('aria-label', 'Switch to light mode');
        } else {
            toggleIcon.innerHTML = '🌙';
            toggleText.textContent = 'Dark Mode';
            toggleButton.setAttribute('aria-label', 'Switch to dark mode');
        }
    }
}
