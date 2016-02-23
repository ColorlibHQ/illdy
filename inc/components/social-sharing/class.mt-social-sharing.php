<?php
/**
 * Class MTL_Social_Sharing_Output
 *
 * This file does the social sharing handling for the Muscle Core Lite Framework
 *
 * @author		Cristian Raiber
 * @copyright	(c) Copyright by Macho Themes
 * @link		http://www.machothemes.com
 * @package 	Muscle Core Lite
 * @since		Version 1.0.0
 */


/**
 *
 * Gets called only if the "display social media options" option is checked
 * in the back-end
 *
 * @since   1.0.0
 *
 */
if(!function_exists('MTL_CallSocialMediaClass')) {
    function MTL_CallSocialMediaClass()
    {
        $display_social_sharing = get_theme_mod( 'illdy_enable_social_sharing_blog_posts', 1 );
        if ($display_social_sharing == 1) {
            // instantiate the class & load everything else
            MTL_Social_Sharing_Output::getInstance();
        }
    }
    add_action('wp_loaded', 'MTL_CallSocialMediaClass');
}



if( !class_exists( 'MTL_Social_Sharing_Output' ) ) {

    class MTL_Social_Sharing_Output
    {

        /**
         * @var Singleton The reference to *Singleton* instance of this class
         */
        private static $instance;


        protected function __construct() {
            add_action( 'mtl_single_after_content', array( $this, 'output_social_sharing_box' ), 2 );
        }

        /**
         * Returns the *Singleton* instance of this class.
         *
         * @return Singleton The *Singleton* instance.
         */
        public static function getInstance()
        {
            if (null === static::$instance) {
                static::$instance = new static();
            }

            return static::$instance;
        }

        /**
         * Private clone method to prevent cloning of the instance of the
         * *Singleton* instance.
         *
         * @return void
         */
        private function __clone()
        {
        }

        /**
         * Private unserialize method to prevent unserializing of the *Singleton*
         * instance.
         *
         * @return void
         */
        private function __wakeup()
        {
        }


        /**
         * Set up the array for sharing box social networks.
         *
         * @return array  The social links array containing the social media and links to them.
         */

        function output_social_sharing_box() {
            global $post;

            $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'illdy-blog-list' );
            $facebook_visibility = get_theme_mod( 'illdy_facebook_visibility', 1 );
            $twitter_visibility = get_theme_mod( 'illdy_twitter_visibility', 1 );
            $linkein_visibility = get_theme_mod( 'illdy_linkein_visibility', 1 );

            $output = '';

            $output .= '<ul class="social-links-list clearfix">';
                $output .= '<li class="links-list-title">Share on: </li>';
                $output .= ( $twitter_visibility == 1 ) ? '<li data-customizer="twitter"><a href="https://twitter.com/share?url='. esc_url( get_the_permalink() ) .'&amp;related='. esc_attr( get_the_author() ) .'&amp;text='. get_the_title() .'" title="'. __( 'Twitter', 'illdy' ) .'" onclick="return !window.open(this.href, \'Facebook\', \'width=500, height=500\')" target="_blank"><i class="fa fa-twitter"></i></a></li>' : '';
                $output .= ( $facebook_visibility == 1 ) ? ( $featured_image ) ? '<li data-customizer="facebook"><a href="http://www.facebook.com/sharer/sharer.php?s=100&p[url]='. esc_url( get_the_permalink() ) .'&p[images][0]='. esc_url( $featured_image[0] ) .'&p[title]='. esc_attr( get_the_title() ) .'&p[summary]='. get_the_excerpt() .'" title="'. __( 'Facebook', 'illdy' ) .'" onclick="return !window.open(this.href, \'Facebook\', \'width=500, height=500\')" target="_blank"><i class="fa fa-facebook"></i></a></li>' : '<li data-customizer="facebook"><a href="http://www.facebook.com/sharer/sharer.php?s=100&p[url]='. esc_url( get_the_permalink() ) .'&p[title]='. esc_attr( get_the_title() ) .'&p[summary]='. get_the_excerpt() .'" title="'. __( 'Facebook', 'illdy' ) .'" onclick="return !window.open(this.href, \'Facebook\', \'width=500, height=500\')" target="_blank"><i class="fa fa-facebook"></i></a></li>' : '';
                $output .= ( $linkein_visibility == 1 ) ? '<li data-customizer="linkedin"><a href="http://www.linkedin.com/shareArticle?mini=true&url='. esc_url( get_the_permalink() ) .'&title='. esc_attr( get_the_title() ) .'&source='. esc_attr( get_the_permalink() ) .'" title="'. __( 'LinkedIn', 'illdy' ) .'" onclick="return !window.open(this.href, \'Facebook\', \'width=500, height=500\')" target="_blank"><i class="fa fa-linkedin"></i></a></li>' : '';
            $output .= '</ul><!--/.social-links-list.clearfix-->';

            echo $output;
        }
    }
}