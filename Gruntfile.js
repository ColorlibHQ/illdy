'use strict';
module.exports = function(grunt){

    // load all tasks
    require('load-grunt-tasks')(grunt, {scope: 'devDependencies'});

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        makepot: {
            target: {
                options: {
                    domainPath: '/languages/',    // Where to save the POT file.
                    potFilename: '<%= pkg.name %>.pot',   // Name of the POT file.
                    potHeaders: {
                        poedit: true,                 // Includes common Poedit headers.
                        'x-poedit-keywordslist': true // Include a list of all possible gettext functions.
                    },                                // Headers to add to the generated POT file.
                    processPot: function( pot, options ) {
                        pot.headers[ 'report-msgid-bugs-to' ] = 'https://www.colorlib.com/';
                        pot.headers[ 'language-team' ] = 'Colorlib <office@colorlib.com>';
                        pot.headers[ 'last-translator' ] = 'Colorlib <office@colorlib.com>';
                        pot.headers[ 'language-team' ] = 'Colorlib <office@colorlib.com>';
                        return pot;
                    },
                    updateTimestamp: true,             // Whether the POT-Creation-Date should be updated without other changes.
                    type: 'wp-theme',  // Type of project (wp-plugin or wp-theme).

                }
            }
        },
        clean: {
            init: {
                src: ['build/']
            },
            build: {
                src: [
                    'build/*',
                    '!build/<%= pkg.name %>.zip'
                ]
            },
            cssmin: {
                src: ['layout/css/*.min.css']
            },
            jsmin: {
                src: [
                    'layout/js/*.min.js',
                    'layout/js/*.min.js.map',
                    'layout/js/**/*.min.js',
                    'layout/js/**/*.min.js.map'
                ]
            }
        },
        copy: {
            readme: {
                src: 'readme.md',
                dest: 'build/readme.txt'
            },
            build: {
                expand: true,
                src: [
                    '**',
                    '!node_modules/**',
                    '!vendor/**',
                    '!build/**',
                    '!readme.md',
                    '!README.md',
                    '!phpcs.ruleset.xml',
                    '!Gruntfile.js',
                    '!package.json',
                    '!composer.json',
                    '!composer.lock',
                    '!set_tags.sh',
                    '!illdy.zip',
                    '!nbproject/**' ],
                dest: 'build/'
            }
        },

        compress: {
            build: {
                options: {
                    pretty: true,                           // Pretty print file sizes when logging.
                    archive: '<%= pkg.name %>.zip'
                },
                expand: true,
                cwd: 'build/',
                src: ['**/*'],
                dest: '<%= pkg.name %>/'
            }
        },

        uglify: {
            options: {
                sourceMap: true,
                compress: true,
            },
            dynamic_mappings: {
                files: [
                    {
                        expand: true,     // Enable dynamic expansion.
                        cwd: 'layout/js/',      // Src matches are relative to this path.
                        src: ['**/*.js', '!jquery.fancybox.js'], // Actual pattern(s) to match.
                        dest: 'layout/js/',   // Destination path prefix.
                        ext: '.min.js',   // Dest filepaths will have this extension.
                        extDot: 'first'   // Extensions in filenames begin after the first dot
                    },
                ],
            },
        },

        checktextdomain: {
            standard: {
                options:{
                    text_domain: [ 'illdy', 'epsilon-framework' ], //Specify allowed domain(s)
                    create_report_file: "true",
                    keywords: [ //List keyword specifications
                        '__:1,2d',
                        '_e:1,2d',
                        '_x:1,2c,3d',
                        'esc_html__:1,2d',
                        'esc_html_e:1,2d',
                        'esc_html_x:1,2c,3d',
                        'esc_attr__:1,2d',
                        'esc_attr_e:1,2d',
                        'esc_attr_x:1,2c,3d',
                        '_ex:1,2c,3d',
                        '_n:1,2,4d',
                        '_nx:1,2,4c,5d',
                        '_n_noop:1,2,3d',
                        '_nx_noop:1,2,3c,4d'
                    ]
                },
                files: [{
                    src: [
                        '**/*.php',
                        '!**/node_modules/**',
                    ], //all php
                    expand: true,
                }],
            }
        },

        imagemin: {
            jpg: {
                options: {
                    progressive: true
                },
            },
            png: {
                options: {
                    optimizationLevel: 7
                },
            },
            dynamic: {
                files: [{
                    expand: true,
                    cwd: 'layout/images/',
                    src: ['**/*.{png,jpg,gif}'],
                    dest: 'layout/images/'
                }]
            }
        },

        cssmin: {
            target: {
                files: [{
                    expand: true,
                    cwd: 'layout/css',
                    src: ['*.css', '!*.min.css', '!style-overrides.css'],
                    dest: 'layout/css',
                    ext: '.min.css'
                }]
            }
        }


    });

    grunt.registerTask('default', []);

    // Build .pot file
    grunt.registerTask( 'buildpot', [
        'makepot'
    ]);

    // Check Missing Text Domain Strings
    grunt.registerTask( 'textdomain', [
        'checktextdomain'
    ]);

    // Minify Images
    grunt.registerTask( 'minimg', [
        'imagemin:dynamic'
    ]);

    // Minify CSS
    grunt.registerTask( 'mincss', [
        'clean:cssmin',
        'cssmin'
    ]);

    // Minify JS
    grunt.registerTask( 'minjs', [
        'clean:jsmin',
        'uglify'
    ]);

    // Task to minify all static resources
    grunt.registerTask( 'allmin', [
        'minimg',
        'mincss',
        'minjs'
    ]);

    // Build task
    grunt.registerTask( 'build-archive', [
        // 'makepot',
        // 'allmin',
        'clean:init',
        'copy',
        'compress:build',
        'clean:init'
    ]);
};