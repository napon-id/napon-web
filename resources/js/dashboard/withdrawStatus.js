(function ($) {
    window.withdrawStatus = function (id, url, next) {
        var appendedURL = url + '?id=' + id + '&next=' + next;
        $.ajax({
            url: appendedURL,
            dataType: 'JSON',
            type: 'GET',
            success: function (data) {
                console.log(data);
                if ($('.datatable').length > 0) {
                    $('.datatable').DataTable().draw(false);
                }
            }
        })
    }
}) (jQuery);
