<?php
/**
 * Fallback template for posts and pages.
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
		<?php the_content(); ?>
	<?php endwhile; ?>
</main>

<?php get_footer(); ?>
