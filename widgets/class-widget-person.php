<?php
class Illdy_Widget_Person extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct( 'illdy_person', __( '[Illdy] - Person', 'illdy' ), array( 'description' => __( 'Add this widget in "Front page - Team Sidebar".', 'illdy' ), ) );

        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
    }

    /**
     *  Enqueue Scripts
     */
    public function enqueue_scripts() {
        wp_enqueue_media();
        wp_enqueue_script( 'illdy-widget-upload-image', get_template_directory_uri() . '/layout/js/widget-upload-image/widget-upload-image.min.js', false, '1.0', true);
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];

        $title = ( !empty( $instance['title'] ) ? esc_html( $instance['title'] ) : '' );
        $image = !empty( $instance['image'] ) ? esc_url( $instance['image'] ) : '';
        $position = ( !empty( $instance['position'] ) ? esc_html( $instance['position'] ) : '' );
        $entry = ( !empty( $instance['entry'] ) ? esc_html( $instance['entry'] ) : '' );
        $facebook_url = !empty( $instance['facebook_url'] ) ? esc_url( $instance['facebook_url'] ) : '';
        $twitter_url = !empty( $instance['twitter_url'] ) ? esc_url( $instance['twitter_url'] ) : '';
        $linkedin_url = !empty( $instance['linkedin_url'] ) ? esc_url( $instance['linkedin_url'] ) : '';
        $color = ( !empty( $instance['color'] ) ? esc_attr( $instance['color'] ) : '' );

        $image_id = illdy_get_image_id_from_image_url( $image );
        $get_attachment_image_src = wp_get_attachment_image_src( $image_id, 'illdy-front-page-person' );

        $output = '';

        $output .= '<div class="person clearfix" data-person-color="'. $color .'">';
            $output .= '<div class="person-image">';
                $output .= ( $image_id ? '<img src="'. $get_attachment_image_src[0] .'" alt="'. $title .'" title="'. $title .'" />' : ( $image ? '<img src="'. get_template_directory_uri() . $image .'" alt="'. $title .'" title="'. $title .'" />' : '' ) );
            $output .= '</div><!--/.person-image-->';
            $output .= '<div class="person-content">';
                $output .= '<h4>'. $title .'</h4>';
                $output .= '<h5>'. $position .'</h5>';
                $output .= '<p>'. $entry .'</p>';
                $output .= '<ul class="person-content-social clearfix">';
                    $output .= ( $facebook_url ) ? '<li><a href="'. $facebook_url .'" title="'. __( 'Facebook', 'illdy' ) .'" target="_blank" rel="nofollow"><i class="fa fa-facebook"></i></a></li>' : '';
                    $output .= ( $twitter_url ) ? '<li><a href="'. $twitter_url .'" title="'. __( 'Twitter', 'illdy' ) .'"><i class="fa fa-twitter" target="_blank" rel="nofollow"></i></a></li>' : '';
                    $output .= ( $linkedin_url ) ? '<li><a href="'. $linkedin_url .'" title="'. __( 'LinkedIn', 'illdy' ) .'"><i class="fa fa-linkedin" target="_blank" rel="nofollow"></i></a></li>' : '';
                $output .= '</ul><!--/.person-content-social.clearfix-->';
            $output .= '</div><!--/.person-content-->';
        $output .= '</div><!--/.person.clearfix-->';

        echo $output;

        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? sanitize_text_field( $instance['title'] ) : __( '[Illdy] - Person', 'illdy' );
        $image = !empty( $instance['image'] ) ? esc_url( $instance['image'] ) : esc_url( get_template_directory_uri() . '/layout/images/front-page/front-page-project-1.jpg' );
        $position = ! empty( $instance['position'] ) ? sanitize_text_field( $instance['position'] ) : '';
        $entry = ! empty( $instance['entry'] ) ? sanitize_text_field( $instance['entry'] ) : '';
        $facebook_url = !empty( $instance['facebook_url'] ) ? esc_url( $instance['facebook_url'] ) : '';
        $twitter_url = !empty( $instance['twitter_url'] ) ? esc_url( $instance['twitter_url'] ) : '';
        $linkedin_url = !empty( $instance['linkedin_url'] ) ? esc_url( $instance['linkedin_url'] ) : '';
        $color = !empty( $instance['color'] ) ? esc_attr( $instance['color'] ) : '';
        ?>

        <script type="text/javascript">
              //<![CDATA[
              jQuery(document).ready(function() {
                  jQuery(' .cw-color-picker' ).each(function(){
                      var $this = jQuery(this), id = $this.attr('rel');
                      $this.farbtastic('#' + id);
                  });
              });
              //]]>   
        </script>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'illdy' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_name( 'image' ); ?>"><?php _e( 'Image:', 'illdy' ); ?></label>
            <input type="text" class="widefat custom_media_url_<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" id="<?php echo $this->get_field_id( 'image' ); ?>" value="<?php if( !empty( $instance['image'] ) ): echo $instance['image']; else: get_template_directory_uri() . '/layout/images/front-page/front-page-project-1.jpg'; endif; ?>" style="margin-top:5px;">
            <input type="button" class="button button-primary custom_media_button" id="custom_media_button_service" data-fieldid="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" value="<?php _e( 'Upload Image','illdy' ); ?>" style="margin-top: 5px;">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'position' ); ?>"><?php _e( 'Position:', 'illdy' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'position' ); ?>" name="<?php echo $this->get_field_name( 'position' ); ?>" type="text" value="<?php echo esc_attr( $position ); ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'entry' ); ?>"><?php _e( 'Entry:', 'illdy' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'entry' ); ?>" name="<?php echo $this->get_field_name( 'entry' ); ?>" type="text" value="<?php echo esc_attr( $entry ); ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'facebook_url' ); ?>"><?php _e( 'Facebook URL:', 'illdy' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'facebook_url' ); ?>" name="<?php echo $this->get_field_name( 'facebook_url' ); ?>" type="text" value="<?php echo esc_attr( $facebook_url ); ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'twitter_url' ); ?>"><?php _e( 'Twitter URL:', 'illdy' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'twitter_url' ); ?>" name="<?php echo $this->get_field_name( 'twitter_url' ); ?>" type="text" value="<?php echo esc_attr( $twitter_url ); ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'linkedin_url' ); ?>"><?php _e( 'LinkedIn URL:', 'illdy' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'linkedin_url' ); ?>" name="<?php echo $this->get_field_name( 'linkedin_url' ); ?>" type="text" value="<?php echo esc_attr( $linkedin_url ); ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'color' ); ?>"><?php _e( 'Color:', 'illdy' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>" type="text" value="<?php if( $color ): echo esc_attr( $color ); else: echo '#000000'; endif; ?>" />
            <div class="cw-color-picker" rel="<?php echo $this->get_field_id( 'color' ); ?>"></div>
        </p>
        <?php 
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? esc_html( $new_instance['title'] ) : '';
        $instance['image'] = !empty( $new_instance['image'] ) ? esc_url( $new_instance['image'] ) : '';
        $instance['position'] = ( !empty( $new_instance['position'] ) ) ? esc_html( $new_instance['position'] ) : '';
        $instance['entry'] = ( !empty( $new_instance['entry'] ) ) ? esc_html( $new_instance['entry'] ) : '';
        $instance['facebook_url'] = ( !empty( $new_instance['facebook_url'] ) ? esc_url( $new_instance['facebook_url'] ) : '' );
        $instance['twitter_url'] = ( !empty( $new_instance['twitter_url'] ) ? esc_url( $new_instance['twitter_url'] ) : '' );
        $instance['linkedin_url'] = ( !empty( $new_instance['linkedin_url'] ) ? esc_url( $new_instance['linkedin_url'] ) : '' );
        $instance['color'] = ( !empty( $new_instance['color'] ) ? esc_html( $new_instance['color'] ) : '' );

        return $instance;
    }

}

function illdy_register_widget_person () {
    register_widget( 'Illdy_Widget_Person' );
}
add_action( 'widgets_init', 'illdy_register_widget_person' );

add_action( 'admin_print_scripts-widgets.php', 'illdy_enqueue_script_farbtastic_person' );
function illdy_enqueue_script_farbtastic_person() {
    wp_enqueue_script( 'farbtastic' );
}

add_action( 'admin_print_styles-widgets.php', 'illd_enqueue_style_farbtastic_person' );
function illd_enqueue_style_farbtastic_person() {
    wp_enqueue_style( 'farbtastic' );
}