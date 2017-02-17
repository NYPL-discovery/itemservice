'use strict';

module.exports = function(grunt) {
	require('load-grunt-tasks')(grunt);
	if(grunt.option('account-id') === undefined){
		return grunt.fail.fatal('--account-id is required', 1);
	}

	var path = require('path');
	grunt.initConfig({
		lambda_deploy: {
            service_general: {
				package: 'serviceGeneral',
				options: {
					file_name: 'index.js',
					handler: 'handler',
				},
				arn: 'arn:aws:lambda:us-east-1:' + grunt.option('account-id') + ':function:serviceGeneral',
			},
            service_auth: {
                package: 'serviceAuth',
                options: {
                    file_name: 'index.js',
                    handler: 'handler',
                },
                arn: 'arn:aws:lambda:us-east-1:' + grunt.option('account-id') + ':function:serviceAuth',
            },
            service_patron: {
                package: 'servicePatron',
                options: {
                    file_name: 'index.js',
                    handler: 'handler',
                },
                arn: 'arn:aws:lambda:us-east-1:' + grunt.option('account-id') + ':function:servicePatron',
            },
		},
		lambda_package: {
            service_general: {
				package: 'serviceGeneral',
			},
            service_auth: {
                package: 'serviceAuth',
            },
            service_patron: {
                package: 'servicePatron',
            }
		},
		env: {
			prod: {
				NODE_ENV: 'production',
			},
		},

	});


    grunt.registerTask('deploy_service_general', ['env:prod', 'lambda_package:service_general', 'lambda_deploy:service_general']);
    grunt.registerTask('deploy_service_auth', ['env:prod', 'lambda_package:service_auth', 'lambda_deploy:service_auth']);
    grunt.registerTask('deploy_service_patron', ['env:prod', 'lambda_package:service_patron', 'lambda_deploy:service_patron']);
};
