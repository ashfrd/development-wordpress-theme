<?php
/**
 * Development theme functions.
 *
 *  @package DevelopmentTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function developmenttheme_setup() {
	load_theme_textdomain(
		'developmenttheme',
		get_template_directory() . '/languages'
	);

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style',
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'developmenttheme' ),
			'footer'  => __( 'Footer Menu', 'developmenttheme' ),
		)
	);
}
add_action( 'after_setup_theme', 'developmenttheme_setup' );

require_once get_template_directory() . '/inc/init.php';
