(function ($) {
    $(function () {
        // popover
        $('body').popover({selector: '[data-toggle="popover"]'});
        // tooltip
        $('body').tooltip({selector: '[data-toggle="tooltip"]'});
    })
}) (jQuery);
