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
    copy: {
      main: {
        files: [
          {
            expand: true,
            flatten: true,
            src: ['vendor/bower-asset/bootstrap/fonts/*'],
            dest: 'web/fonts/',
            filter: 'isFile'
          }
        ]
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
      },
      fonts: {
        files: [
          'vendor/bower/bootstrap/fonts/*'
        ],
        tasks: ['copy'],
        options: {
          livereload: true
        }
      }
    }
  }),

  grunt.loadNpmTasks('grunt-concat-sourcemap'),
  grunt.loadNpmTasks('grunt-contrib-watch'),
  grunt.loadNpmTasks('grunt-contrib-less'),
  grunt.loadNpmTasks('grunt-contrib-copy'),
  grunt.loadNpmTasks('grunt-minified')

  grunt.registerTask('build', ['less', 'concat_sourcemap', 'copy', 'minified']),
  grunt.registerTask('default', ['watch'])
}
