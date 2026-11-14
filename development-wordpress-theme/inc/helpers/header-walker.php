<?php
/**
 * Primary navigation walker.
 *
 * Supports the theme's top-level navigation and one dropdown level.
 * Render the menu using wp_nav_menu() with 'depth' => 2.
 *
 * @package DevelopmentTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class DevelopmentTheme_Header_Walker extends Walker_Nav_Menu {

    /**
     * Open a submenu.
     *
     * @param string   $output Output HTML, passed by reference.
     * @param int      $depth  Current menu depth.
     * @param stdClass $args   Menu arguments.
     */
    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $output .= "\n" . str_repeat( "\t", $depth + 1 ) . '<ul class="dropdown-menu">' . "\n";
    }

    /**
     * Close a submenu.
     *
     * @param string   $output Output HTML, passed by reference.
     * @param int      $depth  Current menu depth.
     * @param stdClass $args   Menu arguments.
     */
    public function end_lvl( &$output, $depth = 0, $args = null ) {
        $output .= str_repeat( "\t", $depth + 1 ) . "</ul>\n";
    }

    /**
     * Render one menu item.
     *
     * @param string   $output            Output HTML, passed by reference.
     * @param WP_Post  $data_object       Menu item.
     * @param int      $depth             Item depth.
     * @param stdClass $args              Menu arguments.
     * @param int      $current_object_id Unused.
     */
    public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
        $item     = $data_object;
        $classes  = (array) ( $item->classes ?? array() );
        $is_parent = in_array( 'menu-item-has-children', $classes, true );
        $is_current = in_array( 'current-menu-item', $classes, true );

        if ( 0 === $depth ) {
            $classes = array_merge( $classes, array( 'nav-item', 'ps-2', 'ps-md-0', 'ms-0', 'ms-md-4', 'mb-0' ) );
        } else {
            $classes[] = 'submenu-item';
        }

        $classes = apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth );
        $class_names = implode( ' ', array_unique( (array) $classes ) );
        $output .= str_repeat( "\t", $depth ) . '<li class="' . esc_attr( $class_names ) . '">';

        $link_classes = 0 === $depth ? 'nav-link' : 'dropdown-item text-decoration-none';
        if ( $is_parent && 0 === $depth ) {
            $link_classes .= ' dropdown-toggle';
        }
        if ( $is_current ) {
            $link_classes .= ' active';
        }

        $title = apply_filters( 'the_title', $item->title, $item->ID );
        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
        $item_output = $args->before;

        if ( ! empty( $item->url ) ) {
            $atts = array(
                'href'         => $item->url,
                'target'       => $item->target ?? '',
                'rel'          => $item->xfn ?? '',
                'class'        => $link_classes,
                'aria-current' => $is_current ? 'page' : '',
            );
            $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
            $item_output .= '<a' . $this->build_atts( $atts ) . '>';
            $item_output .= $args->link_before . esc_html( $title ) . $args->link_after;
            $item_output .= '</a>';
        } else {
            // A no-URL label is not an interactive submenu toggle.
            // Use a separate disclosure button if the layout needs one.
            $item_output .= '<span class="' . esc_attr( $link_classes ) . '">';
            $item_output .= $args->link_before . esc_html( $title ) . $args->link_after;
            $item_output .= '</span>';
        }

        $item_output .= $args->after;
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    /**
     * Close each menu item at every depth.
     *
     * @param string   $output Output HTML, passed by reference.
     * @param WP_Post  $item   Menu item.
     * @param int      $depth  Item depth.
     * @param stdClass $args   Menu arguments.
     */
    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= "</li>\n";
    }
}
