import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue'
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans]
      },
      colors: {
        primary: 'var(--md-sys-color-primary)',
        'surface-tint': 'var(--md-sys-color-surface-tint)',
        'on-primary': 'var(--md-sys-color-on-primary)',
        'primary-container': 'var(--md-sys-color-primary-container)',
        'on-primary-container': 'var(--md-sys-color-on-primary-container)',
        secondary: 'var(--md-sys-color-secondary)',
        'on-secondary': 'var(--md-sys-color-on-secondary)',
        'secondary-container': 'var(--md-sys-color-secondary-container)',
        'on-secondary-container': 'var(--md-sys-color-on-secondary-container)',
        tertiary: 'var(--md-sys-color-tertiary)',
        'on-tertiary': 'var(--md-sys-color-on-tertiary)',
        'tertiary-container': 'var(--md-sys-color-tertiary-container)',
        'on-tertiary-container': 'var(--md-sys-color-on-tertiary-container)',
        error: 'var(--md-sys-color-error)',
        'on-error': 'var(--md-sys-color-on-error)',
        'error-container': 'var(--md-sys-color-error-container)',
        'on-error-container': 'var(--md-sys-color-on-error-container)',
        background: 'var(--md-sys-color-background)',
        'on-background': 'var(--md-sys-color-on-background)',
        surface: 'var(--md-sys-color-surface)',
        'on-surface': 'var(--md-sys-color-on-surface)',
        'surface-variant': 'var(--md-sys-color-surface-variant)',
        'on-surface-variant': 'var(--md-sys-color-on-surface-variant)',
        outline: 'var(--md-sys-color-outline)',
        'outline-variant': 'var(--md-sys-color-outline-variant)',
        shadow: 'var(--md-sys-color-shadow)',
        scrim: 'var(--md-sys-color-scrim)',
        'inverse-surface': 'var(--md-sys-color-inverse-surface)',
        'inverse-on-surface': 'var(--md-sys-color-inverse-on-surface)',
        'inverse-primary': 'var(--md-sys-color-inverse-primary)',
        'primary-fixed': 'var(--md-sys-color-primary-fixed)',
        'on-primary-fixed': 'var(--md-sys-color-on-primary-fixed)',
        'primary-fixed-dim': 'var(--md-sys-color-primary-fixed-dim)',
        'on-primary-fixed-variant': 'var(--md-sys-color-on-primary-fixed-variant)',
        'secondary-fixed': 'var(--md-sys-color-secondary-fixed)',
        'on-secondary-fixed': 'var(--md-sys-color-on-secondary-fixed)',
        'secondary-fixed-dim': 'var(--md-sys-color-secondary-fixed-dim)',
        'on-secondary-fixed-variant': 'var(--md-sys-color-on-secondary-fixed-variant)',
        'tertiary-fixed': 'var(--md-sys-color-tertiary-fixed)',
        'on-tertiary-fixed': 'var(--md-sys-color-on-tertiary-fixed)',
        'tertiary-fixed-dim': 'var(--md-sys-color-tertiary-fixed-dim)',
        'on-tertiary-fixed-variant': 'var(--md-sys-color-on-tertiary-fixed-variant)',
        'surface-dim': 'var(--md-sys-color-surface-dim)',
        'surface-bright': 'var(--md-sys-color-surface-bright)',
        'surface-container-lowest': 'var(--md-sys-color-surface-container-lowest)',
        'surface-container-low': 'var(--md-sys-color-surface-container-low)',
        'surface-container': 'var(--md-sys-color-surface-container)',
        'surface-container-high': 'var(--md-sys-color-surface-container-high)',
        'surface-container-highest': 'var(--md-sys-color-surface-container-highest)',
        'custom-color-color': 'var(--md-extended-color-custom-color-color)',
        'custom-color-on-color': 'var(--md-extended-color-custom-color-on-color)',
        'custom-color-color-container': 'var(--md-extended-color-custom-color-color-container)',
        'custom-color-on-color-container':
          'var(--md-extended-color-custom-color-on-color-container)'
      },
      screens: {
        'xs': '428px',
        'sm': '640px',
        'md': '768px',
        'lg': '1024px',
        'xl': '1280px',
        '2xl': '1536px',
      }
    },
    
  },

  plugins: [forms, require('tailwind-scrollbar'), require('daisyui')]
};
