module.exports = function(grunt) {

	require('time-grunt')(grunt);
	require('load-grunt-tasks')(grunt);

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		basePath: {
			bower: 'packages',
			fonts: 'fonts',
			scripts: 'scripts',
			styles: 'styles'
		},

		// https://github.com/gruntjs/grunt-contrib-less
		less: {
			options: {
				compress: true,
				cleancss: true,
				optimization: 1,
				strictImports: true
			},
			dist:{
				files: {
					'<%= basePath.styles %>/main.css': '<%= basePath.styles %>/source/main.less'
				}
			}
		},

		'copy': {
			fonts: {
				expand: true,
				src: '<%= basePath.bower %>/font-awesome/fonts/*',
				dest: '<%= basePath.fonts %>/font-awesome/',
				flatten: true
			}
		},

		//https://github.com/gruntjs/grunt-contrib-uglify
		uglify: {
			options: {
				banner: '/*! <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %> */\n'
			},
			dist:{
				files: {
					'<%= basePath.scripts %>/main.min.js': [
						'<%= basePath.scripts %>/source/500px.js',
						'<%= basePath.scripts %>/source/social.js',
						'<%= basePath.bower %>/jquery-ui/ui/minified/jquery.ui.core.min.js',
						'<%= basePath.bower %>/jquery-ui/ui/minified/jquery.ui.widget.min.js',
						'<%= basePath.bower %>/jquery-ui/ui/minified/jquery.ui.mouse.min.js',
						'<%= basePath.bower %>/jquery-ui/ui/minified/jquery.ui.progressbar.min.js',
						'<%= basePath.bower %>/jquery-ui/ui/minified/jquery.ui.slider.min.js',
						'<%= basePath.scripts %>/source/main.js'
					]
				}
			}
		},

		// https://github.com/gruntjs/grunt-contrib-jshint
		jshint: {
			files: ['<%= basePath.scripts %>/source/**/*.js', '!<%= basePath.scripts %>/source/500px.js'],
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
				files: ['<%= basePath.styles %>/source/**/*.less'],
				tasks: ['less']
			},
			js:{
				files: ['<%= basePath.scripts %>/source/**/*.js'],
				tasks: ['uglify']
			}
		}
	});


	grunt.registerTask('default', ['dist', 'watch']);
	grunt.registerTask('dist', ['copy:fonts', 'less:dist', 'uglify:dist']);

};
