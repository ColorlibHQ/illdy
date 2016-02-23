<?php
class Illdy_Widget_Counter extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct( 'illdy_counter', __( '[Illdy] - Counter', 'illdy' ), array( 'description' => __( 'Add this widget in "Front page - Counter Sidebar".', 'illdy' ), ) );
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
        $data_from = ( !empty( $instance['data_from'] ) ? absint( $instance['data_from'] ) : '' );
        $data_to = ( !empty( $instance['data_to'] ) ? absint( $instance['data_to'] ) : '' );
        $data_speed = ( !empty( $instance['data_speed'] ) ? absint( $instance['data_speed'] ) : '' );
        $data_refresh_interval = ( !empty( $instance['data_refresh_interval'] ) ? absint( $instance['data_refresh_interval'] ) : '' );

        $output = '';

        $output .= '<span class="counter-number" data-from="'. $data_from .'" data-to="'. $data_to .'" data-speed="'. $data_speed .'" data-refresh-interval="'. $data_refresh_interval .'"></span>';
        $output .= '<span class="counter-description">'. $title .'</span>';

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
        $title = ! empty( $instance['title'] ) ? esc_html( $instance['title'] ) : __( '[Illdy] - Recent Posts', 'illdy' );
        $data_from = ! empty( $instance['data_from'] ) ? absint( $instance['data_from'] ) : esc_html__( '1', 'illdy' );
        $data_to = ! empty( $instance['data_to'] ) ? absint( $instance['data_to'] ) : esc_html__( '260', 'illdy' );
        $data_speed = ! empty( $instance['data_speed'] ) ? absint( $instance['data_speed'] ) : esc_html__( '2000', 'illdy' );
        $data_refresh_interval = ! empty( $instance['data_refresh_interval'] ) ? absint( $instance['data_refresh_interval'] ) : esc_html__( '100', 'illdy' );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'illdy' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'data_from' ); ?>"><?php _e( 'Data from:', 'illdy' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'data_from' ); ?>" name="<?php echo $this->get_field_name( 'data_from' ); ?>" type="number" value="<?php echo esc_attr( $data_from ); ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'data_to' ); ?>"><?php _e( 'Data to:', 'illdy' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'data_to' ); ?>" name="<?php echo $this->get_field_name( 'data_to' ); ?>" type="number" value="<?php echo esc_attr( $data_to ); ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'data_speed' ); ?>"><?php _e( 'Data speed:', 'illdy' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'data_speed' ); ?>" name="<?php echo $this->get_field_name( 'data_speed' ); ?>" type="number" value="<?php echo esc_attr( $data_speed ); ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'data_refresh_interval' ); ?>"><?php _e( 'Data speed:', 'illdy' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'data_refresh_interval' ); ?>" name="<?php echo $this->get_field_name( 'data_refresh_interval' ); ?>" type="number" value="<?php echo esc_attr( $data_refresh_interval ); ?>">
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
        $instance['data_from'] = ( !empty( $new_instance['data_from'] ) ) ? absint( $new_instance['data_from'] ) : '';
        $instance['data_to'] = ( !empty( $new_instance['data_to'] ) ) ? absint( $new_instance['data_to'] ) : '';
        $instance['data_speed'] = ( !empty( $new_instance['data_speed'] ) ) ? absint( $new_instance['data_speed'] ) : '';
        $instance['data_refresh_interval'] = ( !empty( $new_instance['data_refresh_interval'] ) ) ? absint( $new_instance['data_refresh_interval'] ) : '';

        return $instance;
    }

}

function illdy_register_widget_counter () {
    register_widget( 'Illdy_Widget_Counter' );
}
add_action( 'widgets_init', 'illdy_register_widget_counter' );