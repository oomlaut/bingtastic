module.exports = function(grunt) {

	require('time-grunt')(grunt);
	require('load-grunt-tasks')(grunt);

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		// https://github.com/gruntjs/grunt-contrib-less
		less: {
			options: {
				// compress: true,
				// cleancss: true,
				// optimization: 1,
				strictImports: true
			},
			dist:{
				files: {
					'php/styles/main.css': 'php/styles/source/main.less'
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
					'php/scripts/main.min.js': [
						'php/scripts/source/500px.js',
						'php/scripts/source/social.js',
						'php/packages/jquery-ui/ui/minified/jquery.ui.core.min.js',
						'php/packages/jquery-ui/ui/minified/jquery.ui.widget.min.js',
						'php/packages/jquery-ui/ui/minified/jquery.ui.mouse.min.js',
						'php/packages/jquery-ui/ui/minified/jquery.ui.progressbar.min.js',
						'php/packages/jquery-ui/ui/minified/jquery.ui.slider.min.js',
						'php/scripts/source/main.js'
					]
				}
			}
		},

		// https://github.com/gruntjs/grunt-contrib-jshint
		jshint: {
			files: ['php/scripts/source/**/*.js', '!php/scripts/source/500px.js'],
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

		//https://github.com/dylang/grunt-notify
		notify:{},

		//https://github.com/gruntjs/grunt-contrib-watch
		watch: {
			less:{
				files: ['php/styles/source/**/*.less'],
				tasks: ['less']
			},
			js:{
				files: ['php/scripts/source/**/*.js'],
				tasks: ['uglify']
			}
		}
	});


	grunt.registerTask('default', ['dist', 'watch']);
	grunt.registerTask('dist', ['less:dist', 'uglify:dist']);

};
