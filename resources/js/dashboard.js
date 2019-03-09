// bootstrap
require('./bootstrap');

// sb-admin
require('startbootstrap-sb-admin/vendor/jquery-easing/jquery.easing.min');
require('startbootstrap-sb-admin/vendor/datatables/jquery.dataTables.min');
require('startbootstrap-sb-admin/vendor/datatables/dataTables.bootstrap4.min');
require('startbootstrap-sb-admin/js/sb-admin.min');

// components
require('./global');
require('./dashboard/datatables');
require('./dashboard/copyToClipboard');

// ajaxSetup
require('./dashboard/ajaxSetup');
