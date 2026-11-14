<?php
/**
 * Layout: Icon Centered Text
 */

$image    = get_sub_field( 'image' );
$text     = get_sub_field( 'text' );
$image_id = is_array( $image ) ? (int) $image['ID'] : 0;

$colours = developmenttheme_layout_colour_settings( 'icon-centered-text', 'yellow', 'black' );
$classes = array_merge( array( 'icon-centered-text' ), $colours['classes'] );
$styles  = $colours['styles'];
?>

<section class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"<?php echo developmenttheme_layout_settings_attrs( $styles ); ?>>
	<div class="container icon-centered-text__inner">
		<div class="row justify-content-center">
			<div class="col-lg-9 icon-centered-text__content">
				<?php if ( $image_id ) : ?>
					<div class="icon-centered-text__icon">
						<?php echo wp_get_attachment_image( $image_id, 'full', false, array( 'class' => 'icon-centered-text__image', 'loading' => 'lazy' ) ); ?>
					</div>
				<?php endif; ?>
				<?php if ( $text ) : ?>
					<div class="icon-centered-text__text"><?php echo wp_kses_post( $text ); ?></div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
