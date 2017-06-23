module.exports = function( grunt ) {

    'use strict';
    var banner = '/**\n * <%= pkg.homepage %>\n * Copyright (c) <%= grunt.template.today("yyyy") %>\n * This file is generated automatically. Do not edit.\n */\n';
    // Project configuration
    grunt.initConfig( {

        pkg:    grunt.file.readJSON( 'package.json' ),

        addtextdomain: {
            options: {
                textdomain: 'wlm-zapier-proxy',
            },
            target: {
                files: {
                    src: [ '*.php', '**/*.php', '!node_modules/**', '!php-tests/**', '!bin/**' ]
                }
            }
        },

        wp_readme_to_markdown: {
            your_target: {
                files: {
                    'README.md': 'readme.txt'
                }
            },
            options: {
                screenshot_url: 'https://github.com/macbookandrew/wlm-zapier-proxy/blob/master/assets/{screenshot}.png',
            }
        },

        makepot: {
            target: {
                options: {
                    domainPath: '/languages',
                    mainFile: 'wlm-zapier-proxy.php',
                    potFilename: 'wlm-zapier-proxy.pot',
                    potHeaders: {
                        poedit: true,
                        'x-poedit-keywordslist': true
                    },
                    type: 'wp-plugin',
                    updateTimestamp: true
                }
            }
        },
    } );

    grunt.loadNpmTasks( 'grunt-wp-i18n' );
    grunt.loadNpmTasks( 'grunt-wp-readme-to-markdown' );
    grunt.registerTask( 'i18n', ['addtextdomain', 'makepot'] );
    grunt.registerTask( 'readme', ['wp_readme_to_markdown']);

    grunt.util.linefeed = '\n';

};
