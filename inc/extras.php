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
if( !function_exists( 'illdy_sections_order' ) ) {
    function illdy_sections_order( $input ) {
        $about_general_show = get_theme_mod( 'illdy_about_general_show', 1 );
        $projects_general_show = get_theme_mod( 'illdy_projects_general_show', 1 );
        $testimonials_general_show = get_theme_mod( 'illdy_testimonials_general_show', 1 );
        $services_general_show = get_theme_mod( 'illdy_services_general_show', 1 );
        $latest_news_general_show = get_theme_mod( 'illdy_latest_news_general_show', 1 );
        $counter_general_show = get_theme_mod( 'illdy_counter_general_show', 1 );
        $team_general_show = get_theme_mod( 'illdy_team_general_show', 1 );
        $contact_us_general_show = get_theme_mod( 'illdy_contact_us_general_show', 1 );
        if( $input == 1 && $about_general_show == 1 ) {
            get_template_part( 'sections/front-page', 'about' );
        } elseif( $input == 2 && $projects_general_show == 1 && illdy_is_active_jetpack_projects() ) {
            get_template_part( 'sections/front-page', 'projects' );
        } elseif( $input == 3 && $testimonials_general_show == 1 && illdy_is_active_jetpack_testimonials() ) {
            get_template_part( 'sections/front-page', 'testimonials' );
        } elseif( $input == 4 && $services_general_show == 1 ) {
            get_template_part( 'sections/front-page', 'services' );
        } elseif( $input == 5 && $latest_news_general_show == 1 ) {
            get_template_part( 'sections/front-page', 'latest-news' );
        } elseif( $input == 6 && $counter_general_show == 1 ) {
            get_template_part( 'sections/front-page', 'counter' );
        } elseif( $input == 7 && $team_general_show == 1 ) {
            get_template_part( 'sections/front-page', 'team' );
        } elseif( $input == 8 && $contact_us_general_show == 1 ) {
            get_template_part( 'sections/front-page', 'contact-us' );
        }
    }
}

#Create admin notice

$pixova_show_update_notice = get_option( 'illdy-remove-update-notice', false );

if ( ! $pixova_show_update_notice && 'posts' == get_option( 'show_on_front' ) && current_user_can( 'manage_options' ) ) {

    add_action( 'admin_enqueue_scripts', 'illdy_enqueue_notice_js' );
    add_action( 'admin_notices', 'illdy_admin_notice_html' );
    add_action( 'wp_ajax_illdy_remove_upate_notice', 'illdy_disable_notice_ajax' );

}

function illdy_enqueue_notice_js( $hook ) {

    wp_enqueue_script( 'illdy-update-error-status', get_template_directory_uri() . '/layout/js/illdy_notice.js', array( 'jquery' ), '1.0', true );
}

function illdy_admin_notice_html() {
    ?>
    <div class="notice error illdy-error-update is-dismissible">
        <p>
            <?php
            _e( 'Some changes were made in the latest version so that the theme would properly work with core WordPress\' front page system.  If you\'d like to continue using the custom front page, visit', 'illdy' );
            echo ' <a href="' . esc_url( admin_url( 'options-reading.php' ) ) . '">' . __( 'Settings > Readings', 'illdy' ) . '</a> ';
            _e( 'and set your front page to display a page.', 'illdy' );
            ?>
        </p>
    </div>
    <?php
}

function illdy_disable_notice_ajax() {
    update_option( 'illdy-remove-update-notice', true );
    wp_die();
}