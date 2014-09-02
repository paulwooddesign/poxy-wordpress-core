'use strict';
module.exports = function(grunt) {

  // load all grunt tasks matching the `grunt-*` pattern
  require('load-grunt-tasks')(grunt);

  grunt.initConfig({

    release: {
      options: {
          bump: false,
          commitMessage: 'Release <%= version %>'
      }
    },

    bump: {
      options: {
            updateConfigs: ['pkg'],
            commit: false,
            createTag: false,
            push: false
      }
    }

  });

  grunt.registerTask('publish', ['publish:patch']);
  grunt.registerTask('publish:patch', ['clean', 'bump:patch', 'release']);
  grunt.registerTask('publish:minor', ['clean', 'bump:minor', 'release']);
  grunt.registerTask('publish:major', ['clean', 'bump:major', 'release']);

};
