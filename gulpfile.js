'use strict';

var gulp = require( 'gulp' ),
    sass = require( 'gulp-sass' );

gulp.task( 'styles', function(){

  return gulp.src( 'themes/rsfestival-theme/assets/sass/style.scss' )
    .pipe( sass({
      errLogToConsole: true,
      outputStyle: 'expanded'
    }) )
    .pipe( gulp.dest( 'themes/rsfestival-theme/' ));

});

gulp.task( 'watch', function(){

  gulp.watch( 'themes/rsfestival-theme/assets/sass/**/*.scss', ['styles'] );

} );
