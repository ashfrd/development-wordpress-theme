const gulp = require('gulp');
const autoprefixer = require('autoprefixer');
const sass = require('gulp-sass')(require('sass'));
const concat = require('gulp-concat');
const terser = require('gulp-terser');
const sassGlob = require('gulp-sass-glob');
const plumber = require('gulp-plumber');
const postcss = require('gulp-postcss');
const postcssPresetEnv = require('postcss-preset-env');
const cssnano = require('cssnano');

const isProduction = process.env.NODE_ENV === 'production';

const sassOptions = {
  style: 'compressed',
  loadPaths: ['node_modules'],
  quietDeps: true,
  silenceDeprecations: ['import']
};

const paths = {
  assets: 'assets/',
  acfLayouts: 'acf-layouts/',
  admin: 'admin-area/'
};

const scss = paths.assets + 'src/sass/';
const js = paths.assets + 'src/js/';
const jsDist = paths.assets + 'build/js/';
const vendorDist = paths.assets + 'build/vendor/';

const files = {
  wpStyles: [scss + '**/*.scss', paths.acfLayouts + '**/layout.scss'],
  wpJs: [js + '**/*.js', paths.acfLayouts + '**/layout.js'],
  adminStyles: paths.admin + 'src/**/*.scss',
  adminJs: paths.admin + 'src/**/*.js'
};

// ---------------------------------------------
// Error handling
// ---------------------------------------------

function handleDevelopmentError(error) {
  console.error(`[${error.plugin || 'gulp'}] ${error.message || error}`);

  this.emit('end');
}

// Keep the development watcher running on errors.
// Production builds should fail so broken assets aren't deployed.

function protectDevelopmentStream(stream) {
  if (isProduction) {
    return stream;
  }

  return stream.pipe(
    plumber({
      errorHandler: handleDevelopmentError
    })
  );
}

// ---------------------------------------------
// Vendor files
// ---------------------------------------------

// Copies the npm files needed at runtime into assets/build/vendor/
// so a release does not need node_modules.
function vendorGlide() {
  return gulp
    .src([
      'node_modules/@glidejs/glide/dist/glide.min.js',
      'node_modules/@glidejs/glide/dist/css/glide.core.min.css'
    ])
    .pipe(gulp.dest(vendorDist + 'glide/'));
}

const vendor = vendorGlide;

// ---------------------------------------------
// CSS
// ---------------------------------------------

function css() {
  return protectDevelopmentStream(
    gulp.src(scss + 'style.scss', {
      sourcemaps: !isProduction
    })
  )
    .pipe(sassGlob())
    .pipe(sass(sassOptions))
    .pipe(postcss([postcssPresetEnv({ stage: 1 }), cssnano()]))
    .pipe(concat('theme.min.css'))
    .pipe(gulp.dest(paths.assets + 'build/css/', { sourcemaps: '.' }));
}

function editorCSS() {
  return protectDevelopmentStream(
    gulp.src(scss + 'style-editor.scss', {
      allowEmpty: true
    })
  )
    .pipe(sass(sassOptions))
    .pipe(gulp.dest(paths.assets + 'build/css/'));
}

// ---------------------------------------------
// JavaScript
// ---------------------------------------------

function javascript() {
  return protectDevelopmentStream(
    gulp.src([...files.wpJs], {
      sourcemaps: !isProduction
    })
  )
    .pipe(concat('theme.min.js'))
    .pipe(terser())
    .pipe(
      gulp.dest(jsDist, {
        sourcemaps: '.'
      })
    );
}

// ---------------------------------------------
// Admin assets
// ---------------------------------------------

function adminStyles() {
  return protectDevelopmentStream(
    gulp.src(files.adminStyles, {
      sourcemaps: !isProduction
    })
  )
    .pipe(sassGlob())
    .pipe(sass(sassOptions))
    .pipe(postcss([autoprefixer()]))
    .pipe(gulp.dest(paths.admin + 'dist/', { sourcemaps: '.' }));
}

function adminScripts() {
  return protectDevelopmentStream(
    gulp.src(files.adminJs, {
      sourcemaps: !isProduction
    })
  )
    .pipe(concat('admin-scripts.min.js'))
    .pipe(terser())
    .pipe(gulp.dest(paths.admin + 'dist/', { sourcemaps: '.' }));
}

// ---------------------------------------------
// Watch
// ---------------------------------------------

function watchFiles() {
  gulp.watch([...files.wpStyles], gulp.parallel(css, editorCSS));

  gulp.watch([...files.wpJs], javascript);

  gulp.watch(files.adminStyles, adminStyles);

  gulp.watch(files.adminJs, adminScripts);

}

// ---------------------------------------------
// Build tasks
// ---------------------------------------------

// One-time build.
// Compilation errors are fatal in production
// because plumber is not attached.
const build = gulp.parallel(
  vendor,
  css,
  editorCSS,
  javascript,
  adminStyles,
  adminScripts
);
// Development:
// Compile first, then watch for changes.
const dev = gulp.series(build, watchFiles);

// ---------------------------------------------
// Export tasks
// ---------------------------------------------

exports.vendor = vendor;
exports.css = css;
exports.editorCSS = editorCSS;
exports.javascript = javascript;
exports.adminStyles = adminStyles;
exports.adminScripts = adminScripts;

exports.build = build;
exports.watch = dev;
exports.dev = dev;

// Default: one-time build.
exports.default = build;
