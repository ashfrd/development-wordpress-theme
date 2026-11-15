<?php
/**
 * Footer navigation walker.
 *
 * @package DevelopmentTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DevelopmentTheme_Footer_Walker extends Walker_Nav_Menu {

	/**
	 * Open a footer submenu.
	 *
	 * @param string   $output Output HTML, passed by reference.
	 * @param int      $depth  Current menu depth.
	 * @param stdClass $args   Menu arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$class   = 0 === $depth ? 'submenu' : 'sub-submenu';
		$output .= '<ul class="' . esc_attr( $class ) . '">';
	}

	/**
	 * Close a footer submenu.
	 *
	 * @param string   $output Output HTML, passed by reference.
	 * @param int      $depth  Current menu depth.
	 * @param stdClass $args   Menu arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '</ul>';
	}

	/**
	 * Render a footer menu item.
	 *
	 * @param string   $output            Output HTML, passed by reference.
	 * @param WP_Post  $data_object       Menu item.
	 * @param int      $depth             Item depth.
	 * @param stdClass $args              Menu arguments.
	 * @param int      $current_object_id Unused.
	 */
	public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		$item      = $data_object;
		$classes   = (array) ( $item->classes ?? array() );
		$classes[] = 'font-aptos';
		$classes   = apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth );

		$output .= str_repeat( "\t", $depth ) . '<li class="' . esc_attr( implode( ' ', array_unique( (array) $classes ) ) ) . '">';

		$title      = apply_filters( 'the_title', $item->title, $item->ID );
		$title      = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
		$is_current = in_array( 'current-menu-item', (array) ( $item->classes ?? array() ), true );

		$item_output = $args->before;
		if ( ! empty( $item->url ) ) {
			$atts         = array(
				'href'         => $item->url,
				'target'       => $item->target ?? '',
				'rel'          => $item->xfn ?? '',
				'aria-current' => $is_current ? 'page' : '',
			);
			$atts         = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
			$item_output .= '<a' . $this->build_atts( $atts ) . '>';
			$item_output .= $args->link_before . esc_html( $title ) . $args->link_after;
			$item_output .= '</a>';
		} else {
			$item_output .= '<span class="label">';
			$item_output .= $args->link_before . esc_html( $title ) . $args->link_after;
			$item_output .= '</span>';
		}
		$item_output .= $args->after;
		$output      .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Close one menu item.
	 *
	 * @param string   $output Output HTML, passed by reference.
	 * @param WP_Post  $item   Menu item.
	 * @param int      $depth  Item depth.
	 * @param stdClass $args   Menu arguments.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= '</li>';
	}
}
