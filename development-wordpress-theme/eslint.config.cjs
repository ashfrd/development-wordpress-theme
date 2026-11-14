
const js = require('@eslint/js');
const globals = require('globals');

module.exports = [
  // Ignore generated assets and third-party code.
  {
    ignores: [
      'node_modules/**',
      'vendor/**',
      'assets/build/**',
      'admin-area/dist/**'
    ]
  },

  // Enable ESLint's recommended JavaScript rules.
  js.configs.recommended,

  // Shared rules for all JavaScript files.
  {
    files: ['**/*.{js,cjs,mjs}'],
    rules: {
      'no-unused-vars': 'warn',
      eqeqeq: ['error', 'always'],
      semi: ['error', 'always'],
      quotes: ['error', 'single']
    }
  },

  // Node.js files, including the Gulp build configuration.
  {
    files: ['gulpfile.js', 'eslint.config.cjs'],
    languageOptions: {
      sourceType: 'commonjs',
      globals: globals.node
    },
    rules: {
      'no-console': 'off'
    }
  },

  // Browser JavaScript.
  {
    files: [
      'assets/src/js/**/*.js',
      'acf-layouts/**/layout.js',
      'admin-area/src/**/*.js'
    ],
    languageOptions: {
      ecmaVersion: 'latest',
      sourceType: 'script',
      globals: globals.browser
    },
    rules: {
      'no-console': 'warn'
    }
  }
];
