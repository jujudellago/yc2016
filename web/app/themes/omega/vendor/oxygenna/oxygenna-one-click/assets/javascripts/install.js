/**
 * Oxygenna.com
 *
 * $Template:: *(TEMPLATE_NAME)*
 * $Copyright:: *(COPYRIGHT)*
 * $Licence:: *(LICENCE)*
 */

 /*global jQuery: false, importInfo: false */

'use strict';

(function($){
    $(document).ready(function($) {
        // current task label
        function currentTask(task) {
            $('#current-task-label').text(task);
        }
        // initialise progress bars
        var $currentProgress = $('#current-progress').progressbar({
            value: false,
            change: function() {
                var value = $currentProgress.progressbar('option', 'value');
                value = value === false ? '' : value + '%';
                $('#current-progress-label').text(value);
            }
        });
        var $totalProgress = $('#total-progress').progressbar({
            value: false,
            change: function() {
                var value = Math.round($totalProgress.progressbar('option', 'value') / $totalProgress.progressbar('option', 'max') * 100);
                value = value === false ? '' : value + '%';
                $('#total-progress-label').text(value);
            }
        });

        function incrementTotal(number) {
            if(undefined === number) {
                number = 1;
            }
            var value = $totalProgress.progressbar('option', 'value');
            value += number;
            $totalProgress.progressbar('option', 'value', value);
        }

        // create an error popup
        function popError(errorTitle, errorText) {
            $('#messages').append('<div class="error"><p><strong>' + errorTitle + '</strong> ' + errorText + '</p></div>');
        }

        function xhrProgress() {
            var jqXHR = null;
            if (window.ActiveXObject) {
                jqXHR = new window.ActiveXObject('Microsoft.XMLHTTP');
            }
            else {
                jqXHR = new window.XMLHttpRequest();
            }

            //Download progress
            jqXHR.upload.addEventListener('progress', function (evt) {
                if (evt.lengthComputable) {
                    var percentComplete = Math.round((evt.loaded * 100) / evt.total);
                    $currentProgress.progressbar('option', 'value', percentComplete);
                }
            }, false);

            //Download progress
            jqXHR.addEventListener('progress', function (evt) {
                if (evt.lengthComputable) {
                    var percentComplete = Math.round((evt.loaded * 99) / evt.total);
                    $currentProgress.progressbar('option', 'value', percentComplete);
                }
            }, false);

            return jqXHR;
        }

        function downloadInstallPackage(installPackage) {
            currentTask('Downloading Install Package');
            $.ajax({
                type: 'GET',
                url: installPackage.importUrl + installPackage.importFile,
                dataType: 'json',
                xhr: xhrProgress,
                success: function(data) {
                    $currentProgress.progressbar('option', 'value', false);
                    prepareToInstall(data, installPackage);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    popError('Error downloading package', errorThrown);
                }
            });
        }

        function prepareToInstall(data, installPackage) {
            currentTask('Reading Install Package');
            // create import job object
            var importJob = {
                id: '',
                data: data,
                installPackage: installPackage
            };

            // tot up all the items we have to install
            var totalItems = 0;
            totalItems += data.posts.length;
            if(undefined !== data.menus) {
                totalItems += data.menus.length;
            }

            if(undefined !== data.slideshows) {
                totalItems += data.slideshows.length;
            }

            if(undefined !== data.final_setup) {
                totalItems += 1;
            }

            // set up the max value for the total progress
            $totalProgress.progressbar('option', 'max', totalItems);
            $totalProgress.progressbar('option', 'value', 0);

            // tell wp we are starting an import
            currentTask('Starting Import');
            $currentProgress.progressbar('option', 'value', 0);
            $.ajax({
                type: 'POST',
                url: importInfo.ajaxURL,
                data: {
                    action: 'oxy_import_start',
                    nonce: importInfo.importNonce,
                    installPackageId: installPackage.id
                },
                xhr: xhrProgress,
                dataType: 'json'
            }).
            done(function(response) {
                $currentProgress.progressbar('option', 'value', 100);

                if(response.status) {
                    // got the new job
                    importJob.packageId = installPackage.id;
                    // set up the final form to send the job id to completed page
                    $('#FinishedFormJobID').val(importJob.packageId);
                    doImport(importJob);
                }
                else {
                    popError('Error starting inport', response.data);
                }
            }).
            fail(function() {
                popError('No Import Job.', 'Could not create new import job.');
            });
        }

        function doImport(importJob) {
            // start the import
            if(importJob.data.posts.length > 0) {
                var numberToImport = importJob.data.posts[0].post_type === 'attachment' ? 1 : 10;
                var posts = importJob.data.posts.splice(0, numberToImport);
                importPosts(posts, importJob);
            }
            else if(importJob.data.menus && importJob.data.menus.length > 0) {
                importMenu(importJob.data.menus.shift(), importJob);
            }
            else if(importJob.data.slideshows && importJob.data.slideshows.length > 0) {
                importSlideshow(importJob.data.slideshows.shift(), importJob);
            }
            else if(undefined !== importJob.data.final_setup) {
                finalSetup(importJob);
            }
            else {
                $('#import-finished-form').submit();
            }
        }

        function importPosts(posts, importJob) {
            if(posts.length === 1) {
                currentTask('Installing ' + posts[0].post_type + ' - ' + posts[0].post_title);
            }
            else {
                currentTask('Installing ' + posts.length + ' items');
            }
            $currentProgress.progressbar('option', 'value', 0);
            setTimeout(function() {
                $.ajax({
                    type: 'POST',
                    url: importInfo.ajaxURL,
                    data: {
                        action: 'oxy_import_posts',
                        installPackageId: importJob.packageId,
                        nonce: importInfo.importNonce,
                        data: JSON.stringify(posts)
                    },
                    xhr: xhrProgress,
                    dataType: 'json'
                }).
                fail(function(response) {
                    popError('Import Post Failed.', 'Could not get response');
                }).
                always(function() {
                    $currentProgress.progressbar('option', 'value', 100);
                    incrementTotal(posts.length);
                    doImport(importJob);
                });
            }, importInfo.installThrottle);
        }

        function importMenu(menu, importJob) {
            currentTask('Installing Menu ' + menu.name + ' items');
            $currentProgress.progressbar('option', 'value', 0);
            setTimeout(function() {
                $.post(importInfo.ajaxURL, {
                    action: 'oxy_import_menu',
                    installPackageId: importJob.packageId,
                    nonce: importInfo.importNonce,
                    data: JSON.stringify(menu)
                }).
                fail(function() {
                    popError('Import Menu Failed.', 'Could not get response');
                }).
                always(function() {
                    $currentProgress.progressbar('option', 'value', 100);
                    incrementTotal(1);
                    doImport(importJob);
                });
            }, importInfo.installThrottle);
        }

        function importSlideshow(slideshow, importJob ) {
            currentTask('Installing slideshow ' + slideshow.filename + ' items');
            $currentProgress.progressbar('option', 'value', 0);
            setTimeout(function() {
                $.post( importInfo.ajaxURL, {
                    action: 'oxy_import_slideshow',
                    installPackageId: importJob.packageId,
                    nonce: importInfo.importNonce,
                    slideshow: slideshow,
                }).
                fail( function() {
                    popError( 'Slideshow Import Failed.', 'Could not import ' + slideshow.filename + ' package.');
                }).
                always(function() {
                    $currentProgress.progressbar('option', 'value', 100);
                    incrementTotal(1);
                    doImport(importJob);
                });
            }, importInfo.installThrottle);
        }

        function finalSetup(importJob) {
            currentTask('Finalising import');
            $currentProgress.progressbar('option', 'value', 0);

            $.post(importInfo.ajaxURL, {
                action: 'oxy_import_final_setup',
                installPackageId: importJob.packageId,
                nonce: importInfo.importNonce,
                data: JSON.stringify(importJob.data.final_setup)
            }).
            fail(function() {
                popError('Final Setup Error.', 'Could not get response');
            }).
            always(function() {
                $currentProgress.progressbar('option', 'value', 100);
                delete importJob.data.final_setup;
                incrementTotal(1);
                doImport(importJob);
            });
        }

        // get the theme package data
        var packageId = $('.oxy-one-click-install').attr('data-install-id');
        for(var i in importInfo.themePackages) {
            if(importInfo.themePackages[i].id === packageId) {
                // start the download
                downloadInstallPackage(importInfo.themePackages[i]);
            }
        }
    });
})(jQuery);