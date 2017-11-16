/* eslint-disable quotes */
module.exports = function (grunt) {
  grunt.initConfig({
    concat_css: {
      all: {
        src: [
          'https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700',
          'web/lib/bootstrap/css/bootstrap.min.css',
          'web/lib/font-awesome/css/font-awesome.min.css',
          'web/lib/animate/animate.min.css',
          'web/css/style.min.css'
        ],
        dest: "web/css/eqatu.css"
      }
    },
    cssmin: {
      target: {
        files: [{
          expand: true,
          cwd: 'web/css/',
          src: ['eqatu.css'],
          dest: 'web/css/',
          ext: '.min.css'
        }]
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
    imagemin: {
      dynamic: {
        files: [{
          expand: true,
          cwd: 'web/img/',
          src: ['**/*.{png,jpg,gif}'],
          dest: 'web/img/'
        }]
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
    }
  }),

  grunt.loadNpmTasks('grunt-concat-css'),
  grunt.loadNpmTasks('grunt-contrib-cssmin'),
  grunt.loadNpmTasks('grunt-concat-sourcemap'),
  grunt.loadNpmTasks('grunt-minified'),
  grunt.loadNpmTasks('grunt-contrib-imagemin'),
  grunt.loadNpmTasks('grunt-contrib-watch'),

  grunt.registerTask('build', ['concat_css', 'cssmin', 'concat_sourcemap', 'minified', 'imagemin']),
  grunt.registerTask('default', ['watch'])
}
