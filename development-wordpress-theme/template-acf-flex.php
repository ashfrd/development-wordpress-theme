<?php
/**
 * Template Name: ACF Flexible Content
 *
 * Renders flexible content layouts configured in ACF.
 *
 * @package DevelopmentTheme
 */

?>


<?php get_header(); ?>

<main id="main-content" role="main">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<?php if ( function_exists( 'have_rows' ) && have_rows( 'flexible_column' ) ) : ?>
			<?php developmenttheme_render_flexible_layouts( 'flexible_column' ); ?>
		<?php else : ?>
		<div class="page-content">
			<div class="container">
			<div class="row justify-content-center">
				<div class="col-12 page-content__content">
						<?php the_content(); ?>
				</div>
			</div>
			</div>
		</div>
		<?php endif; ?>
	<?php endwhile; ?>
</main>

<?php get_footer(); ?>
