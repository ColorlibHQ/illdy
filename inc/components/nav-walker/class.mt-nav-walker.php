<?php

/**
 * Class Illdy_Extended_Menu_Walker
 *
 * This file does the color handling of the navmenu walker for the Muscle Core Lite Framework
 */


if(!class_exists('Illdy_Extended_Menu_Walker') ) {
    /**
     * My extended menu walker
     * Supports separators as "ex_separator" arg to wp_nav_menu call
     */
    class Illdy_Extended_Menu_Walker extends Walker_Nav_Menu
    {
        var $db_fields = array('parent' => 'menu_item_parent', 'id' => 'db_id');

        function start_lvl(&$output, $depth = 0, $args = array())
        {
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<ul class='sub-menu'>\n";
        }

        function end_lvl(&$output, $depth = 0, $args = array())
        {
            $indent = str_repeat("\t", $depth);
            $output .= "$indent</ul>\n";
        }

        function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
        {

            global $wp_query;
            $indent = ($depth) ? str_repeat("\t", $depth) : '';
            $class_names = $value = '';
            $classes = empty($item->classes) ? array() : (array)$item->classes;

            /* Add active class */
            if (in_array('current-menu-item', $classes)) {
                $classes[] = 'active';
                unset($classes['current-menu-item']);
            }

            /* Check for children */
            $children = get_posts(array(
                'post_type' => 'nav_menu_item',
                'nopaging' => true,
                'numberposts' => 1,
                'meta_key' => '_menu_item_menu_item_parent',
                'meta_value' => $item->ID)
            );


            if (!empty($children)) {
                $classes[] = 'has-sub';
            }

            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

            $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
            $id = $id ? ' id="' . esc_attr($id) . '"' : '';

            $output .= $indent . '<li' . $id . $value . $class_names . '>';

            $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
            $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
            $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
            $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

            $item_output = $args->before;
            $item_output .= '<a' . $attributes . '><span>';
            $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
            $item_output .= '</span></a>';
            $item_output .= $args->after;

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }

        function end_el(&$output, $item, $depth = 0, $args = array())
        {
            $output .= "</li>\n";
        }

        /**
         * Menu Fallback
         * =============
         * If this function is assigned to the wp_nav_menu's fallback_cb variable
         * and a manu has not been assigned to the theme location in the WordPress
         * menu manager the function with display nothing to a non-logged in user,
         * and will add a link to the WordPress menu manager if logged in as an admin.
         *
         * @param array $args passed from the wp_nav_menu function.
         *
         */
        public static function fallback( $args = array() ) {

            extract( $args );

            $fb_output = null;
            if ( $container ) {
                $fb_output = '<' . $container;
                if ( $container_id )
                    $fb_output .= ' id="' . $container_id . '"';
                if ( $container_class )
                    $fb_output .= ' class="' . $container_class . '"';
                $fb_output .= '>';
            }
            if ( $menu_id )
                $fb_output .= ' id="' . $menu_id . '"';
            if ( $menu_class )
                $fb_output .= ' class="' . $menu_class . '"';
            $fb_output .= '<li><a href="' . admin_url( 'nav-menus.php' ) . '">'. __('Add a menu', 'illdy'). '</a></li>';
            if ( $container )
                $fb_output .= '</' . $container . '>';
            echo $fb_output;
            
        }


    }
}