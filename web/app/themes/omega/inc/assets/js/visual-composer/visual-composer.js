/**
 * Oxygenna.com
 *
 * $Template:: *(TEMPLATE_NAME)*
 * $Copyright:: *(COPYRIGHT)*
 * $Licence:: *(LICENCE)*
 */
(function( $ ){
    window.OxyVcButtonView = vc.shortcode_view.extend( {
        events:function () {
            return _.extend( {
                'click button':'buttonClick'
            }, window.VcToggleView.__super__.events);
        },
        buttonClick:function (e) {
            e.preventDefault();
        },
        changeShortcodeParams:function (model) {
            window.OxyVcShapedImageView.__super__.changeShortcodeParams.call(this, model);
            var params = model.get('params');
            window.VcButtonView.__super__.changeShortcodeParams.call(this, model);
            if (_.isObject(params)) {
                var el_class = 'btn-' + params.type + ' btn-' + params.size;
                this.$el.find('.wpb_element_wrapper').removeClass(el_class);
                this.$el.find('button.title').attr({ "class":"title textfield wpb_button " + el_class });

                if( params.icon !== undefined ) {
                    if( params.icon != '' ) {
                        switch( params.show_icon ) {
                            case 'left':
                                this.$el.find('button.title').prepend('<i class="icon fa fa-' + params.icon + '"></i>');
                            break;
                            case 'right':
                                this.$el.find('button.title').append('<i class="icon fa fa-' + params.icon + '"></i>');
                            break;
                            default:
                            case 'none':
                                this.$el.find('button.title i.icon').remove();
                            break;
                        }
                    }
                }
            }
        }
    });
    window.OxyVcIconView = vc.shortcode_view.extend( {
        changeShortcodeParams:function (model) {
            window.OxyVcShapedImageView.__super__.changeShortcodeParams.call(this, model);
            var params = model.get('params');
            if (_.isObject(params)) {
                this.$el.find('.wpb_element_wrapper i').remove();
                this.$el.find('.wpb_element_wrapper').append( '<i class="fa fa-' + params.content + '" style="font-size:' + params.size + 'px"></i>' );
            }
        }
    });
    window.OxyVcFeaturedIconView = vc.shortcode_view.extend( {
        changeShortcodeParams:function (model) {
            window.OxyVcShapedImageView.__super__.changeShortcodeParams.call(this, model);
            var params = model.get('params');
            if (_.isObject(params)) {
                this.$el.find('.wpb_element_wrapper i').remove();
                this.$el.find('.wpb_element_wrapper').append( '<i class="fa fa-' + params.icon + '"></i>' );
            }
        }
    });
    window.OxyVcShapedImageView = vc.shortcode_view.extend( {
        changeShortcodeParams:function (model) {
            window.OxyVcShapedImageView.__super__.changeShortcodeParams.call(this, model);
            var params = model.get('params');
            if (_.isObject(params)) {
                if( !_.isEmpty( params.image ) ) {
                    var element = this.$el;
                    $.ajax({
                        type: 'POST',
                        url: window.ajaxurl,
                        data:{
                            action: 'wpb_single_image_src',
                            content: params.image,
                            size: 'thumbnail'
                        },
                        dataType:'html'
                    }).done(function (url) {
                        element.find('.wpb_element_wrapper').css( {
                            'background-image': 'url(' + url + ')',
                            'background-size': '32px 32px'
                        });
                    });
                }
                if( !_.isEmpty( params.shape ) ) {
                    element.find('.wpb_element_wrapper h4').html( 'Shaped Image (' + params.shape + ')' );
                }
            }
        }
    });
    window.OxyVcHeadingView = vc.shortcode_view.extend( {
        changeShortcodeParams:function (model) {
            window.OxyVcShapedImageView.__super__.changeShortcodeParams.call(this, model);
            var params = model.get('params');
            if (_.isObject(params)) {
                this.$el.find('.wpb_element_wrapper').empty();
                var headerSizes = {
                    'normal': '18px',
                    'super': '30px',
                    'hyper': '48px',
                };
                var headerWeights = {
                    'regular': '400',
                    'black': '900',
                    'bold': '700',
                    'light': '300',
                    'hairline': '100'
                };
                var heading = $('<h1>' + params.content + '</h1>');
                heading.css( {
                    'font-size': headerSizes[params.header_size],
                    'font-weight': headerWeights[params.header_weight]
                });
                this.$el.find('.wpb_element_wrapper').append( heading );
                this.$el.find('.wpb_element_wrapper').css({
                    'text-align': params.header_align
                })
            }
        }
    });
    window.OxyVcLeadView = vc.shortcode_view.extend( {
        changeShortcodeParams:function (model) {
            window.OxyVcShapedImageView.__super__.changeShortcodeParams.call(this, model);
            var params = model.get('params');
            if (_.isObject(params)) {
                this.$el.find('.wpb_element_wrapper').empty();
                var lead = $('<strong>' + params.content + '</strong>');
                this.$el.find('.wpb_element_wrapper').append( lead );
                this.$el.find('.wpb_element_wrapper').css({
                    'text-align': params.align
                })
            }
        }
    });
    window.OxyVcBlockQuoteView = vc.shortcode_view.extend( {
        changeShortcodeParams:function (model) {
            window.OxyVcShapedImageView.__super__.changeShortcodeParams.call(this, model);
            var params = model.get('params');
            if (_.isObject(params)) {
                this.$el.find('.wpb_element_wrapper p').html('"' + params.content + '"');
            }
        }
    });

})( jQuery );
