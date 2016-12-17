/**
 * Oxygenna.com
 *
 * $Template:: *(TEMPLATE_NAME)*
 * $Copyright:: *(COPYRIGHT)*
 * $Licence:: *(LICENCE)*
 */

'use strict';

/* jshint camelcase: false */

 /* global jQuery: false, fontData: false, alert: false */

jQuery(document).ready(function($) {
    $('.font-select').each(function(index, value) {
        var $select   = $(this);
        var $hidden   = $select.next();
        var font      = $hidden.val();
        var $variants = $hidden.next();
        var $subsets  = $variants.next();

        if(!font) {
            font = {
                value: '',
                family:'',
                provider: '',
                variants:[],
                subsets:[]
            };
        }
        else {
            font = JSON.parse(atob(font));
        }

        $select.parent().on('change', 'input[type="checkbox"]', function() {
            updateWeightsCharsets();
        });

        // start select2
        $select.select2({width:'100%'});
        $select.select2('val', font.value);

        function selectChange(event) {
            $variants.empty();
            $variants.append('<div style="text-align:center"><img src="images/spinner.gif"/></div>');
            $subsets.empty();

            $.post(fontData.ajaxURL, {
                action: 'oxy_get_font',
                nonce: fontData.getFontNonce,
                font: $select.val()
            }).
            done(function(response) {
                if (response.status) {
                    font.value = $select.val();
                    font.family = response.data.family;
                    font.provider = response.provider;
                    if (undefined !== event) {
                        font.variants = [];
                        font.weights = [];
                    }

                    switch(font.provider) {
                        case 'google_fonts':
                        case 'system_fonts':
                        break;
                        default:
                            // typekit
                            font.css_stack = response.data.css_stack;
                        break;
                    }

                    // populate divs with checkboxes
                    createChecklist($variants, 'Font Weights : ', response.data.variants, font.variants);
                    createChecklist($subsets, 'Charsets : ', response.data.subsets, font.subsets);

                    updateWeightsCharsets();
                }
            }).
            fail(function() {
                alert('could not fetch fonts');
            });
        }
        $select.on('change', selectChange);
        selectChange();

        function createChecklist($checklist, title, data, checked) {
            $checklist.empty();
            $checklist.hide();
            if (data.length > 0) {
                $checklist.append('<strong>' + title + '</strong>');
                for (var i = 0; i < data.length; i++) {
                    var isChecked = checked.indexOf(data[i]) > -1 ? ' checked' : '';
                    $checklist.append('<label for="' + data[i] + '"><input type="checkbox" id="' + data[i] + '" value="' + data[i] + '"' + isChecked + '>' + data[i] + '</label>');
                }
            }
            $checklist.fadeIn();
        }

        function checklistToArray(font, property, checklist) {
            font[property] = [];
            var checked = checklist.find('input:checked');
            if (checked.length > 0) {
                $.map(checked, function(item) {
                    font[property].push($(item).val());
                });
            }
        }

        function updateWeightsCharsets() {
            // get checked variants & subsets
            checklistToArray(font, 'variants', $variants);
            checklistToArray(font, 'subsets', $subsets);
            $hidden.val(btoa(JSON.stringify(font)));
        }
    });
});