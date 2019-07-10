(function ($) {
    $(function () {
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            endDate: '-17y'
        });

        $('.default-datepicker').datepicker({
            format: 'dd-mm-yyyy',
            endDate: '+0d'
        });

        $('.no-rule-datepicker').datepicker({
            format: 'dd-mm-yyyy'
        });
    })
}) (jQuery);