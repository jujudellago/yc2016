/**
 * Oxygenna.com
 *
 * $Template:: *(TEMPLATE_NAME)*
 * $Copyright:: *(COPYRIGHT)*
 * $Licence:: *(LICENCE)*
 */

 /*global jQuery: false, importInfo: false */

'use strict';

(function( $ ){
    $(document).ready(function($){
        var json = null;
        var importPostsData = [];
        var dataLength = 0;
        var importJob = null;
        var $currentPackageRow = null;
        var $progress = null;
        var installPackages = [];
        var slowInstall = $('#slowinstalloption').length > 0;
        var restTime = slowInstall ? 3000 : 0;

        // create array of packages to install from table list
        var packageRows = $( '#package-table tbody tr.package-row' );
        if( packageRows.length > 0 ) {
            packageRows = $.makeArray( packageRows );
            packageRows.reverse();
            for (var row = 0; row < packageRows.length; row++) {

                var filename = $(packageRows[row]).attr('data-file');
                $( importInfo.themePackages ).each( function( index, themePackage ) {
                    if( themePackage.filename === filename ) {
                        installPackages.push( themePackage );
                    }
                });

            }
        }

        // start the install
        installPackage();

        // handle modal popup on start page
        $('.one-click').click( function( e ) {
            // have they selected a package?
            if( $('input[name="installpackages[]"]:checked').length > 0 ) {
                $( '#dialog-confirm' ).dialog({
                    resizable: false,
                    modal: true,
                    buttons: {
                        'Make my site beautiful': function() {
                            $( '#install-form' ).submit();
                        },
                        Cancel: function() {
                            $( this ).dialog( 'close' );
                        }
                    }
                });
            }
            else {
                $( '#dialog-message' ).dialog({
                    modal: true,
                    buttons: {
                        Ok: function() {
                            $( this ).dialog( 'close' );
                        }
                    }
                });
            }
            e.preventDefault();
        });

        // handle toggle on package list
        $( '.toggle-details' ).click( function() {
            $(this).parents('tr').next().toggle();
        });

        // if we are on the installer page start the install
        function installPackage() {
            if( installPackages.length > 0 ) {
                var currentPackage = installPackages.pop();
                switch( currentPackage.type ) {
                    case 'oxygenna':
                        startOxygennaPackage( currentPackage );
                        break;
                }
            }
            else {
                // no more packages to install so move to the finished page
                // $( '#import-finished-form' ).submit();
            }
        }

        function startOxygennaPackage( oxygennaPackage ) {
            $.getJSON( importInfo.themeURL + 'import/' + oxygennaPackage.filename, function( importJSONData ) {
                json = importJSONData;
                // tell wp we are starting an import
                $.post( importInfo.ajaxURL, {
                    action: 'oxy_import_start',
                    nonce: importInfo.importNonce,
                    installPackage: oxygennaPackage
                }).
                done( function( response ) {
                    if( response.status ) {
                        // got the new job
                        importJob = response.data.id;
                        // create the new import data
                        importPostsData = [].concat( json.attachments, json.posts );
                        dataLength = importPostsData.length;
                        // count the slideshows as well
                        if ( json.slideshows ) {
                            dataLength += json.slideshows.length;
                        }
                        initProgressBar( oxygennaPackage.filename, dataLength );

                        oxyImport();
                    }
                    else {
                        displayError( 'No Import Job.', 'Could not create new import job.');
                    }
                }).
                fail( function() {
                    displayError( 'No Import Job.', 'Could not create new import job.');
                });
            }).
            done(function() {
                // do nothing
            })
            .fail(function() {
                displayError( 'No Import Data.', 'Could not load import.json from the theme.');
            });
        }

        function oxyImport() {
            // start the import
            if( importPostsData.length > 0 ) {
                importPost( importPostsData.shift() );
            }
            else if( json.menus && json.menus.length > 0 ) {
                importMenu( json.menus.shift() );
            }
            else if( json.slideshows && json.slideshows.length > 0 ) {
                importSlideshow( json.slideshows.shift() );
            }
            else {
                finalSetup();
            }
        }

        function importPost( post ) {
            setTimeout(function() {
                $.post( importInfo.ajaxURL, {
                    action: 'oxy_import_post',
                    jobID: importJob,
                    nonce: importInfo.importNonce,
                    data: JSON.stringify( post )
                }).
                done( function( response ) {
                    updateList( 'post', response, post );
                    itemComplete();
                    oxyImport();
                }).
                fail( function() {
                    displayError( 'Import Post Failed.', 'Could not get response' );
                    oxyImport();
                });
            }, restTime);
        }

        function updateList( type, response, item ) {
            if( response !== null && response !== undefined && response.status !== null && response.status !== undefined ) {
                var row = {
                    status: response.status ? 'Created' : 'Failed',
                    class: response.status ? 'row-ok' : 'row-error',
                    ID: '',
                    title: '',
                    type: ''
                };

                switch( type ) {
                    case 'post':
                        row.ID = response.status ? response.data.ID : item.ID;
                        row.title = item.post_title;
                        row.type = item.post_type;
                    break;
                    case 'menu':
                        row.ID = response.status ? response.data : item.term_id;
                        row.title = item.name;
                        row.type = 'Menu';
                    break;
                    case 'menu_item':
                        row.ID = response.status ? response.data : item.ID;
                        row.title = item.title;
                        row.type = 'Menu Item';
                    break;
                    case 'layerslider':
                        row.ID = '-';
                        row.title = item;
                        row.type = 'Layer Slider';
                    break;
                    case 'revslider':
                        row.ID = '-';
                        row.title = item;
                        row.type = 'Revolution Slider';
                    break;
                }

                $currentPackageRow.next().find( 'tbody' ).prepend( $('<tr class="' + row.class + '"><td>' + row.status + '</td><td>' + row.ID + '</td><td>' + row.title + '</td><td>' + row.type + '</td></tr>' ) ).slideDown();
            }
        }

        function initProgressBar( filename, max ) {
            $currentPackageRow = $('#package-table tr[data-file="' + filename + '"]');
            // set the number in the title
            $currentPackageRow.find( '.job' ).html( importJob );
            // setup progress bar

            $progress = $currentPackageRow.find( '.progress' );
            $progress.progressbar( {
                max: max,
                value: 0,
                change: function() {
                    var value = $progress.progressbar( 'option', 'value' );
                    $currentPackageRow.find('.count').html( value );
                    $currentPackageRow.find('.total').html( max );
                }
            });
        }

        function itemComplete() {
            var value = $progress.progressbar( 'option', 'value' );
            $progress.progressbar( 'option', 'value', value + 1 );
        }

        function importMenu( menu ) {
            setTimeout(function() {
                $.post( importInfo.ajaxURL, {
                    action: 'oxy_import_menu',
                    jobID: importJob,
                    nonce: importInfo.importNonce,
                    data: JSON.stringify( menu )
                }).
                done( function( response ) {
                    itemComplete();
                    updateList( 'menu', response, menu );

                    if( !response.status ) {
                        // show error and move onto next menu
                        for( var i in response.data.errors ) {
                           displayError( 'Import Menu Error', response.data.errors[i][0] );
                        }
                    }

                    oxyImport();
                }).
                fail( function() {
                    displayError( 'Import Menu Error', 'Failed to send menu data' );
                    oxyImport();
                });
            }, restTime);
        }

        function importSlideshow( slideshow ) {
            setTimeout(function() {
                $.post( importInfo.ajaxURL, {
                    action: 'oxy_import_slideshow',
                    nonce: importInfo.importNonce,
                    slideshow: slideshow,
                }).
                done( function( response ) {
                    itemComplete();
                    updateList( slideshow.type, response, slideshow.filename );
                    oxyImport();

                    if( !response.status ) {
                        for( var i in response.data.errors ) {
                           displayError( 'Import Slideshow', response.data.errors[i][0] );
                        }
                    }
                }).
                fail( function() {
                    displayError( 'Slideshow Import Failed.', 'Could not import ' + slideshow.filename + ' package.');
                    oxyImport();
                });
            }, restTime);
        }


        function finalSetup() {
            $.post( importInfo.ajaxURL, {
                action: 'oxy_import_final_setup',
                jobID: importJob,
                nonce: importInfo.importNonce,
                data: JSON.stringify( json.final_setup )
            }).
            done( function( response ) {
                if( response.status === false ) {
                    displayError( 'Final Setup Error', 'Something didnt finish correctly' );
                }
                finishImport();
            }).
            fail( function() {
                displayError( 'Final Setup Error', 'Failed to send final data' );
                finishImport();
            });
        }

        function finishImport() {
            $.post( importInfo.ajaxURL, {
                action: 'oxy_import_end',
                jobID: importJob,
                nonce: importInfo.importNonce,
                data: importJob
            }).
            done( function( response ) {
                if( response.status === false ) {
                    displayError( 'Finish Import', 'Failed to remove import job' );
                }
                installPackage();
            }).
            fail( function() {
                displayError( 'Finish Import', 'Failed to send import job' );
                installPackage();
            });
        }

        function displayError( title, message ) {
            var error = $('<div id="setting-error-settings_updated" class="error settings-error below-h2"><p><strong>' + title + '</strong> ' + message + '</p></div>' );
            $( '#ajax-errors-here' ).append( error );
        }
    });
})( jQuery );