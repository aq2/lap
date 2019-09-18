const del = require('del'),
      gulp = require('gulp'),
      pug  = require('gulp-pug'),
      rename = require('gulp-rename'),
      stylus = require('gulp-stylus'),
      notify = require('gulp-notify'),    // apt install libnotify-bin
      plumber = require('gulp-plumber'),
      exec = require('child_process').exec,
      browsersync = require('browser-sync'),
      sourcemaps = require('gulp-sourcemaps')


function customPlumber(errTitle) {
  // exec("espeak -ven+m1 'oops gulp'")
  return plumber({
    errorHandler: notify.onError({
      title: errTitle || 'Gulp Error',
      message: 'Error: <%= error.message %>'
    })
  })
}


function gza() {
  return gulp.src('./www/index.php')
             .pipe(notify('🏠 Gulp building to be born 🏠'))
}
exports.gza = gza


function images() {
  return gulp.src('src/images/**/*.*')
             .pipe(gulp.dest('www/images'))
}
exports.images = images


function includes() {
  return gulp.src('src/includes/**/*.pug')
            .pipe(customPlumber('includes'))
            .pipe(pug())
}
exports.includes = includes


function index() {
  return gulp.src('src/index.pug')
             .pipe(pug())
             .pipe(customPlumber('index'))
             .pipe(rename({ extname: '.php' }))
             .pipe(gulp.dest('www'))
}
exports.index = index


function js() {
  return gulp.src('src/js/**/*.js')
             .pipe(customPlumber('javascript'))
             .pipe(gulp.dest('www/js'))
}
exports.js = js


function nuke() {
  gulp.src('src')
      .pipe(notify('😱 Gulp nuke and pave 😱'))
  exec('espeak -ven+f5 nuke')
  return del('www/**/*')
}
exports.nuke = nuke


function pages() {
  return gulp.src('src/pages/**/*.pug')
             .pipe(customPlumber('pages'))
             .pipe(pug())
             .pipe(gulp.dest('www/pages'))
}
exports.pages = pages


function phps() {
  return gulp.src('./src/php/**/*.php')
             .pipe(customPlumber('php'))
             .pipe(gulp.dest('www/php'))
}
exports.phps = phps



function adminStuff() {
  return gulp.src('./src/admin/**/*')
             .pipe(gulp.dest('www/admin'))
}
exports.adminStuff = adminStuff

// function adminHtml() {
//   return gulp.src('./src/admin/**/*.html')
//              .pipe(customPlumber('html'))
//              .pipe(gulp.dest('www/admin'))
// }
// exports.adminHtml = adminHtml


// function adminPhps() {
//   return gulp.src('./src/admin/**/*.php')
//              .pipe(customPlumber('php'))
//              .pipe(gulp.dest('www/admin'))
// }
// exports.adminPhps = adminPhps


function styles() {
  return gulp.src('src/stylus/main.styl')
             .pipe(sourcemaps.init())
             .pipe(stylus({ compress: true }))
             .pipe(customPlumber('stylus'))
             .pipe(rename({ suffix: '.min' }))
             .pipe(sourcemaps.write('./'))
             .pipe(gulp.dest('./www'))
             .pipe(browsersync.stream())
}
exports.styles = styles


function syncBrowser() {
  browsersync.init({
    proxy: 'localhost:80',
    open: false
  })
}
exports.syncBrowser = syncBrowser


function reloadBrowser(done) {
  browsersync.reload();
  done();
}
exports.reloadBrowser = reloadBrowser


function watchFiles() {
  // gulp.watch('./src/images/**/*.*', images)
  gulp.watch('./src/stylus/**/*.styl', styles)
  gulp.watch('./src/js/**/*.js', gulp.series(js, reloadBrowser))
  gulp.watch('./src/php/**/*.php', gulp.series(phps, reloadBrowser))
  // gulp.watch('./src/admin/**/*.php', gulp.series(adminPhps, reloadBrowser))
  gulp.watch('./src/admin/**/*.*', gulp.series(adminStuff, reloadBrowser))

  gulp.watch('./src/index.pug', gulp.series(index, reloadBrowser))
  gulp.watch('./src/pages/**/*.pug', gulp.series(pages, reloadBrowser))
  gulp.watch('./src/includes/**/*.pug', gulp.series(includes, gulp.parallel(pages, index), reloadBrowser))

  exec('espeak -ven+f5 watching')
  gulp.src('./src/index.*').pipe(notify('👓 Gulp up, running and watching 👓'))
}
exports.watchFiles = watchFiles


// define complex multi-tasks
const build = gulp.series(
  nuke,
  includes,
  gulp.parallel(index, pages, js, phps, images, styles, adminStuff),
  gza
)
exports.build = build


const watch = gulp.parallel(watchFiles, syncBrowser)
exports.watch = watch


exports.default = gulp.series(build, watch)
