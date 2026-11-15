<?php
/**
 * Front-end asset loading for the theme.
 *
 * @package DevelopmentTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DevelopmentTheme_Asset_Loader {

	public function __construct() {
		add_action(
			'wp_enqueue_scripts',
			array( $this, 'enqueue_assets' )
		);
	}

	public function enqueue_assets() {

		$css_file = 'assets/build/css/theme.min.css';
		$css_path = get_theme_file_path( $css_file );

		if ( file_exists( $css_path ) ) {
			wp_enqueue_style(
				'developmenttheme-style',
				get_theme_file_uri( $css_file ),
				array(),
				(string) filemtime( $css_path )
			);
		}

		$js_file = 'assets/build/js/theme.min.js';
		$js_path = get_theme_file_path( $js_file );

		if ( file_exists( $js_path ) ) {
			wp_enqueue_script(
				'developmenttheme-script',
				get_theme_file_uri( $js_file ),
				array(),
				(string) filemtime( $js_path ),
				array(
					'in_footer' => true,
					'strategy'  => 'defer',
				)
			);
		}
	}
}

new DevelopmentTheme_Asset_Loader();
