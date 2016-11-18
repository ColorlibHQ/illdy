<?php


/**
 *
 *
 * @since   1.0.0
 *
 */
if(!function_exists('Illdy_CallEntryMetaClass')) {
    /**
     *
     */
    function Illdy_CallEntryMetaClass()
    {

        // instantiate the class & load everything else
        Illdy_Entry_Meta_Output::getInstance();

    }
    add_action('wp_loaded', 'Illdy_CallEntryMetaClass');
}



if( !class_exists( 'Illdy_Entry_Meta_Output' ) ) {

    class Illdy_Entry_Meta_Output
    {

        /**
         * @var Singleton The reference to *Singleton* instance of this class
         */
        private static $instance;


        protected function __construct() {
            add_action( 'illdy_single_entry_meta', array( $this, 'single_entry_meta_output' ), 1 );
            add_action( 'illdy_archive_meta_content', array( $this, 'archive_entry_meta_output' ), 1 );
            add_action( 'illdy_single_after_content', array( $this, 'single_content_tags' ), 1 );
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
         *  Prints HTML with meta information for the current post-date/time and author on single post.
         */
        public function single_entry_meta_output() {
            global $post;

            $categories_list = get_the_category_list( esc_html__( ', ', 'illdy' ) );
            $number_comments = get_comments_number();

            $display_post_posted_on_meta = get_theme_mod( 'illdy_enable_post_posted_on_blog_posts', 1 );
            $display_number_comments = get_theme_mod( 'illdy_enable_post_comments_blog_posts', 1 );

            if( $display_post_posted_on_meta == 1 ) {
                $output = '';

                 $output .= '<div class="blog-post-meta">';
                    $output .= '<span class="post-meta-author"><i class="fa fa-user"></i>'. esc_html( get_the_author() ) .'</span>';
                    $output .= '<span class="post-meta-time"><i class="fa fa-calendar"></i><time datetime="'. sprintf( '%s-%s-%s', get_the_date( 'Y' ), get_the_date( 'm' ), get_the_date( 'd' ) ) .'">'. sprintf( '%s %s, %s', get_the_date( 'F' ), get_the_date( 'd' ), get_the_date( 'Y' ) ) .'</time></span>';
                    $output .= '<span class="post-meta-categories"><i class="fa fa-folder-o" aria-hidden="true"></i>'.$categories_list.'</span>';
                    $output .= ( ( $display_number_comments == 1 ) ? ( comments_open() ) ? ( $number_comments == 0 ) ? sprintf( '<span class="post-meta-comments"><i class="fa fa-comment-o"></i>'. __( 'No comments', 'illdy' ) .'</span>' ) : ( $number_comments > 1 ) ? sprintf( '<span class="post-meta-comments"><i class="fa fa-comment-o"></i><a class="meta-comments" href="%s" title="%s '. __( 'comments', 'illdy' ) .'">%s '. __( 'comments', 'illdy' ) .'</a></span>', get_comments_link(), $number_comments, $number_comments ) : sprintf( '<span class="post-meta-comments"><i class="fa fa-comment-o"></i><a class="meta-comments" href="%s" title="'. __( '1 comment', 'illdy' ) .'">'. __( '1 comment', 'illdy' ) .'</a></span>', get_comments_link() ) : sprintf( '<span class="post-meta-comments"><i class="fa fa-comment-o"></i>'. __( 'Comments are off for this post', 'illdy' ) .'</span>' ) : '' );
                $output .= '</div><!--/.blog-post-meta-->';

                echo $output;
            }
        }

        /**
         *  Prints HTML with meta information for the current post-date/time and author on archive.
         */
        public function archive_entry_meta_output() {
            global $post;

            $number_comments = get_comments_number();
            $categories_list = get_the_category_list( esc_html__( ', ', 'illdy' ) );
            $post_standard_enable_author = get_theme_mod( 'illdy_post_standard_enable_author', 1 );

            $output = '';

            $output .= '<div class="blog-post-meta">';
                $output .= ( ( $post_standard_enable_author == 1 ) ? '<span class="post-meta-author"><i class="fa fa-user"></i>'. esc_html( get_the_author() ) .'</span>' : '' );
                $output .= '<span class="post-meta-time"><i class="fa fa-calendar"></i><time datetime="'. sprintf( '%s-%s-%s', get_the_date( 'Y' ), get_the_date( 'm' ), get_the_date( 'd' ) ) .'">'. sprintf( '%s %s, %s', get_the_date( 'F' ), get_the_date( 'd' ), get_the_date( 'Y' ) ) .'</time></span>';
                $output .= '<span class="post-meta-categories"><i class="fa fa-folder-o" aria-hidden="true"></i>'.$categories_list.'</span>';
                $output .= ( comments_open() ) ? ( $number_comments == 0 ) ? sprintf( '<span class="post-meta-comments"><i class="fa fa-comment-o"></i>'. __( 'No comments', 'illdy' ) .'</span>' ) : ( $number_comments > 1 ) ? sprintf( '<span class="post-meta-comments"><i class="fa fa-comment-o"></i><a class="meta-comments" href="%s" title="%s '. __( 'comments', 'illdy' ) .'">%s '. __( 'comments', 'illdy' ) .'</a></span>', get_comments_link(), $number_comments, $number_comments ) : sprintf( '<span class="post-meta-comments"><i class="fa fa-comment-o"></i><a class="meta-comments" href="%s" title="'. __( '1 comment', 'illdy' ) .'">'. __( '1 comment', 'illdy' ) .'</a></span>', get_comments_link() ) : sprintf( '<span class="post-meta-comments"><i class="fa fa-comment-o"></i>'. __( 'Comments are off for this post', 'illdy' ) .'</span>' );
            $output .= '</div><!--/.blog-post-meta-->';

            echo $output;
        }

        /**
         *  Prints HTML with tags on single post.
         */
        public function single_content_tags() {
            $display_tags_post_meta  = get_theme_mod( 'illdy_enable_post_tags_blog_posts', 1 );

            $output = '';

            if( $display_tags_post_meta == 1 ) {
                if( get_the_tag_list() ) {
                    $output .= '<ul class="blog-post-tags">';
                        $output .= '<li>'. __( 'Tags: ', 'illdy' ) .'</li>';
                        $output .= get_the_tag_list( '<li>','</li>, <li>','</li>' );
                    $output .= '</ul><!--/.blog-post-tags-->';
                }
            }

            echo $output;
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
    }
}