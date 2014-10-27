module.exports = function(grunt) {

	// require('time-grunt')(grunt);
	require('load-grunt-tasks')(grunt);

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		basePath: {
			bower: './packages',
			dev: {
				scripts: './scripts',
				styles: './styles'
			},
			dist: {
				fonts: './../web/fonts',
				scripts: './../web/scripts',
				styles: './../web/styles'
			}
		},

		// https://github.com/gruntjs/grunt-contrib-less
		less: {
			options: {
				modifyVars: {
					"bower_url": '<%= basePath.bower %>/'
				},
				compress: true,
				cleancss: true,
				optimization: 1,
				strictImports: true
			},
			dist:{
				files: {
					'<%= basePath.dev.styles %>/main.concat.css': '<%= basePath.dev.styles %>/source/main.less'
				}
			}
		},

		concat: {
			scripts: {
				options: {
					separator: ';',
					stripBanners: true
				},
				src: [
					'<%= basePath.dev.scripts %>/source/500px.js',
					'<%= basePath.dev.scripts %>/source/social.js',
					'<%= basePath.bower %>/jquery-ui/ui/minified/jquery.ui.core.min.js',
					'<%= basePath.bower %>/jquery-ui/ui/minified/jquery.ui.widget.min.js',
					'<%= basePath.bower %>/jquery-ui/ui/minified/jquery.ui.mouse.min.js',
					'<%= basePath.bower %>/jquery-ui/ui/minified/jquery.ui.progressbar.min.js',
					'<%= basePath.bower %>/jquery-ui/ui/minified/jquery.ui.slider.min.js',
					'<%= basePath.dev.scripts %>/source/main.js'
				],
				dest: '<%= basePath.dev.scripts %>/main.concat.js'
			}
		},

		copy: {
			fonts: {
				expand: true,
				flatten: true,
				src: '<%= basePath.bower %>/font-awesome/fonts/*',
				dest: '<%= basePath.dist.fonts %>/font-awesome/'
			}
		},

		cssmin: {
			"jquery-ui": {
				files: {
					'<%= basePath.dev.styles %>/ui.concat.css': [
						'<%= basePath.bower %>/jquery-ui/themes/base/minified/jquery.ui.progressbar.min.css',
						'<%= basePath.bower %>/jquery-ui/themes/base/minified/jquery.ui.slider.min.css',
						'<%= basePath.bower %>/jquery-ui/themes/cupertino/jquery-ui.min.css'
					]
				}
			},
			dist: {
				files: {
					'<%= basePath.dist.styles %>/main.min.css': [
						'<%= basePath.dev.styles %>/ui.concat.css',
						'<%= basePath.dev.styles %>/main.concat.css'
					]

				}
			}
		},

		//https://github.com/gruntjs/grunt-contrib-uglify
		uglify: {
			options: {
				banner: '/*! <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %> */\n'
			},
			dist:{
				files: {
					'<%= basePath.dist.scripts %>/main.min.js': ['<%= basePath.dev.scripts %>/main.concat.js']
				}
			}
		},

		// https://github.com/gruntjs/grunt-contrib-jshint
		jshint: {
			files: ['<%= basePath.dev.scripts %>/source/**/*.js', '!<%= basePath.dev.scripts %>/source/500px.js'],
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
				files: ['<%= basePath.dev.styles %>/source/**/*.less'],
				tasks: ['less']
			},
			js:{
				files: ['<%= basePath.dev.scripts %>/source/**/*.js'],
				tasks: ['uglify']
			}
		}
	});


	grunt.registerTask('default', ['dist', 'watch']);
	grunt.registerTask('build-js', ['concat:scripts', 'uglify:dist']);
	grunt.registerTask('build-css', ['less:dist', 'cssmin:jquery-ui', 'cssmin:dist']);
	grunt.registerTask('dist', ['copy:fonts', 'build-js', 'build-css']);

};
