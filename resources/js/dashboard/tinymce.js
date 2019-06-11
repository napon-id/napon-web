require('tinymce');
require('tinymce/themes/silver/index');
require('tinymce/plugins/paste');
require('tinymce/plugins/advlist');
require('tinymce/plugins/autolink');
require('tinymce/plugins/lists');
require('tinymce/plugins/link');
require('tinymce/plugins/charmap');
require('tinymce/plugins/print');
require('tinymce/plugins/preview');
require('tinymce/plugins/anchor');
require('tinymce/plugins/textcolor');
require('tinymce/plugins/searchreplace');
require('tinymce/plugins/visualblocks');
require('tinymce/plugins/code');
require('tinymce/plugins/fullscreen');
require('tinymce/plugins/insertdatetime');
require('tinymce/plugins/media');
require('tinymce/plugins/table');
require('tinymce/plugins/contextmenu');
require('tinymce/plugins/code');
require('tinymce/plugins/help');
require('tinymce/plugins/wordcount');
require('tinymce/plugins/link');

if ($('#editor').length > 0) {
    tinymce.init({
        selector: '#editor',
        plugins: 'link, table',
        menubar: 'insert edit view format table',
        toolbar: [
            'undo redo',
            'bold italic underline strikethrough',
            'link',
            'alignleft aligncenter alignright alignjustify',
            'fontsize blockquote p'
        ],
    });
}