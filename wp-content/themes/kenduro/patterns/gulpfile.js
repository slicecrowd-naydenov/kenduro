/* eslint-disable valid-jsdoc */
/* eslint-disable prefer-template */
'use strict';

const serverIP = '192.168.0.31';
const serverPort = '8000';

// Load dependencies.
const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const sourcemaps = require('gulp-sourcemaps');
const gutil = require('gulp-util');
const webpackStream = require('webpack-stream');

// Used to minify the CSS
const cssnano = require('gulp-cssnano');
const sassLint = require('gulp-sass-lint');
const sassLintConfig = require('./.sass-lint.json');

// Execute gulp commands in sequence, one after the the other.
const eslint = require( 'gulp-eslint');

const connect = require('gulp-connect-php');

// Linter tasks
gulp.task('lint', gulp.parallel(stylesLint, jsLint) );

// JS Tasks
gulp.task( 'js', js );

// Common Tasks
gulp.task('watch', gulp.parallel(gulp.series(gulp.parallel(stylesSourcemap, stylesMinify )), jsWatch, stylesWatch) );

// Server Tasks
gulp.task('server', startServer);
gulp.task( 'default', gulp.parallel('server', 'watch') );

// General Configurations
// Directories where JS and SCSS is placed.
const appDirectories = ['atoms', 'molecules', 'organisms', 'shared'];
// CSS configuration values.
const sassEntryFile = './style.scss';
const cssDestination = '../build/css';
const cssGeneratedFile = '../build/css/style.css';
// Patterns from where all the sass files are located.
const sassFiles = [
  sassEntryFile,
  './{' + appDirectories.join( ',' ) + '}/**/*.scss',
  './{' + appDirectories.join( ',' ) + '}/**/**/*.scss',
];
// Browser where prefixers required to be added.
const supportedBrowsers = ['Explorer >= 11', 'iOS >= 7', 'Safari >= 9'];
// Where the sass files are located, used to watch changes on these directories.
const sourceMapsDirectories = './../maps';
const rules = [{
  test: /\.js$/,
  exclude: /(node_modules)/,
  loader: 'babel-loader',
  options: {
    presets: ['@babel/preset-env']
  },
}];

/**
 * Starts dedicated web server (to prevent subdirectories)
 */
function startServer() {
  console.log(' ');
  console.log('----------------------------------');
  console.log('- Server: ', serverIP + ':' + serverPort);
  console.log('----------------------------------');
  console.log(' ');

  connect.server({ 
    hostname: serverIP,
    port: serverPort,
    base: '../../../../',
    keepalive: true,
    open: true,
    debug: false
  });  
}

/**
 * Adds the source maps of the
 * styles in order to locate easily where the styles where defined.
 */
function stylesSourcemap() {
  // Set sourceRoot option to the source maps to link to the original file.
  var sourceMapsOptions = {
    sourceRoot: './../../',
  };

  log.success( 'Style compilation of sass into css file started ');

  return gulp.src( sassEntryFile )
    .pipe( sourcemaps.init() )
    .pipe( sass() ).on( 'error', sass.logError )
    .pipe( sourcemaps.write( sourceMapsDirectories, sourceMapsOptions ) )
    .pipe( gulp.dest( cssDestination ));
}

/**
 * Function used to minify the cssGeneratedFile it also adds the prefixes
 * to the minified file based on the supportedBrowsers array.
 */
function stylesMinify() {
  const minifyOptions = {
    autoprefixer: {
      browsers: supportedBrowsers,
      add: true,
    }
  };

  log.success( 'CSS minification files started' );

  return gulp.src( cssGeneratedFile )
    .pipe( cssnano( minifyOptions ) )
    .pipe( gulp.dest( cssDestination ) );
}

/**
 * Watchs any change on sassDirectories path and on the sassEntryFile. If any
 * change is detected the `styles` task is triggered.
 */
function stylesWatch() {
  log.success( 'Start to watch for .scss changes' );
  gulp.watch(sassFiles, gulp.parallel(stylesSourcemap, stylesMinify ) );
}

/**
 * Function that is used to lint on all the sass files and follow all the rules
 * specified on .sass-lint.json
 */
function stylesLint() {
  return gulp.src( sassFiles )
    .pipe( sassLint(sassLintConfig) )
    .pipe( sassLint.format() )
    .pipe( sassLint.failOnError() );
}

/**
 * Function used to lint on the JS files, using the rules specified on
 * .eslintrc.json.
 */
function jsLint() {
  const jsFiles = [
    './main.js',
    './{' + appDirectories.join( ',' ) + '}/**/*.js',
    './{' + appDirectories.join( ',' ) + '}/**/**/*.js',
  ];

  return gulp.src( jsFiles )
    .pipe( eslint() )
    .pipe( eslint.format() )
    .pipe( eslint.failAfterError() );
}

const webpackConfig = require('./webpack.config.js');
const jsEntryFile = './main.js';

/**
 * Function used to create the JS to be used on specifc pages, by default
 * creates a source map associated with each JS file to make easier to debug.
 */
function js() {
  const options = Object.assign(webpackConfig, { devtool: 'source-map' });

  return jsTask( options );
}

/**
 * Watches the changes of the JS and creates a single file with source maps,
 * the genreated JS is on dev mode.
 */
function jsWatch() {
  const options = Object.assign( webpackConfig, {
    devtool: 'source-map',
    watch: true,
    module: {
      rules
    }
  });

  return jsTask( options );
}

/**
 * Function used to run webpack with a set of custom options based on the task
 * being executed.
 *
 * @param object options The options to be used to run webpack, by default uses webpack.config.js.
 * @return stream Returns a gulp task to be used.
 */
function jsTask( options ) {
  return gulp.src( jsEntryFile )
    .pipe( webpackStream( options ) )
    .pipe( gulp.dest( '../build/js' ) );
}

/*
 * Function used to log data to the console via gutil function
 */
const log = {
  success(msg) {
    gutil.log( gutil.colors.green( msg ) );
  }
};