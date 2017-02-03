var gulp = require('gulp');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
var concat = require('gulp-concat');
var sass = require('gulp-sass');
var browserSync = require('browser-sync');


gulp.task('watch', ['browser-sync', 'sass','scripts'], function () {
    gulp.watch('resources/assets/sass/**/*.scss', ['sass']);
    gulp.watch('app/**/*.php', browserSync.reload);
    gulp.watch('routes/**/*.php', browserSync.reload);
    gulp.watch('resources/**/*.php', browserSync.reload);
    gulp.watch('public/**/*.js', ['scripts']);
    gulp.watch('public/**/*.html', browserSync.reload);
});
gulp.task('sass', function () {
    return gulp.src('resources/assets/sass/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(sourcemaps.write())
        .pipe(autoprefixer({
            browsers: ['last 10 versions', '> 5%', 'Firefox ESR']
        }))
        .pipe(gulp.dest('public/css'))
        .pipe(browserSync.stream());
});
gulp.task('scripts', function() {
    return gulp.src(['public/project/angular-app/**/*.module.js', 
        'public/project/angular-app/**/!(all)*.js',
        'public/js/jquery.min.js',
        'public/js/bootstrap.min.js',
        'assets/MDB Free/js/mdb.min.js'
    ])
        .pipe(concat('all.js'))
        .pipe(gulp.dest('public/project/angular-app/'))
        .pipe(browserSync.reload({stream: true}));
});
gulp.task('browser-sync',['sass'], function () {
    browserSync.init({
        open: 'external',
        host: 'modern-programmer',
        proxy: "modern-programmer",
        notify: false
    })
});


gulp.task('default', ['browser-sync','watch']);

// const elixir = require('laravel-elixir');
// require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */
//
// elixir((mix) => {
//     mix.sass('app.scss')
//        .webpack('app.js');
// });
