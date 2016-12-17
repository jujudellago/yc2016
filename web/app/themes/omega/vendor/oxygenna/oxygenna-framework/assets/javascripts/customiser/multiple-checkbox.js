jQuery(document).ready(function($) {

    /* === Checkbox Multiple Control === */
    window.setTimeout(function() {
        $('.customize-control-multiple-checkbox input[type="checkbox"]').on(
            'change',
            function() {
                checkbox_values = $(this).parents('.customize-control').find('input[type="checkbox"]:checked').map(
                    function() {
                        return this.value;
                    }
                ).get().join(',');
                $(this).parents('.customize-control').find('input[type="hidden"]').val(checkbox_values).trigger('change');
            }
        );
    }, 100);

}); // jQuery(document).ready