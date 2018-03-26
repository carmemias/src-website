'use strict';

var gulp = require( 'gulp' ),
    sass = require( 'gulp-sass' ),
    paths = {
      css: {
        all: 'themes/src-project/sass/**/*.scss',
        src: 'themes/src-project/sass/style.scss',
        dest: 'themes/src-project/'
      }
    };

gulp.task( 'styles', function(){

  return gulp.src( paths.css.src )
    .pipe( sass({
      errLogToConsole: true,
      outputStyle: 'compressed'
    }) )
    .pipe( gulp.dest( paths.css.dest ));

});

gulp.task( 'watch', function(){

  gulp.watch( paths.css.all, ['styles'] );

} );

gulp.task( 'default', ['watch']);
