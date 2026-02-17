/**
 * Theme Toggle — Dark/Light mode with localStorage persistence.
 *
 * Loaded early (deferred in head) to prevent flash of wrong theme.
 *
 * @package TahsinRahit
 */
(function () {
    'use strict';

    var STORAGE_KEY = 'tahsinrahit-theme';

    /**
     * Get the user's preferred theme.
     * Priority: localStorage > prefers-color-scheme > dark (default).
     */
    function getPreferredTheme() {
        var stored = localStorage.getItem(STORAGE_KEY);
        if (stored === 'light' || stored === 'dark') {
            return stored;
        }
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches) {
            return 'light';
        }
        return 'dark';
    }

    /**
     * Apply the given theme.
     */
    function applyTheme(theme) {
        if (theme === 'light') {
            document.body.classList.add('light-mode');
        } else {
            document.body.classList.remove('light-mode');
        }
        updateIcons(theme);
    }

    /**
     * Update all toggle button icons.
     */
    function updateIcons(theme) {
        var iconName = theme === 'light' ? 'dark_mode' : 'light_mode';
        var icons = document.querySelectorAll('.theme-toggle__icon');
        icons.forEach(function (icon) {
            icon.textContent = iconName;
        });
    }

    /**
     * Toggle between dark and light.
     */
    function toggleTheme() {
        var isLight = document.body.classList.contains('light-mode');
        var newTheme = isLight ? 'dark' : 'light';
        localStorage.setItem(STORAGE_KEY, newTheme);
        applyTheme(newTheme);
    }

    // Apply theme as soon as possible to prevent flash.
    var initialTheme = getPreferredTheme();

    // We need to wait for body to exist. If body exists, apply immediately.
    if (document.body) {
        applyTheme(initialTheme);
    } else {
        // Wait for DOMContentLoaded.
        document.addEventListener('DOMContentLoaded', function () {
            applyTheme(initialTheme);
        });
    }

    // Bind toggle buttons after DOM is ready.
    document.addEventListener('DOMContentLoaded', function () {
        // Re-apply in case it was deferred past body creation.
        applyTheme(getPreferredTheme());

        var toggleButtons = document.querySelectorAll('.theme-toggle');
        toggleButtons.forEach(function (btn) {
            btn.addEventListener('click', toggleTheme);
        });
    });

    // Listen for system theme changes.
    if (window.matchMedia) {
        window.matchMedia('(prefers-color-scheme: light)').addEventListener('change', function (e) {
            // Only auto-switch if user hasn't manually set a preference.
            if (!localStorage.getItem(STORAGE_KEY)) {
                applyTheme(e.matches ? 'light' : 'dark');
            }
        });
    }
})();
