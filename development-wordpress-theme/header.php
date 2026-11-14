<?php
/**
 * The template for displaying the header.
 *
 * Contains the opening HTML tags and header navigation.
 *
 * @package DevelopmentTheme
 */

?>
<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>

	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<?php wp_body_open(); ?>

		<a href="#main-content" class="skip-link" style="position: absolute; top: -1000px;" tabindex="0" aria-label="skip to main content">Skip to main content</a>
		<a href="#footer-menu" class="skip-link" style="position: absolute; top: -100px;" tabindex="0" aria-label="Skip to footer">Skip to footer</a>

		<?php get_template_part( 'templates/navigation/header' ); ?>
