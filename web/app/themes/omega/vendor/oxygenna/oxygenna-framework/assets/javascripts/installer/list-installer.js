/**
 * Oxygenna.com
 *
 * $Template:: *(TEMPLATE_NAME)*
 * $Copyright:: *(COPYRIGHT)*
 * $Licence:: *(LICENCE)*
 */
(function( $ ){
    var listItemNum = 0;

    $(document).bind('cbox_complete', function() {
        doActionOnList();
    });

    function updateList($listRow, itemOk) {
        var rowClass = itemOk ? 'list-ok' : 'list-error';
        var icon = itemOk ? 'dashicons-yes' : 'dashicons-no';

        $listRow.addClass(rowClass);
        $listRow.find('td').html('<span class="dashicons-before ' + icon + '"></span>');
    }

    function doActionOnList() {
        if(listItemNum < oxyThemeInstall.data.list.length) {
            var listItem = oxyThemeInstall.data.list[listItemNum];
            // start the item off by changing list to spinner
            var $listRow = $('#' + listItem.id);
            $listRow.find('td').html('<img src="images/wpspin_light.gif">');

            var jqxhr = $.post(oxyThemeInstall.ajaxURL, {
                action: listItem.action,
                nonce: listItem.nonce
            })
            .done(function(data) {
                updateList($listRow, data.status);
            })
            .fail(function(data) {
                updateList($listRow, false);
            })
            .always(function() {
                listItemNum++;
                doActionOnList();
            })
        }
        else {
            var $allDoneBtn = $('#list-installer-button');
            $allDoneBtn.text('All Done!').removeClass('button-secondary').addClass('button-primary').removeAttr('disabled');
            if(oxyThemeInstall.data.afterInstall.createPopup) {
                $allDoneBtn.click(function(event) {
                    openBox(oxyThemeInstall.data.afterInstall.action, oxyThemeInstall.data.afterInstall.nonce, 800)
                    event.preventDefault();
                });
            }
            else {
                $allDoneBtn.attr('href', oxyThemeInstall.data.afterInstall.url);
            }
        }
    }

    function openBox(action, nonce, width) {
        $.colorbox({
            overlayClose: false,
            closeButton: false,
            href: oxyThemeInstall.ajaxURL + '?action=' + action + '&nonce=' + nonce,
            innerWidth: width,
            maxHeight: '100%',
        });
    }

    $(document).ready(function($){
        openBox(oxyThemeInstall.data.action, oxyThemeInstall.data.nonce, 650);
    });
})( jQuery );