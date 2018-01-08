jQuery( document ).on( 'click', '.illdy-error-update .notice-dismiss', function() {

  jQuery.ajax( {
    url: ajaxurl,
    method: 'POST',
    data: {
      action: 'illdy_remove_upate_notice'
    }
  } );

} );
