const browserSync    = require( 'browser-sync' ),
	  critical       = require( 'critical' ),
	  gulp           = require( 'gulp' ),
	  autoprefixer   = require( 'gulp-autoprefixer' ),
	  cleanCSS       = require( 'gulp-clean-css' ),
	  concat         = require( 'gulp-concat' ),
	  gulpIf         = require( 'gulp-if' ),
	  sass           = require( 'gulp-sass' )(require( 'sass' )),
	  sourcemaps     = require( 'gulp-sourcemaps' );

// custom modules
const config  = require( './config.js' ),
	  scripts = require( './assets/js/list_scripts.js' ),
	  flags   = { production: false };


// Development Tasks 
// -----------------
// Start browserSync server
gulp.task( 'browserSync', callback => {
	browserSync.init( config.sync.server );
	callback();
});
// Sass convert
gulp.task( 'sass', () => {
	return gulp.src( config.paths.scss + '**/*.scss' )
			   .pipe( gulpIf( !flags.production, sourcemaps.init() ) )
			   .pipe( sass().on( 'error', sass.logError ) )
			   .pipe( autoprefixer( { browserslistrc: config.settingsAutoprefixer.browsers } ) )
			   .pipe( gulpIf( !flags.production, sourcemaps.write() ) )
			   .pipe( gulp.dest( config.paths.css ) )
			   .pipe( browserSync.reload( { stream: true } ) );
});
// concat all custom js
gulp.task( 'scripts', () => {
	return gulp.src( scripts.scripts )
			   .pipe( concat( 'starter.js' ) )
			   .pipe( gulp.dest( config.paths.scripts ) );
});
// Watchers
gulp.task( 'watch', done => {
	gulp.watch( config.paths.scss + '**/*.scss', gulp.series( 'sass' ) );
	gulp.watch( config.paths.scripts + '**/*.js', gulp.series( 'scripts' ) );
	gulp.watch( config.paths.html + '**/*.{php,tpl,html}', browserSync.reload );
	done();
});


// Production Tasks
// -----------------
// Minify css
gulp.task( 'minify', () => {
	return gulp.src( config.paths.css + '**/*.css' )
			   .pipe( cleanCSS( {level:{1:{specialComments:0}}}) )
			   .pipe( gulp.dest( config.paths.css ) );
});
// critical css
const eachSourcesCritical = ( index, array, callback ) => {
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
			penthouse: config.critical.penthouse,
			dimensions: config.critical.dimensions
		}).then( () => {
			eachSourcesCritical( index + 1, array );
		});
	} else {
		gulp.task( 'minify' )();
	}
}
gulp.task( 'critical', callback => {
	let indexEl = 0;
	const lengthCriticalSources = config.criticalSrcPages.length;
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

// production - remote server
gulp.task( 'production', callback => {
	flags.production = true;
	gulp.series(
		'scripts',
		'sass',
		'minify',
		'critical')();
	callback();
});