// bootstrap
require('./bootstrap');

// sb-admin
require('startbootstrap-sb-admin/vendor/jquery-easing/jquery.easing.min');
require('startbootstrap-sb-admin/vendor/datatables/jquery.dataTables.min');
require('startbootstrap-sb-admin/vendor/datatables/dataTables.bootstrap4.min');
require('startbootstrap-sb-admin/js/sb-admin.min');

// ajaxSetup
require('./dashboard/ajaxSetup');

// components
require('./global');
require('./dashboard/datatables');
require('./dashboard/copyToClipboard');
require('./dashboard/withdrawStatus');
require('./dashboard/cities.js');
require('./dashboard/tinymce');

// autonumeric
import AutoNumeric from 'autonumeric';

if ($('.currency').length > 0) {
    const autoNumericOptions = {
        digitGroupSeparator         : '.',
        decimalCharacter            : ',',
        decimalCharacterAlternative : '.',
        unformatOnSubmit            : true,
        maximumValue                : 9999999999999999,
    };
    AutoNumeric.multiple('.currency', autoNumericOptions);
}

// datepicker
require('bootstrap-datepicker');
require('./dashboard/datepicker');