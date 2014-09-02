'use strict';
module.exports = function(grunt) {

  // load all grunt tasks matching the `grunt-*` pattern
  require('load-grunt-tasks')(grunt);

  grunt.initConfig({

    release: {
      options: {
          bump: false, // Using Grunt Bump
          npm: false, //default: true
          commitMessage: 'Release <%= version %>'
      }
    },

    bump: {
      options: {
            files: ['package.json', 'bower.json'],
            updateConfigs: [],
            commit: false,
            createTag: false,
            push: false
      }
    }

  });

  grunt.registerTask('publish', ['publish:patch']);
  grunt.registerTask('publish:patch', ['bump:patch', 'release']);
  grunt.registerTask('publish:minor', ['bump:minor', 'release']);
  grunt.registerTask('publish:major', ['bump:major', 'release']);

};
