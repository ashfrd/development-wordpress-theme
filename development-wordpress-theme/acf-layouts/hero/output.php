<?php
/**
 * Layout: Hero
 */

$text   = get_sub_field( 'text' );
$image  = get_sub_field( 'image' );
$layout = get_sub_field( 'layout' ) ?: 'centered_image';

$modifier = 'hero--' . sanitize_html_class( str_replace( '_', '-', $layout ) );
$image_id = is_array( $image ) ? (int) $image['ID'] : 0;
?>

<section class="hero <?php echo esc_attr( $modifier ); ?>"<?php echo developmenttheme_layout_settings_attrs(); ?>>

	<?php if ( 'centered_bg' === $layout ) : ?>

		<?php if ( $image_id ) : ?>
			<?php echo wp_get_attachment_image( $image_id, 'full', false, array( 'class' => 'hero__bg', 'loading' => 'eager', 'alt' => '' ) ); ?>
		<?php endif; ?>

		<div class="container hero__inner">
			<div class="row justify-content-center">
				<div class="col-lg-11 hero__content">
					<?php if ( $text ) : ?>
						<div class="hero__text"><?php echo wp_kses_post( $text ); ?></div>
					<?php endif; ?>
				</div>
			</div>
		</div>

	<?php elseif ( 'text_image' === $layout ) : ?>

		<div class="container hero__inner">
			<div class="row align-items-center">
				<div class="col-lg-6 hero__content">
					<?php if ( $text ) : ?>
						<div class="hero__text"><?php echo wp_kses_post( $text ); ?></div>
					<?php endif; ?>
				</div>
				<div class="col-lg-6 hero__media">
					<?php if ( $image_id ) : ?>
						<?php echo wp_get_attachment_image( $image_id, 'full', false, array( 'class' => 'hero__image', 'loading' => 'eager' ) ); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>

	<?php else : ?>

		<div class="container hero__inner">
			<div class="row justify-content-center">
				<div class="col-lg-11 hero__content">
					<?php if ( $text ) : ?>
						<div class="hero__text"><?php echo wp_kses_post( $text ); ?></div>
					<?php endif; ?>
				</div>
			</div>
			<?php if ( $image_id ) : ?>
				<div class="row justify-content-center">
					<div class="col-lg-10 hero__media">
						<?php echo wp_get_attachment_image( $image_id, 'full', false, array( 'class' => 'hero__image', 'loading' => 'eager' ) ); ?>
					</div>
				</div>
			<?php endif; ?>
		</div>

	<?php endif; ?>

</section>
