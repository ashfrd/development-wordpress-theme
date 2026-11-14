# WordPress Development Theme

A personal WordPress development project I'm using to build and improve a reusable theme setup.

The project consists of a parent theme and a child theme. The parent handles the main WordPress templates, ACF flexible content layouts and frontend assets, while the child theme is used for custom ACF Gutenberg blocks.

The aim is to have a starting point I can build on, while keeping the code organised and following WordPress development best practices.

## Project structure

```text
development-wordpress-theme/
development-wordpress-theme-child/
```

**Parent theme — `development-wordpress-theme`**

Contains the main theme functionality, PHP templates, navigation walkers, ACF flexible content layouts and frontend build setup.

**Child theme — `development-wordpress-theme-child`**

Used for developing custom ACF Gutenberg blocks. Each block has its own configuration, PHP template and styling.

## Technologies

- WordPress / PHP
- Advanced Custom Fields Pro
- JavaScript
- SCSS / Bootstrap
- Gulp
- ESLint / Prettier
- Composer / WordPress Coding Standards

## Installation

Both theme folders should be placed inside a WordPress installation's `wp-content/themes/` directory.

ACF Pro is required for the flexible content layouts and custom blocks.

The parent theme can be activated on its own. To use the custom ACF blocks, activate the child theme instead.

See the [parent theme README](development-wordpress-theme/README.md) for development setup and build instructions.

## Project status

This is a work in progress. I'm continuing to develop the components, improve the code and add functionality as I go.

## Licence

This project is licensed under the GNU General Public License v2 or later (GPL-2.0-or-later).

See [LICENSE](LICENSE) for details.

Third-party libraries retain their own licences and copyright notices.
