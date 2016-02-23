<?php
/**
 *	Adds custom classes to the array of body classes.
 */
if(!function_exists('illdy_body_classes')) {
    add_filter( 'body_class', 'illdy_body_classes' );
    function illdy_body_classes( $classes ) {
        // Adds a class of group-blog to blogs with more than 1 published author.
        if ( is_multi_author() ) {
            $classes[] = 'group-blog';
        }

        // Adds a class of hfeed to non-singular pages.
        if ( ! is_singular() ) {
            $classes[] = 'hfeed';
        }
        return $classes;
    } 
}

/**
 *  Comment
 */
if(!function_exists('illdy_comment')) {
    function illdy_comment( $comment, $args, $depth ) {
        $GLOBALS['comment'] = $comment;
        switch ( $comment->comment_type ) :
            case 'pingback' :
            case 'trackback' :
        ?>
        <li class="post pingback">
            <p><?php _e( 'Pingback:', 'illdy' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'illdy' ), ' ' ); ?></p>
        <?php
                break;
            default :
        ?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
            <div id="comment-<?php comment_ID(); ?>">
                <div class="row">
                    <div class="col-sm-2 clearfix">
                        <div class="comment-gravatar">
                            <?php echo get_avatar( $comment, 84 ); ?>
                        </div><!--/.comment-gravatar-->
                    </div><!--/.col-sm-2-->
                    <div class="col-sm-10">
                        <?php printf( __( '%s', 'illdy' ), sprintf( '%s', get_comment_author_link() ) ); ?>
                        <time class="comment-time" datetime="<?php printf( '%s-%s-%s', get_the_date( 'Y' ), get_the_date( 'm' ), get_the_date( 'd' ) ); ?>"><?php printf( __( '%1$s at %2$s', 'illdy' ), get_comment_date(), get_comment_time() ); ?></time>
                        <div class="comment-entry markup-format">
                            <?php comment_text(); ?>
                            <?php
                            if(  $comment->comment_approved == '0' ):
                                _e( 'Your comment is awaiting moderation.', 'illdy' );
                            endif;
                            ?>
                        </div><!--/.comment-entry.markup-format-->
                        <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                    </div><!--/.col-sm-10-->
                </div><!--/.row-->
            </div><!--/#comment-<?php comment_ID(); ?>.row-->
        <?php
                break;
        endswitch;
    }
}


/**
 *  Move comment field to bottom
 */
if(!function_exists('illdy_move_comment_field_to_bottom')) {
    add_filter( 'comment_form_fields', 'illdy_move_comment_field_to_bottom' );
    function illdy_move_comment_field_to_bottom( $fields ) {
        $comment_field = $fields['comment'];
        unset( $fields['comment'] );
        $fields['comment'] = $comment_field;
        return $fields;
    }
}


/**
 *  Get image ID from Image URL
 */
if(!function_exists('illdy_get_image_id_from_image_url')) {
    function illdy_get_image_id_from_image_url( $image_url ) {
        global $wpdb;
        $attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ) );

        if( $attachment ) {
            return $attachment[0];
        }
    }
}