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

// custom modules
var config  = require( './config.js' ),
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
// concat all custom js
gulp.task( 'scripts', function () {
  return gulp.src( scripts.scripts )
             .pipe( concat( 'starter.js' ) )
             .pipe( changed( config.paths.scripts, { hasChanged: changed.compareContents } ) )
             .pipe( gulp.dest( config.paths.scripts ) );
});


// Watchers
gulp.task( 'watch', function( done ) {
  gulp.watch( config.paths.scss + '**/*.scss', gulp.series( 'sass' ) );
  gulp.watch( config.paths.scripts + '**/*.js', gulp.series( 'scripts' ) );
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
  'scripts',
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
    'scripts',
    'sass',
    'minify',
    'critical')();
  callback();
});