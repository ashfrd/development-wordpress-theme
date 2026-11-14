# WordPress Parent Theme

A custom WordPress starter theme I'm building for my development portfolio.

The theme uses standard WordPress PHP templates alongside ACF flexible content layouts. I've kept the different parts of the theme separated to make it easier to add new components and maintain the code.

## Theme structure

```text
acf-json/       ACF field group definitions
acf-layouts/    Flexible content layouts
assets/
  src/          Source SCSS and JavaScript
  build/        Compiled CSS, JS and vendor assets
inc/
  helpers/      Navigation walkers
  theme/        Theme setup, assets and ACF functions
templates/      Reusable WordPress template parts
```

## ACF flexible content

The theme uses ACF Pro to build pages from reusable layouts.

Each layout has its own directory inside `acf-layouts/`, containing:

- `output.php` — Layout markup and ACF fields
- `layout.scss` — Layout styling
- `layout.js` — Layout-specific JavaScript, where needed

Layout names are converted into folder names automatically, so there's no need to register each layout separately in PHP.

For example, an ACF layout named `text_and_image` would use:

```text
acf-layouts/text-and-image/
```

The ACF field group configuration is stored in `acf-json/` so changes can be tracked in Git.

## Child theme

The accompanying child theme is used for custom ACF Gutenberg blocks.

Blocks are registered using `block.json` and PHP render templates. Their ACF field groups are kept in the child theme, separate from the parent's flexible content fields.

## Frontend assets

I'm using Gulp to compile the theme's SCSS and JavaScript.

The build process handles Sass compilation, PostCSS, minification, source maps during development and copying any vendor assets needed by the theme.

JavaScript from the ACF layout directories is also included in the build.

### Requirements

- WordPress
- PHP 8.2 or later
- ACF Pro
- Node.js 24 or 26
- npm

Composer is also used for PHP_CodeSniffer and WordPress Coding Standards during development.

### Setup

From the parent theme directory, install the Node dependencies:

```bash
npm ci
```

If using the Composer development tools:

```bash
composer install
```

### Development

Start the development build and file watcher:

```bash
npm run dev
```

Create a production build:

```bash
npm run build
```

Run ESLint:

```bash
npm run lint
```

Run linting and the production build together:

```bash
npm run check
```

Compiled frontend assets are saved in `assets/build/`.

## Code standards

The project uses ESLint and Prettier for JavaScript formatting, EditorConfig for consistent indentation, and PHP_CodeSniffer with WordPress Coding Standards for PHP.

The production build is configured to stop if compilation fails, while development errors are logged without stopping the file watcher.

## Project status

This theme is still being developed. The core structure and build tooling are in place, and I'm continuing to add layouts, templates and frontend functionality.

The aim is to build a simple best-practice theme, which is reusable and easy to maintain. I plan to expand this over time to showcase skills and use this as a playground for WordPress development.
