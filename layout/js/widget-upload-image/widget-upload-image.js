/**
 *  jQuery Document Ready
 */
jQuery( document ).ready( function($) {
    function media_upload(button_class) {
        var _custom_media = true,
        _orig_send_attachment = wp.media.editor.send.attachment;

        $('body').on('click', button_class, function(e) {
            var button_id ='#'+$(this).attr('id');
            var self = $(button_id);
            var send_attachment_bkp = wp.media.editor.send.attachment;
            var button = $(button_id);
            var id = button.attr('id').replace('_button', '');
            var field_id = $(this).attr('data-fieldid');
            _custom_media = true;
            wp.media.editor.send.attachment = function(props, attachment){
                if ( _custom_media  ) {
                    console.log(attachment.url);
                    $('.custom_media_id').val(attachment.id);
                    $('.custom_media_url_'+field_id).val(attachment.url);
                } else {
                    return _orig_send_attachment.apply( button_id, [props, attachment] );
                }
            }

            wp.media.editor.open(button);

            return false;
        });
    }
    media_upload('.button.custom_media_button.button-primary');
});