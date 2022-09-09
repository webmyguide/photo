// gulpプラグインの読み込み
const gulp = require("gulp");
// Sassをコンパイルするプラグインの読み込み
const sass = require("gulp-sass");

// style.scssの監視タスクを作成する
gulp.task("default", function() {
  // ★ style.scssファイルを監視
  return gulp.watch('./sass/**/*.scss', function() {
    // style.scssの更新があった場合の処理

    // style.scssファイルを取得
    return (
      gulp
        .src('./sass/**/*.scss')
        // Sassのコンパイルを実行
        .pipe(
          sass({
            outputStyle: "compressed",
            includePaths: require('node-bourbon').includePaths
          })
            // Sassのコンパイルエラーを表示
            // (これがないと自動的に止まってしまう)
            .on("error", sass.logError)
        )
        // cssフォルダー以下に保存
        .pipe(gulp.dest('./css/'))
    );
  });
});

//
// const gulp = require('gulp');
// const sass = require('gulp-sass');
// var uglify = require('gulp-uglify');
// var pump = require('pump');
// // var imagemin = require("gulp-imagemin");
// // var imageminJpg = require('imagemin-mozjpeg');
// // var imageminPng = require('imagemin-pngquant');
// // var imageminGif = require('imagemin-gifsicle');
// // const bourbon = require('node-bourbon');
// //
// // bourbon.with = './scss/main';
//
// // SassとCssの保存先を指定
// gulp.task('sass', function(done){
//   gulp.src('./sass/**/*.scss')
//     .pipe(sass({
//       outputStyle: 'compressed',
//       includePaths: require('node-bourbon').includePaths
//     }))
//     .pipe(gulp.dest('./css/'));
//     done();
// });
//
// //自動監視のタスクを作成(sass-watchと名付ける)
// gulp.task('sass-watch', gulp.task('sass'), function(){
//   var watcher = gulp.watch('./sass/**/*.scss', gulp.task('sass'));
//   watcher.on('change', function(event) {
//   });
// });
//
// //画像圧縮 01_yuki/01_tenshoku/southG_corp
// gulp.task("imagemin", function() {  // 「imageMinTask」という名前のタスクを登録
//     gulp.src("./src/*.+(jpg|jpeg|png|gif|svg)")    // imagesフォルダ以下のpng,jpg画像を取得
//     .pipe(imagemin([
//        imageminPng({
//          quality: '65-80',
//          speed: 1,
//          floyd:0
//        }),
//        imageminJpg({
//          quality:85,
//          progressive: true
//        }),
//        imagemin.svgo(),
//        imagemin.optipng(),
//        imagemin.gifsicle()
//      ]
//         ))   // 画像の圧縮処理
//         .pipe(gulp.dest("./images/"));    //保存
// });
//
// //js難読化
// gulp.task('compress', function (cb) {
//   pump([
//         gulp.src('./build/*.js'),
//         uglify(),
//         gulp.dest('./js/')
//     ],
//     cb
//   );
// });
//
// // gulp.task('imagemin', function(){
// //   gulp.src( "./src/**/*.+(jpg|jpeg|png|gif|svg)" )
// //     .pipe(imagemin([
// //        imageminPng({
// //          quality: '65-80',
// //          speed: 1,
// //          floyd:0
// //        }),
// //        imageminJpg({
// //          quality:85,
// //          progressive: true
// //        }),
// //        imagemin.svgo(),
// //        imagemin.optipng(),
// //        imagemin.gifsicle()
// //      ]
// //     ))
// //     .pipe(gulp.dest( "./images/" ));
// // });
//
// // タスク"task-watch"がgulpと入力しただけでdefaultで実行されるようになる
// gulp.task('default', gulp.task('sass-watch'));
