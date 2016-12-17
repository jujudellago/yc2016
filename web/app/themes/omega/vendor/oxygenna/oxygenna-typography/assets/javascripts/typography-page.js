/**
 * Oxygenna.com
 *
 * $Template:: *(TEMPLATE_NAME)*
 * $Copyright:: *(COPYRIGHT)*
 * $Licence:: *(LICENCE)*
 */

 /*global jQuery: false, _: false, typographyPage: false, tb_show: false */

'use strict';
(function($) {
    $(document).ready(function($) {
        var niceNameLookup = {
            providers: {
                system_fonts: 'System Fonts',
                google_fonts: 'Google Fonts'
            },
            variations: {
                fontStyle: {
                    n: 'normal',
                    i: 'italic',
                    o: 'oblique'
                },
                fontWeight: [
                    '000',
                    '100',
                    '200',
                    '300',
                    'normal',
                    '500',
                    '600',
                    'bold',
                    '800',
                    '900',
                ]
            }
        };
        // initialise select2
        $('.select2').select2();

        var fontstack;

        // grab the font list
        updateFontList();

        window.saveFont = function( font, position ) {
            fontstack[position] = font;
            updateFontTable();
        };

        function updateFontList() {
            var $tbody = jQuery('#fontstack-list').find('tbody');
            $tbody.find('tr').remove();
            $tbody.append( '<tr class="fetching-fonts"><td colspan="6" align="center"><strong>Fetching font list</strong> <img src="images/spinner.gif"/></td></tr>' );

            $.post( typographyPage.ajaxurl,{
                action: 'fontstack_list',
                nonce: typographyPage.listNonce
            })
            .done(function( response ) {
                fontstack = response.data;
                updateFontTable();
            })
            .fail(function( jqxhr, textStatus, error ) {
                var err = textStatus + ', ' + error;
            });
        }

        function fontVariantsList( font ) {
            var list = '';
            $.each( font.variants, function( index, variant ) {
                list += fontVariantName( font, variant );
            });
            return '<ul>' + list + '</ul>';
        }

        function fontVariantName( font, variant ) {
            // store style - 0 and weight - 1 in array then join at the end to show style - weight
            var name = [];
            switch( font.provider ) {
                case 'google_fonts':
                    name[0] = variant.indexOf( 'italic' ) === -1 ? 'normal' : 'italic';
                    name[1] = variant.replace( 'italic', '' );
                    if( name[1] === '' ) {
                        name[1] = 'regular';
                    }
                    break;
                default:
                case 'system_fonts':
                    if( variant.length === 2 ) {
                        var pieces = variant.split('');
                        name[0] = niceNameLookup.variations.fontStyle[pieces[0]];
                        name[1] = niceNameLookup.variations.fontWeight[pieces[1]];
                    }
                    break;
            }

            return '<li>' + name.join(' - ') + '</li>';
        }

        function fontColumnList( font, attr ) {
            if( font[attr] !== undefined && font[attr].length > 0 ) {
                var list = '';
                $.each( font[attr], function( index, element ) {
                    if( attr === 'variants' ) {
                        list += fontVariantName( font, element );
                    }
                    else {
                        list += '<li>' + element + '</li>';
                    }
                });
                return '<ul>' + list + '</ul>';
            }
            else {
                return '-';
            }

        }

        function updateFontTable() {
            var $tbody = jQuery('#fontstack-list').find('tbody');
            // remove all rows from the list
            $tbody.find('tr').remove();
            // do we have anything in the fontstack
            if( fontstack.length > 0 ) {
                _.each( fontstack, function( font ) {
                    var providerName = niceNameLookup.providers[font.provider] === undefined ? 'TypeKit' : niceNameLookup.providers[font.provider];
                    // create new row
                    var $tr = jQuery('<tr></tr>');
                    // add font data to row
                    $tr.append( '<td>' + font.family + '</td>' );
                    $tr.append( '<td>' + providerName + '</td>' );
                    $tr.append( '<td class="variants">' + fontColumnList( font, 'variants' ) + '</td>' );
                    $tr.append( '<td class="elements">' + fontColumnList( font, 'elements' ) + '</td>' );
                    $tr.append( '<td class="subsets">' + fontColumnList( font, 'subsets' ) + '</td>' );
                    var $edit = jQuery('<button/>', {
                        class: 'button button-primary',
                        text: 'Edit',
                        click: function () {
                            tb_show('Edit font ' + font.family, 'admin-ajax.php?' + $.param( font ) + '&amp;position=' + fontstack.indexOf(font) + '&amp;isNew=false&amp;nonce=' + typographyPage.fontModal + '&amp;action=fontstack_font_modal&amp;TB_iframe=true&amp;width=830&amp;height=550' );
                            return false;
                        }
                    });
                    var $remove = jQuery('<button/>', {
                        class: 'button button-secondary',
                        text: 'Remove',
                        click: function () {
                            fontstack = _.without( fontstack, font );
                            updateFontTable();
                            return false;
                        }
                    });
                    $tr.append( jQuery( '<td></td>' ).append( $edit ).append( $remove ) );
                    $tbody.append( $tr );
                });
            }
            else {
                $tbody.append( '<tr><td colspan="5" align="center"><strong>There are no fonts assigned</strong></td></tr>' );
            }
        }

        $('#add-font-to-stack').click( function() {
            var selected = $('#fontstack-select').find(':selected');
            var provider = selected.closest('optgroup').attr('id');
            tb_show('Add font to font stack', 'admin-ajax.php?family=' + selected.val() + '&amp;position=' + fontstack.length + '&amp;provider=' + provider + '&amp;nonce=' + typographyPage.fontModal + '&amp;isNew=true&amp;action=fontstack_font_modal&amp;TB_iframe=true&amp;width=830&amp;height=550' );
            return false;
        });

        function addMessage( type, message, duration ) {
            // create message
            var messageHTML = $( '<div id="setting-error-settings_updated" class="' + type + ' settings-error below-h2"><p><strong>' + message + '</strong></p></div>' );
            messageHTML.hide();
            // add message to the page and fade in
            $( '#ajax-errors-here').append( messageHTML );
            messageHTML.fadeIn();

            if( duration !== undefined ) {
                setTimeout(function() {
                    messageHTML.fadeOut();
                }, duration);  // will work with every browser
            }
        }

        $('#submit').click( function() {
            var $saveButton = $(this);

            $saveButton.attr('disabled', true );
            $.post( typographyPage.ajaxurl, {
                action: 'fontstack_save',
                nonce: typographyPage.updateNonce,
                fontstack: fontstack
            })
            .success( function( data ) {
                fontstack = data.fontstack;
                $saveButton.attr('disabled', false );
                updateFontList();
                addMessage( 'updated', 'Fontstack saved.' , 5000 );
            })
            .error( function( response ) {
                $saveButton.attr('disabled', false );
                addMessage( 'error', 'Errors saving fontsack.', 5000 );
            });

            return false;
        });

        $('#default-font-stack').click( function() {

            $( '#dialog-confirm' ).dialog({
                resizable: false,
                modal: true,
                buttons: {
                    'Install default fonts': function() {
                        var $saveButton = $(this);
                        $saveButton.attr('disabled', true );
                        $.post( typographyPage.ajaxurl, {
                            action: 'fontstack_defaults',
                            nonce: typographyPage.defaultFontsNonce
                        })
                        .success( function( response ) {
                            if( response.status ) {
                                fontstack = response.data;
                                $saveButton.attr('disabled', false );
                                updateFontList();
                                addMessage( 'updated', response.message , 5000 );
                            }
                            else {
                                addMessage( 'error', response.message, 5000 );
                            }
                        })
                        .error( function( response ) {
                            $saveButton.attr('disabled', false );
                            addMessage( 'error', response.message, 5000 );
                        });
                        $( this ).dialog( 'close' );
                    },
                    Cancel: function() {
                        $( this ).dialog( 'close' );
                    }
                }
            });

            return false;
        });
    });
})(jQuery);