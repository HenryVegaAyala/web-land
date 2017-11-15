module.exports = function (grunt) {
  grunt.initConfig({
    less: {
      dev: {
        options: {
          compress: false,
          sourceMap: true,
          outputSourceFiles: true
        },
        files: {
          'web/css/all.css': 'assets/less/all.less'
        }
      },
      prod: {
        options: {
          compress: true
        },
        files: {
          'web/css/all.min.css': 'assets/less/all.less'
        }
      }
    },
    concat_sourcemap: {
      options: {
        sourcesContent: true
      },
      all: {
        files: {
          'web/js/all.js': grunt.file.readJSON('assets/js/all.json')
        }
      }
    },
    cssmin: {
      target: {
        files: [{
          expand: true,
          cwd: 'web/css/',
          src: ['style.css'],
          dest: 'web/css/',
          ext: '.min.css'
        }]
      }
    },
    minified: {
      files: {
        src: ['web/js/all.js'],
        dest: 'web/js/'
      },
      options: {
        sourcemap: true,
        allinone: false
      }
    },
    watch: {
      js: {
        files: ['assets/js/**/*.js', 'assets/js/all.json'],
        tasks: ['concat_sourcemap', 'uglify:lib'],
        options: {
          livereload: true
        }
      },
      less: {
        files: ['assets/less/**/*.less'],
        tasks: ['less'],
        options: {
          livereload: true
        }
      }
    },
    imagemin: {
      dynamic: {
        files: [{
          expand: true,
          cwd: 'web/img/',
          src: ['**/*.{png,jpg,gif}'],
          dest: 'web/img/'
        }]
      }
    }
  })

  grunt.loadNpmTasks('grunt-concat-sourcemap'),
  grunt.loadNpmTasks('grunt-contrib-watch'),
  grunt.loadNpmTasks('grunt-contrib-less'),
  grunt.loadNpmTasks('grunt-minified'),
  grunt.loadNpmTasks('grunt-contrib-cssmin'),
  grunt.loadNpmTasks('grunt-contrib-imagemin'),

  grunt.registerTask('build', ['less', 'concat_sourcemap', 'minified', 'cssmin', 'imagemin']),
  grunt.registerTask('default', ['watch'])
}
