(function ($) {
    $(function () {
        var columns = [];
        var order = 'asc';
        $.each($('.datatable th'), function (key, val) {
            var tmp = $(val).data('field');
            if ($(val).data('order') == 'desc') {
                order = 'desc';
            }
            columns.push({
                data: tmp
            });
        })

        $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: $('.datatable').data('url'),
            columns: columns,
            order: [ [0, order] ],
        })

    })
}) ( jQuery );
