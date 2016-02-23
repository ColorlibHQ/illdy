<?php
class Illdy_Widget_Project extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct( 'illdy_project', __( '[Illdy] - Project', 'illdy' ), array( 'description' => __( 'Add this widget in "Front page - Projects Sidebar".', 'illdy' ), ) );

        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
    }

    /**
     *  Enqueue Scripts
     */
    public function enqueue_scripts() {
        wp_enqueue_media();
        wp_enqueue_script( 'illdy-widget-upload-image', get_template_directory_uri() . '/layout/js/widget-upload-image/widget-upload-image.js', false, '1.0', true);
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
        $url = !empty( $instance['url'] ) ? sanitize_text_field( $instance['url'] ) : esc_url( '#' );

        $image_id = illdy_get_image_id_from_image_url( $image );
        $get_attachment_image_src = wp_get_attachment_image_src( $image_id, 'illdy-front-page-projects' );

        $output = '<a href="'. $url .'" title="'. $title .'" class="project" style="background-image: url('. ( $image_id ? esc_url( $get_attachment_image_src[0] ) : get_template_directory_uri() . $image ) .');"><span class="project-overlay"></span></a>';

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
        $title = ! empty( $instance['title'] ) ? sanitize_text_field( $instance['title'] ) : __( '[Illdy] - Project', 'illdy' );
        $image = !empty( $instance['image'] ) ? esc_url( $instance['image'] ) : '';
        $url = !empty( $instance['url'] ) ? sanitize_text_field( $instance['url'] ) : esc_url( '#' );
        ?>
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
            <label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e( 'URL:', 'illdy' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>">
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
        $instance['url'] = ( !empty( $new_instance['url'] ) ? esc_url( $new_instance['url'] ) : '' );

        return $instance;
    }

}

function illdy_register_widget_project () {
    register_widget( 'Illdy_Widget_Project' );
}
add_action( 'widgets_init', 'illdy_register_widget_project' );