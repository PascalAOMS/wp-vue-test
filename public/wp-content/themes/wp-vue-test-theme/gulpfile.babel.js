// TODO
// delete unnessary JS files when using Webpack hashes

'use strict';

// NODE
import fs        from 'fs';                 import colors   from 'colors'
import path      from 'path';               import del      from 'del'
import exists    from 'fs-exists-sync';     import process  from 'process'
import Browser   from 'browser-sync';       import prompt   from 'prompt'
import webpack   from 'webpack';            import wpConfig from './webpack.config'
import wpDevMW   from 'webpack-dev-middleware'

// GULP
import gulp      from 'gulp';				import sass	    from 'gulp-sass'
import notify    from 'gulp-notify';        import maps     from 'gulp-sourcemaps'
import prefixer  from 'gulp-autoprefixer';  import cleanCSS from 'gulp-clean-css'
import svgstore  from 'gulp-svgstore';      import svgmin   from 'gulp-svgmin'
import hash      from 'gulp-hash';          import gulpif   from 'gulp-if'
import changed   from 'gulp-changed';       import gutil    from 'gulp-util'
import htmlmin   from 'gulp-htmlmin';

import { src, dest, serve, app, wp, theme, createReadme, SFTP } from './project.config'


const browser    = Browser.create()
const bundler    = webpack(wpConfig)
const production = process.env.npm_lifecycle_script.includes('production')
const miscGlob   = ['src/**', `!${src.js   }`, `!${src.js   }/**`,
                              `!${src.scss }`, `!${src.scss }/**`,
                              `!${src.icons}`, `!${src.icons}/**`]

let wpHotMW
if( app ) wpHotMW = require('webpack-hot-middleware')


export const DEL = path => del(path)
//////////////////////////////////
// SERVER
export function server() {

    let middleware = [
        wpDevMW(bundler, {
            publicPath: wpConfig.output.publicPath,
            stats: { colors: true, chunks: false }
        }),
        //wpHotMW(bundler)
    ]

    if( app ) middleware.push(wpHotMW(bundler))

    browser.init({
        ghostmode: serve.ghostmode,
        open: serve.open,
        injectChanges: true,
        proxy: {
            target: 'http://wp-vue-test.local',
            ws: true
        },
        server: false,
        middleware
        //files: [`${src.js}/**/*.js`]
    });


    // Watch JS
    gulp.watch(`${src.js}/**/*.js`).on('change', () => {
        DEL(dest.js)
        setTimeout(() => browser.reload(), 500);
    })


    // Watch Sass
    gulp.watch(`${src.scss}/**/*.scss`, styles)
        .on('change', () => DEL(dest.scss))


    // Watch Icons
    gulp.watch(src.icons, icons)
        .on('unlink', () => DEL(`${dest.assets}/icons.svg`))


    // Watch Misc
    gulp.watch(miscGlob, copy)
        .on('unlink', (path, stats) => DEL(path.replace('src', 'build')))

};


//////////////////////////////////
// SASS
export function styles() {
    return gulp.src(`${src.scss}/main.scss`)
        .pipe(maps.init())
        .pipe(sass().on('error', notify.onError({
            title: 'Sass Error',
            message: '<%= error.message %>',
            icon: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAMAAAC7IEhfAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2FpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTMyIDc5LjE1OTI4NCwgMjAxNi8wNC8xOS0xMzoxMzo0MCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0iNkFDODdBRTVCODI4QzVBNEQyREYwQjNFNjY4RTA3NUUiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6ODczODExQ0Y4QzhCMTFFNkIyRTA4MjlBNjEyOTBDREYiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6ODczODExQ0U4QzhCMTFFNkIyRTA4MjlBNjEyOTBDREYiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgSWxsdXN0cmF0b3IgQ0MgKE1hY2ludG9zaCkiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo3MTU1QjEzMjJCQUUxMUUzOEQyRUI1RDJFRDdBRTlBOCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo4NUZDNzBEQTJCQUUxMUUzOEQyRUI1RDJFRDdBRTlBOCIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Pg6bVCEAAAAYUExURcVNiei30PXf6t2Xu9N4pv///81mmv///+3Od60AAAAIdFJOU/////////8A3oO9WQAAAYRJREFUeNqclVmShEAIRJPV+994oKwFtHtiYvjR0CdrFuKqZkyiqq4qxNZeodwzqRdT4o+gib9M7A1SRxCWV3qC0qnMUvPq0kFpVFaSxuRYJB4coJO6TReJxiU2fUkYFRK1DvjAWBS3qRnhrihA25ze2Cw4n5Bx3tsAZYWliZXC5AYlQT5fRyBH6xOP0O4cIBWuuRsOs5jRd1znWXB9Om7TofuFGRkvDsnxSoVB2yFj+lnziUe6viXIyvqOAuEUhKtw8Rd1Qzc4I7Mxsz07pQukDYZPHkpvHdg5lMQDANAb5TuJHB8/XzZQS3N/IXWD8QmXdrzBolkfFeFDgtkeqrOI8CFXjnP7JGmNsCrS+Mx4GePS4nEocsxlDXRZqEequ4hgGGenSyRlZk18mAoENZd8jsLkYkJzpjVLqYdrFBBZLhHVhWXnuKbDkdrUvtQGUVkAWfCgCU0DM/BZKbODr/4t7iypdaq/cGXt5arDV64t0g+Y0v9X89+X/fl9RLLv38ePAAMALJofTrM3rn0AAAAASUVORK5CYII='
        })))
        .pipe(prefixer({ browsers: ['last 2 versions'] }))

        .pipe(gulpif(production && wp, hash({ hashLength: 3, template: '<%= name %>.<%= hash %><%= ext %>' })))
        .pipe(gulpif(production, cleanCSS()))

        .pipe(maps.write('./'))
        .pipe(gulp.dest(dest.scss))
        .pipe(browser.stream({ match: '**/*.css' }))
}


////////////////////////////////
// SVG ICONS
export function icons() {
    return gulp.src(`${src.icons}/**/*.svg`)
        .pipe(svgmin(file => {
            let prefix = path.basename(file.relative, path.extname(file.relative));
            return {
                plugins: [{
                    cleanupIDs: { prefix: prefix + '-', minify: false },
                    removeDoctype: true,
                    removeXMLProcInst: true,
                    removeMetadata: true
                }]
            };
        }))
        .pipe(svgstore({ inlineSvg: true }))
        .pipe(gulp.dest(dest.assets))
};


//////////////////////////////////
// README
export function readme() {

    return new Promise(resolve => {

        if( exists('README.md') ) { resolve() }
        else {
            prompt.message = ('');
            prompt.delimiter = colors.gray(' ==>');
            prompt.start();

            prompt.get([{ name: 'project', description: 'Name des Projekts'.green + '*'.red, required: true },
                        { name: 'author',  description: 'Ersteller des Projekts'.green + '*'.red, required: true },
                        { name: 'url',     description: 'URL (http://)'.green, pattern: /^https?:\/\// },
                        { name: 'server',  description: 'Server'.green },
                        { name: 'cms',     description: 'CMS'.green, default: 'Typo3' },
            ], (err, res) => {

                fs.writeFile('./README.md', createReadme(res), () => resolve());
                gutil.log('README.md created.'.green)
            })
        }
    });
}


////////////////////////////////
// THEME CONFIG
export function createTheme() {
    return new Promise(res => {
        fs.writeFile('build/style.css', theme, () => res());
    });
};


////////////////////////////////
// COPY
export function copy() {
    return gulp.src(miscGlob)
        .pipe(changed('build'))
        .pipe(gulp.dest('build'))
        .pipe(browser.reload({ stream: true }))
}


////////////////////////////////
// MIN HTML + INJECT
export function html() {

    return gulp.src('build/**/*.html')
        .pipe(gulpif(!wp, htmlmin({
            collapseWhitespace: true,
            removeAttributeQuotes: true,
            removeStyleLinkTypeAttributes: true,
            removeScriptTypeAttributes: true,
            removeComments: true
        })))
        .pipe(gulp.dest('build'))
};


////////////////////////////////////////////////////////
//// GULP TASKS
export const dev   = gulp.series( gulp.parallel(copy, styles, icons), server )

export const build = gulp.series( gulp.parallel(styles), html )

export default dev
