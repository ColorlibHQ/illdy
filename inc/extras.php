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
if( !function_exists( 'illdy_move_comment_field_to_bottom' ) ) {
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
if( !function_exists( 'illdy_get_image_id_from_image_url' ) ) {
    function illdy_get_image_id_from_image_url( $image_url ) {
        global $wpdb;
        $attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ) );

        if( $attachment ) {
            return $attachment[0];
        }
    }
}

/**
 *  Sections order
 */
if( !function_exists( 'illdy_sections_show' ) ) {
    function illdy_sections_order( $section ) {

        $controls = array(
                'illdy_panel_about' => 'illdy_about_general_show',
                'illdy_panel_projects' => 'illdy_projects_general_show',
                'illdy_testimonials_general' => 'illdy_testimonials_general_show',
                'illdy_panel_services' => 'illdy_services_general_show',
                'illdy_latest_news_general' => 'illdy_latest_news_general_show',
                'illdy_counter_general' => 'illdy_counter_general_show',
                'illdy_panel_team' => 'illdy_team_general_show',
                'illdy_contact_us' => 'illdy_contact_us_general_show'
            );

        if ( in_array( $section , $controls) ) {
            return get_theme_mod( $controls[$section], 1 );
        }else{
            return true;
        }

    }
}

if( !function_exists( 'illdy_sections' ) ) {
    function illdy_sections() {

        $templates = array(
                'illdy_panel_about' => 'about',
                'illdy_panel_projects' => 'projects',
                'illdy_testimonials_general' => 'testimonials',
                'illdy_panel_services' => 'services',
                'illdy_latest_news_general' => 'latest-news',
                'illdy_counter_general' => 'counter',
                'illdy_panel_team' => 'team',
                'illdy_contact_us' => 'contact-us'
            );

        $sections = illdy_get_sections_position();

        foreach ( $sections as $s_id ) {
            if ( illdy_sections_order($s_id) ) {
                get_template_part( 'sections/front-page', $templates[$s_id] );
            }
        }

    }
}
