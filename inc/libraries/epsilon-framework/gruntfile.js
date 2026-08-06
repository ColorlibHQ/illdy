'use strict';
module.exports = function( grunt ) {
  // load all tasks
  require( 'load-grunt-tasks' )( grunt, { scope: 'devDependencies' } );

  grunt.util.linefeed = '\n';

  grunt.initConfig( {
    pkg: grunt.file.readJSON( 'package.json' ),
    dirs: {
      css: 'assets/css',
      js: 'assets/js'
    },
    concat: {
      epsilonFramework: {
        src: [
          'assets/vendors/epsilon-framework/customizer/components/epsilon-object.js',
          'assets/vendors/epsilon-framework/customizer/components/controls/repeater/repeater-object.js',
          'assets/vendors/epsilon-framework/customizer/components/controls/section-repeater/section-repeater-object.js',
          'assets/vendors/epsilon-framework/customizer/components/controls/**/*.js',
          'assets/vendors/epsilon-framework/customizer/components/sections/**/*.js',
          'assets/vendors/epsilon-framework/customizer/components/panels/**/*.js',
          'assets/vendors/epsilon-framework/customizer/components/wp-customize-extenders/**/*.js',
          'assets/vendors/epsilon-framework/customizer/epsilon.js',
          '!assets/vendors/epsilon-framework/customizer/epsilon.min.js',
          '!assets/vendors/epsilon-framework/customizer/epsilon-concat.js'
        ],
        dest: 'assets/js/epsilon.js'
      },
      epsilonAdmin: {
        src: [
          'assets/vendors/epsilon-framework/admin/components/epsilon-admin-object.js',
          'assets/vendors/epsilon-framework/admin/**/*.js',
          'assets/vendors/epsilon-framework/admin/epsilon-admin.js',
          '!assets/vendors/epsilon-framework/admin/epsilon-admin.min.js',
          '!assets/vendors/epsilon-framework/admin/epsilon-admin-concat.js'
        ],
        dest: 'assets/js/epsilon-admin.js'
      },
      epsilonPreviewer: {
        src: [
          'assets/vendors/epsilon-framework/previewer/components/epsilon-previewer-object.js',
          'assets/vendors/epsilon-framework/previewer/**/*.js',
          'assets/vendors/epsilon-framework/previewer/epsilon-previewer.js',
          '!assets/vendors/epsilon-framework/previewer/epsilon-previewer.min.js',
          '!assets/vendors/epsilon-framework/previewer/epsilon-previewer-concat.js'
        ],
        dest: 'assets/js/epsilon-previewer.js'
      },
    },
    uglify: {
      epsilon: {
        options: {
          sourceMap: false,
          sourceMapName: 'sourceMap.map'
        },
        src: [ 'assets/js/epsilon.js', '!assets/js/epsilon.min.js' ],
        dest: 'assets/js/epsilon.min.js'
      },
      epsilonAdmin: {
        options: {
          sourceMap: false,
          sourceMapName: 'sourceMap.map'
        },
        src: [ 'assets/js/epsilon-admin.js', '!assets/js/epsilon-admin.min.js' ],
        dest: 'assets/js/epsilon-admin.min.js'
      },
      epsilonPreviewer: {
        options: {
          sourceMap: false,
          sourceMapName: 'sourceMap.map'
        },
        src: [ 'assets/js/epsilon-previewer.js', '!assets/js/epsilon-previewer.min.js' ],
        dest: 'assets/js/epsilon-previewer.min.js'
      }
    },

    sass: {
      dist: {
        options: {
          style: 'expanded',
          sourcemap: 'none',
        },
        files: [
          {
            expand: true,
            cwd: 'assets/css/',
            src: [ '*.scss' ],
            dest: 'assets/css/',
            ext: '.css'
          } ]
      }
    }
  } );

  grunt.config( 'watch', {
    scss: {
      tasks: [ 'sass:dist' ],
      files: [
        'assets/css/*.scss',
        'assets/css/**/*.scss',
        'assets/css/**/**/*.scss',
      ]
    }
  } );

  grunt.event.on( 'watch', function( action, filepath ) {
    // Determine task based on filepath
    var get_ext = function( path ) {
      var ret = '';
      var i = path.lastIndexOf( '.' );
      if ( - 1 !== i && i <= path.length ) {
        ret = path.substr( i + 1 );
      }
      return ret;
    };
    switch ( get_ext( filepath ) ) {
        // PHP
      case 'php' :
        //grunt.config('paths.php.files', [ filepath ]);
        break;
        // JavaScript
      case 'js' :
        grunt.config( 'paths.js.files', [ filepath ] );
        break;
    }
  } );

  grunt.registerTask( 'startSass', [
    'sass'
  ] );

  // Concatenate Epsilon
  grunt.registerTask( 'concat-epsilon', [
    'concat:epsilonFramework',
    'concat:epsilonAdmin',
    'concat:epsilonPreviewer',
    'uglify:epsilon',
    'uglify:epsilonAdmin',
    'uglify:epsilonPreviewer'
  ] );
};