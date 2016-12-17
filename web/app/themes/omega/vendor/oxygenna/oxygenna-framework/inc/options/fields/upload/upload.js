(function($){
    $(document).ready(function($) {
        // set image button
        oxyInitMediaUploader();
    });

    function oxyInitMediaUploader() {
        if($('.oxy-media-holder').length) {
            $('.oxy-media-holder').each(function() {
                var fileFrame;
                var removeButton;
                var uploadImageHolder;
                var uploadUrl;

                //set variables values
                uploadUrl           = $(this).find('.oxy-media-upload-url');
                uploadImageHolder   = $(this).find('.oxy-image-option-preview');
                removeButton        = $(this).find('.oxy-remove-image');

                if (uploadImageHolder.attr('src') != "") {
                    removeButton.show();
                    oxyInitMediaRemoveBtn(removeButton);
                }


                $(this).on('click', '.oxy-set-image', function() {
                    //if the media frame already exists, reopen it.
                    if (fileFrame) {
                        fileFrame.open();
                        return;
                    }
                    //create the media frame
                    fileFrame = wp.media.frames.fileFrame = wp.media({
                        title: $(this).data('frame-title'),
                        button: {
                            text: $(this).data('frame-button-text')
                        },
                        multiple: false
                    });

                    //when an image is selected, run a callback
                    fileFrame.on( 'select', function() {
                        attachment = fileFrame.state().get('selection').first().toJSON();
                        removeButton.show();
                        oxyInitMediaRemoveBtn(removeButton);
                        //write to url field and img tag
                        if(attachment.hasOwnProperty('url')) {
                            uploadUrl.val(attachment.url);
                            uploadImageHolder.attr('src', attachment.url);
                            uploadImageHolder.show();
                        }
                    });

                    //open media frame
                    fileFrame.open();
                });
            });
        }

        function oxyInitMediaRemoveBtn(btn) {
            btn.on('click', function() {
                //remove image src and hide it's holder
                btn.siblings('.oxy-image-option-preview').hide();
                btn.siblings('.oxy-image-option-preview').attr('src', '');

                //reset meta fields
                btn.siblings('.oxy-media-upload-url').val('');
                btn.hide();
            });
        }
    }
})(jQuery);