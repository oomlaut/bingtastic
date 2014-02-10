module.exports = function(grunt) {

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		// https://github.com/gruntjs/grunt-contrib-less
		less: {
			options: {
				compress: true,
				cleancss: true,
				optimization: 1,
				strictImports: true
			},
			files: {
				'styles/main.css': 'styles/source/main.less'
			}
		},

		//https://github.com/gruntjs/grunt-contrib-uglify
		uglify: {
			options: {
				banner: '/*! <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %> */\n'
			},
			files: {
				'scripts/main.min.js': ['scripts/source/social.js', 'scripts/source/main.js']
			}
		},

		// https://github.com/gruntjs/grunt-contrib-jshint
		jshint: {
			files: ['scripts/source/**/*.js'],
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
				files: ['styles/source/**/*.less'],
				tasks: ['less']
			},
			js:{
				files: ['scripts/source/**/*/js'],
				tasks: ['uglify']
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-notify');

	grunt.file.setBase('php/');

	grunt.registerTask('default', ['less', 'uglify', 'watch']);

};
