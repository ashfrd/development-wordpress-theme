<?php
/**
 * Navigation walker for header CTA links.
 *
 * Use wp_nav_menu() with 'depth' => 1 for this menu.
 *
 * @package DevelopmentTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DevelopmentTheme_Header_CTAs_Walker extends Walker_Nav_Menu {

	/**
	 * Render one CTA menu item.
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
		$classes[] = 'mb-xl-0';
		$classes   = apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth );

		$output .= '<li class="' . esc_attr( implode( ' ', array_unique( (array) $classes ) ) ) . '">';

		$is_current = in_array( 'current-menu-item', (array) ( $item->classes ?? array() ), true );
		$title      = apply_filters( 'the_title', $item->title, $item->ID );
		$title      = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

		$item_output = $args->before;
		if ( ! empty( $item->url ) ) {
			$atts         = array(
				'href'         => $item->url,
				'target'       => $item->target ?? '',
				'rel'          => $item->xfn ?? '',
				'class'        => 'button',
				'aria-current' => $is_current ? 'page' : '',
			);
			$atts         = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
			$item_output .= '<a' . $this->build_atts( $atts ) . '>';
			$item_output .= $args->link_before . esc_html( $title ) . $args->link_after;
			$item_output .= '</a>';
		} else {
			$item_output .= '<span>' . $args->link_before . esc_html( $title ) . $args->link_after . '</span>';
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
		$output .= "</li>\n";
	}
}
