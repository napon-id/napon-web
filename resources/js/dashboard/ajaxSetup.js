(function ($) {
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
            }
        });
    })
}) (jQuery);
