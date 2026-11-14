<?php
/**
 * Layout: Text & Image
 */

$layout   = get_sub_field( 'layout' ) ?: 'text_image';
$text     = get_sub_field( 'text' );
$button   = get_sub_field( 'button' );
$image    = get_sub_field( 'image' );
$image_id = is_array( $image ) ? (int) $image['ID'] : 0;

$is_reversed = 'image_text' === $layout;
$modifier    = $is_reversed ? 'text-and-image--image-text' : 'text-and-image--text-image';

$colours = developmenttheme_layout_colour_settings( 'text-and-image', 'white', 'black' );
$classes = array_merge( array( 'text-and-image', $modifier ), $colours['classes'] );
?>

<section class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"<?php echo developmenttheme_layout_settings_attrs( $colours['styles'] ); ?>>
	<div class="container text-and-image__inner">
		<div class="row align-items-center">
			<div class="col-md-6 text-and-image__content<?php echo $is_reversed ? ' order-md-2' : ''; ?>">
				<?php if ( $text ) : ?>
					<div class="text-and-image__text"><?php echo wp_kses_post( $text ); ?></div>
				<?php endif; ?>
				<?php if ( ! empty( $button['url'] ) ) : ?>
					<div class="text-and-image__button">
						<a class="button button--primary" href="<?php echo esc_url( $button['url'] ); ?>"<?php echo ! empty( $button['target'] ) ? ' target="' . esc_attr( $button['target'] ) . '" rel="noopener noreferrer"' : ''; ?>><?php echo esc_html( $button['title'] ?: $button['url'] ); ?></a>
					</div>
				<?php endif; ?>
			</div>
			<div class="col-md-6 text-and-image__media<?php echo $is_reversed ? ' order-md-1' : ''; ?>">
				<?php if ( $image_id ) : ?>
					<?php echo wp_get_attachment_image( $image_id, 'full', false, array( 'class' => 'text-and-image__image', 'loading' => 'lazy' ) ); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
