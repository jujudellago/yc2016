(function( $ ){
    $.fn.fontSelector = function( event ) {
        var typekitVariations = new Array();
        typekitVariations['font-style'] = new Array();
        typekitVariations['font-style']['n'] = 'normal';
        typekitVariations['font-style']['i'] = 'italic';
        typekitVariations['font-style']['o'] = 'oblique';

        typekitVariations['font-weight'] = new Array();
        typekitVariations['font-weight']['1'] = '100';
        typekitVariations['font-weight']['2'] = '200';
        typekitVariations['font-weight']['3'] = '300';
        typekitVariations['font-weight']['4'] = '400';
        typekitVariations['font-weight']['5'] = '500';
        typekitVariations['font-weight']['6'] = '600';
        typekitVariations['font-weight']['7'] = '700';
        typekitVariations['font-weight']['8'] = '800';
        typekitVariations['font-weight']['9'] = '900';
        typekitVariations['font-weight']['4'] = 'normal';
        typekitVariations['font-weight']['7'] = 'bold';

        function createFontOptions( font, $select ) {
            var id = $select.attr('id');
            var $selectedFont = $select.find( 'option:selected' );
            // set font name and type to load in preview
            // get font type from optgroup it is in
            $selectedFont.attr( 'data-font-provider', font['provider'] );
            switch( font['provider'] ) {
                case 'system':
                    $selectedFont.attr( 'data-font', font['family'].join(',') );
                break;
                case 'google':
                    $selectedFont.attr( 'data-font', font['family'] );
                break;
                case 'typekit':
                    $selectedFont.attr( 'data-font', font['family'] );
                    $selectedFont.attr( 'data-kit-id', font['kit-id'] );
                break;
            }
            // create main div to put options in ( easy to remove )
            var $font_options = $('<div id="' + id + '_options"></div>');
            // create weights select box
            if( font['variants'].length > 1 ) {
                var options = [];
                for( weight in font['variants'] ) {
                    var weightStyle = getWeightStyle( font['variants'][weight], font['provider'] );
                    options.push({ id:font['variants'][weight]  , text:( weightStyle['weight'] + ' / ' + weightStyle['style'] )  });
                }
                var value =  $select.attr( 'data-variant' ) == null ? "" :' value="'+$select.attr( 'data-variant' )+'" ';

                var $weights = $('<input name="' + id + '_variant" class="variants" type="hidden" '+ value +'style="width:200px"></input>');
                $font_options.append( '<label for="' + id + '">Weight / Style</label>' );
                $font_options.append( $weights );
                $weights.html( options );
                $weights.bind( 'change', function() { $select.trigger('fontChange'); });
                $weights.select2({  data:options ,
                                    maximumSelectionSize: 7 ,
                                    multiple: true,
                                    initSelection : function (element, callback) {
                                        var selected_options = [];
                                        $(element.val().split(",")).each(function () {
                                            var that = this;
                                            options.forEach(function(item){
                                                if(that == item['id']){
                                                    selected_options.push({id: item['id'], text: item['text']});
                                                }
                                            });
                                        });
                                        callback(selected_options);
                                    }
                });
            }
            // create subsets options
            var hideSubsets = $select.attr( 'hide-subsets' );
            if( typeof hideSubsets === 'undefined' || hideSubsets === false ) {
                if( font['subsets'].length > 1 ) {
                    var $subsets = $('<div class="subsets"><label>Subsets</label></div>');
                    var checkedSubsets = $select.attr( 'data-subsets' ) == null ? "" : ' value="'+$select.attr( 'data-subsets' )+'" ';
                    var subsetOptions = [];
                    for( subset in font['subsets'] ) {
                        subsetOptions.push({ id:font['subsets'][subset] , text: font['subsets'][subset] });
                    }
                    var $checkbox = $('<input type="hidden" name="' + id + '_subsets"' + checkedSubsets + ' style="width:200px" />');
                    $subsets.append( $checkbox );
                    $checkbox.select2({  data:subsetOptions ,
                                        maximumSelectionSize: 7 ,
                                        multiple: true,
                                        initSelection : function (element, callback) {
                                            var selected_options = [];
                                            $(element.val().split(",")).each(function () {
                                                var that = this;
                                                subsetOptions.forEach(function(item){
                                                    if(that == item['id']){
                                                        selected_options.push({id: item['id'], text: item['text']});
                                                    }
                                                });
                                            });
                                            callback(selected_options);
                                        }
                    });
                    $checkbox.bind( 'change', function() { $select.trigger('fontChange'); });
                    $font_options.append( $subsets );
                }
            }
            // create provider hidden field
            $font_options.append( $('<input type="hidden" name="' + id + '_provider" value="' + font['provider'] + '"/>' ) );
            return $font_options;
        }

        function changeFont() {
            // get selected font
            var $select = jQuery( this );
            var $font = $select.find( 'option:selected' );
            var provider = $font.attr( 'data-font-provider' );
            var providers = {};

            // get font variant from select box
            var $variants = $select.parent().find( '.variants' );
            var $variant = $variants.find( 'option:selected' );

            // parse variant string
            var weightStyle = getWeightStyle( $variant.val(), provider );

            switch( provider ) {
                case 'google':
                    var variantString = $variant.val() === undefined ? '' : ':' + $variant.val();
                    providers['google'] = { families: [ $font.attr('data-font') + variantString ] };
                break;
                case 'typekit':
                    providers['typekit'] = { id: [ $font.attr('data-kit-id') ] };
                break;
            }

            // load the fonts
            WebFont.load( providers );

            // get preview selector
            var previewSelector = $select.attr( 'data-preview-selector' );
            var previewTarget = $select.attr( 'data-preview-target' );
            if( null !== previewSelector ) {
                var preview = jQuery( "[name='appland-options["+previewSelector+"]'] "+previewTarget );
                preview.css( 'font-family', $font.attr('data-font') );
                preview.css( 'font-weight', weightStyle['weight'] );
                preview.css( 'font-style', weightStyle['style'] );
            }
        }

        function getWeightStyle( variant, provider ) {
            var weightStyle = { weight : 'normal', style : 'normal' };
            if( undefined !== variant ) {
                switch( provider ) {
                    case 'google':
                        // get google string, weight and style
                        // is font italic?
                        if( variant.indexOf('italic') != -1 ) {
                            weightStyle['style'] = 'italic';
                        }
                        var removedItalic = variant.replace( 'italic','' );
                        if( removedItalic == '' || removedItalic == 'regular' ) {
                            weightStyle['weight'] = 'normal';
                        }
                        else {
                            weightStyle['weight'] = removedItalic;
                        }
                    break;
                    case 'system':
                    case 'typekit':
                        if( variant.length == 2 ) {
                            var pieces = variant.split('');
                            weightStyle['weight'] = typekitVariations['font-weight'][pieces[1]];
                            weightStyle['style'] = typekitVariations['font-style'][pieces[0]];
                        }
                    break;
                }
            }
            return weightStyle;
        }

        return this.each(function() {
            var $this = $(this);
            // check if preview needs to be updated
            if( $this.hasClass( 'with-preview') ) {
                $this.bind( 'fontChange', changeFont );
            }
            $this.bind( 'change', function( event, firstCall ) {
                var $select = $(this);

                var selectedFont = $(this).find( 'option:selected' );
                var id = $select.attr('id');

                // remove any weights and subsets previously created
                $( '#' + id + '_options' ).remove();

                // if not first trigger call reset data (because new font is selected)
                if( firstCall === undefined ) {
                    $select.removeAttr( 'data-variant' );
                    $select.removeAttr( 'data-subsets' );
                }
                // use value for family and label of optgrp for provider

                $.get( localData.ajaxurl,
                {
                    action: 'fetch_font_info',
                    family : selectedFont.val(),
                    provider : selectedFont.parent().attr( 'label' ),
                    nonce: localData.nonce,
                },
                function( font ) {
                    $select.parent().append( createFontOptions( font, $select ) );
                    if( (firstCall && $select.attr( 'data-load-font-on-start' ) == 'true') || !firstCall ) {
                        $select.trigger( 'fontChange' );
                    }
                },
                'json'
                );
            });
            // call change function to create variant and subset drop downs (make sure data attr not reset [true])
            $this.trigger( 'change', [true] );
        });
    };
})( jQuery );

