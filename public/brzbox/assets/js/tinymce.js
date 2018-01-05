$(document).ready(function() {

    tinymce.init({
      selector: '.tinymce',

      paste_auto_cleanup_on_paste : true,
      paste_remove_styles: true,
      paste_remove_styles_if_webkit: true,
      paste_strip_class_attributes: true,

      language : 'pt_BR',
      height: 100,
      resize: false,
      autoresize_min_height: 10,
      autoresize_max_height: 400,
      entity_encoding : 'raw',
      relative_urls : false,

      menubar : false,
      statusbar : false,
      toolbar: 'undo redo | styleselect | bold italic | image | media link | removeformat code',

      plugins: [
        'autolink autoresize link image code media table paste'
      ],

      file_browser_callback_types: 'image',
      file_browser_callback: fileBrowserCallBack,

      image_dimensions: false,
      media_dimensions: false,
      media_alt_source: false,
      media_poster: false,
      video_template_callback: function(data) {
        return '<div class="embed-responsive embed-responsive-16by9">' +
               '<iframe class="embed-responsive-item" src="'+data.source1+'" frameborder="0" allowfullscreen>' +
               '</iframe></div>';
      }

    });

    function fileBrowserCallBack(field_name, url, type, win) {
      browserField = field_name;
      browserWin = win;
      $('#uploader').modal('toggle');
    }

});
