module.exports = function(grunt) {
	'use strict';

	// require('time-grunt')(grunt);
	require('load-grunt-tasks')(grunt);

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		bower: grunt.file.readJSON('bower.json'),
		bowerprefs: grunt.file.readJSON('.bowerrc'),

		basePath: {
			bower: '<%= bowerprefs.directory %>',
			dev: {
				scripts: 'scripts',
				styles: 'styles'
			},
			dist: {
				fonts: '../web/fonts',
				scripts: '../web/scripts',
				styles: '../web/styles'
			},
			tmp: {
				scripts: 'tmp/scripts',
				styles: 'tmp/styles'
			}
		},

		copy: {
			fonts: {
				expand: true,
				flatten: true,
				src: '<%= basePath.bower %>/font-awesome/fonts/*',
				dest: '<%= basePath.dist.fonts %>/font-awesome/'
			},
			ui_images: {
				expand: true,
				flatten: true,
				src: [
					'<%= basePath.bower %>/jquery-ui/themes/base/images/*',
					'<%= basePath.bower %>/jquery-ui/themes/<%= pkg.ui_theme %>/images/*'
				],
				dest: '<%= basePath.dist.styles %>/images/'
			}
		},

		concat: {
			scripts: {
				options: {
					separator: ';\n',
					stripBanners: {
						block: true,
						line: true
					},
					sourcemap: false
				},
				src: [
					'<%= basePath.bower %>/jquery/dist/jquery.min.js',
					'<%= basePath.bower %>/jquery-ui/ui/minified/core.min.js',
					'<%= basePath.bower %>/jquery-ui/ui/minified/widget.min.js',
					'<%= basePath.bower %>/jquery-ui/ui/minified/mouse.min.js',
					'<%= basePath.bower %>/jquery-ui/ui/minified/progressbar.min.js',
					'<%= basePath.bower %>/jquery-ui/ui/minified/slider.min.js',
					'<%= basePath.bower %>/500px/500px.js',
					'<%= basePath.dev.scripts %>/social.js',
					'<%= basePath.dev.scripts %>/main.js'
				],
				dest: '<%= basePath.tmp.scripts %>/main.js'
			}
		},

		//https://github.com/gruntjs/grunt-contrib-uglify
		uglify: {
			options: {
				banner: '/*! <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %> */\n',
				preserveComments: false
				//, beautify: true
			},
			dist:{
				files: {
					'<%= basePath.dist.scripts %>/main.min.js': ['<%= basePath.tmp.scripts %>/main.js']
				}
			}
		},

		// https://github.com/gruntjs/grunt-contrib-less
		less: {
			options: {
				modifyVars: {
					"bower_url": '<%= basePath.bower %>/',
					"bower_path": '../<%= basePath.bower %>'
				},
				compress: true,
				cleancss: true,
				optimization: 1,
				strictImports: true
			},
			dist:{
				files: {
					'<%= basePath.tmp.styles %>/main.css': '<%= basePath.dev.styles %>/main.less'
				}
			}
		},

		cssmin: {
			"jquery-ui": {
				files: {
					'<%= basePath.tmp.styles %>/ui.css': [
						'<%= basePath.bower %>/jquery-ui/themes/base/theme.css',
						'<%= basePath.bower %>/jquery-ui/themes/base/progressbar.css',
						'<%= basePath.bower %>/jquery-ui/themes/base/slider.css',
						'<%= basePath.bower %>/jquery-ui/themes/<%= pkg.ui_theme %>/theme.css'
					]
				}
			},
			dist: {
				files: {
					'<%= basePath.dist.styles %>/main.min.css': [
						'<%= basePath.tmp.styles %>/*.css'
					]

				}
			}
		},

		//https://github.com/gruntjs/grunt-contrib-clean
		clean: {
			options: {
				force: true
			},
			ui_images: ['<%= basePath.dist.styles %>/images'],
			scripts: ['<%= basePath.tmp.scripts %>'],
			styles: ['<%= basePath.tmp.styles %>']
		},

		// https://github.com/gruntjs/grunt-contrib-jshint
		jshint: {
			files: ['<%= basePath.dev.scripts %>/**/*.js'],
			options: {
				// options here to override JSHint defaults
				globals: {
					jQuery: true,
					console: true,
					module: true,
					document: true
				}
			}
		},

		//https://github.com/gruntjs/grunt-contrib-watch
		watch: {
			less:{
				files: ['<%= basePath.dev.styles %>/**/*.less'],
				tasks: ['build-css']
			},
			js:{
				files: ['<%= basePath.dev.scripts %>/**/*.js'],
				tasks: ['build-js']
			}
		}
	});

	grunt.registerTask('build-js', ['concat:scripts', 'uglify:dist', 'clean:scripts']);
	grunt.registerTask('build-css', ['less:dist', 'cssmin:jquery-ui', 'cssmin:dist', 'clean:styles']);
	grunt.registerTask('dist', ['copy:fonts', 'clean:ui_images', 'copy:ui_images', 'build-js', 'build-css']);

	grunt.registerTask('default', ['dist', 'watch']);

};
