var browserSync    = require( 'browser-sync' ),
    critical       = require( 'critical' ),
    fs             = require( 'fs' ),
    gulp           = require( 'gulp' ),
    autoprefixer   = require( 'gulp-autoprefixer' ),
    changed        = require( 'gulp-changed' ),
    cleanCSS       = require( 'gulp-clean-css' ),
    concat         = require( 'gulp-concat' ),
    gulpIf         = require( 'gulp-if' ),
    sass           = require( 'gulp-sass' ),
    sourcemaps     = require( 'gulp-sourcemaps' );
var { rollup } = require( 'rollup' );
var commonjs = require( '@rollup/plugin-commonjs' );
var { nodeResolve } = require( '@rollup/plugin-node-resolve' );
var replace = require( '@rollup/plugin-replace' );

// custom modules
var config  = require( './config.js' ),
    plugins = require( './assets/js/list_plugins.js' ),
    scripts = require( './assets/js/list_scripts.js' ),
    flags   = { production: false };



// Development Tasks 
// -----------------
// Start browserSync server
gulp.task( 'browserSync', function( callback ) {
  browserSync.init( config.sync.server );
  callback();
});
// Sass convert
gulp.task( 'sass', function() {
  return gulp.src( config.paths.scss + '**/*.scss' )
             .pipe( gulpIf( !flags.production, sourcemaps.init() ) )
             .pipe( sass().on( 'error', sass.logError ) )
             .pipe( autoprefixer( { browserslistrc: config.settingsAutoprefixer.browsers } ) )
             .pipe( gulpIf( !flags.production, sourcemaps.write() ) )
             .pipe( changed( config.paths.css, { hasChanged: changed.compareContents } ) )
             .pipe( gulp.dest( config.paths.css ) )
             .pipe( browserSync.reload( { stream: true } ) );
});
// concat all plugins js
gulp.task( 'pluginsScripts', function () {
  return gulp.src( plugins.plugins )
             .pipe( concat( 'plugins.js' ) )
             .pipe( changed( config.paths.scripts, { hasChanged: changed.compareContents } ) )
             .pipe( gulp.dest( config.paths.scripts ) );
});
// concat all custom js
gulp.task( 'customScripts', function () {
  return gulp.src( scripts.scripts )
             .pipe( concat( 'scripts.js' ) )
             .pipe( changed( config.paths.scripts, { hasChanged: changed.compareContents } ) )
             .pipe( gulp.dest( config.paths.scripts ) );
});


// generate js
gulp.task( 'js', function ( callback ) {
  const map = !flags.production ? true : false;
  const files = fs.readdirSync( config.paths.scripts + 'pages' );

  files.forEach(function (file) {
    return rollup({
      input: config.paths.scripts + 'pages/' + file,
      plugins: [
          // babel({ babelHelpers: 'bundled' }),
          commonjs(),
          nodeResolve(),
          replace({ 'process.env.NODE_ENV': JSON.stringify( 'production' ) })
        ]
      })
      .then(bundle => {
        return bundle.write({
          file: config.paths.scripts + file,
          format: 'umd',
          sourcemap: false,
        });
      });
    });

callback();
});


// Watchers
gulp.task( 'watch', function( done ) {
  gulp.watch( config.paths.scss + '**/*.scss', gulp.series( 'sass' ) );
  gulp.watch( config.paths.scripts + '**/*.js', gulp.series( 'customScripts' ) );
  gulp.watch( config.paths.html + '**/*.{php,tpl,html}', browserSync.reload );
  done();
});


// Production Tasks
// -----------------
// Minify css
gulp.task( 'minify', function() {
  return gulp.src( config.paths.css + '**/*.css' )
             .pipe( cleanCSS( {level:{1:{specialComments:0}}}) )
             .pipe( gulp.dest( config.paths.css ) );
});
// critical css
function eachSourcesCritical( index, array, callback ) {
  if ( index < array ) {
    critical.generate({
      base: config.critical.base,
      inline: false,
      include: config.criticalSrcPages[index].include,
      ignore: config.critical.ignore,
      src: config.criticalSrcPages[index].url,
      css: config.critical.css,
      target: {
        css: config.criticalSrcPages[index].css,
      },
      minify: config.critical.minify,
      penthouse: config.critical.penthouse,
      dimensions: config.critical.dimensions
    }).then( function () {
      eachSourcesCritical( index + 1, array );
    });
  } else {
    gulp.task( 'minify' )();
  }
}
gulp.task( 'critical', ( callback ) => {
  let indexEl = 0;
  let lengthCriticalSources = config.criticalSrcPages.length;
  eachSourcesCritical( indexEl, lengthCriticalSources );
  callback();
});



// development - local server - default task
gulp.task( 'default', gulp.series(
  'pluginsScripts',
  'customScripts',
  'sass',
  gulp.parallel(
    'browserSync',
    'watch'
  )
));

// production - live server
gulp.task( 'production', ( callback ) => {
  flags.production = true;
  gulp.series(
    'pluginsScripts',
    'customScripts',
    'sass',
    'minify',
    'critical')();
  callback();
});