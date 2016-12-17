(function($){
    $.widget.bridge('uitooltip', $.ui.tooltip);

    $(document).ready(function() {
        // var tooltips = $( "[data-description]" ).tooltip( { items: '[data-description]' } );
        var tooltips = $( ".description" ).uitooltip({
            content: function () {
                return $(this).prop('title');
            },
            position: {
                my: "center bottom-20",
                at: "center top",
            },
            hide: {
                delay: 2000
            }
        });
    });
})(jQuery);