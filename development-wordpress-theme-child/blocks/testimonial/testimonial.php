<?php
/**
 * Testimonial block render template.
 *
 * @package DevelopmentThemeChild
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$quote            = get_field( 'quote' );
$author           = get_field( 'author' );
$author_role      = get_field( 'role' );
$image            = get_field( 'image' );
$background_color = sanitize_hex_color( (string) get_field( 'background_color' ) );
$text_color       = sanitize_hex_color( (string) get_field( 'text_color' ) );

if ( ! is_string( $quote ) || '' === trim( $quote ) ) {
    $quote = __( 'Your quote here...', 'developmenttheme' );
}

$classes = array( 'testimonial' );

if ( ! empty( $block['className'] ) && is_string( $block['className'] ) ) {
    $custom_classes = preg_split( '/\s+/', trim( $block['className'] ) );
    $classes        = array_merge( $classes, array_map( 'sanitize_html_class', $custom_classes ) );
}

if ( ! empty( $block['align'] ) && is_string( $block['align'] ) ) {
    $classes[] = sanitize_html_class( 'align' . $block['align'] );
}

$styles = array();

if ( $background_color ) {
    $styles[] = 'background-color: ' . $background_color;
}

if ( $text_color ) {
    $styles[] = 'color: ' . $text_color;
}

if ( $styles ) {
    $classes[] = 'has-custom-acf-color';
}

$classes = array_filter( array_unique( $classes ) );
$anchor  = ! empty( $block['anchor'] ) && is_string( $block['anchor'] ) ? $block['anchor'] : '';
?>

<div
    <?php if ( $anchor ) : ?>
        id="<?php echo esc_attr( $anchor ); ?>"
    <?php endif; ?>
    class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"
    <?php if ( $styles ) : ?>
        style="<?php echo esc_attr( implode( '; ', $styles ) ); ?>"
    <?php endif; ?>
>
    <div class="testimonial__col">
        <blockquote class="testimonial__blockquote">
            <?php echo wpautop( esc_html( $quote ) ); ?>

            <?php if ( is_string( $author ) && '' !== trim( $author ) ) : ?>
                <footer class="testimonial__attribution">
                    <cite class="testimonial__author"><?php echo esc_html( $author ); ?></cite>

                    <?php if ( is_string( $author_role ) && '' !== trim( $author_role ) ) : ?>
                        <span class="testimonial__role"><?php echo esc_html( $author_role ); ?></span>
                    <?php endif; ?>
                </footer>
            <?php endif; ?>
        </blockquote>
    </div>

    <?php if ( is_array( $image ) && ! empty( $image['ID'] ) ) : ?>
        <div class="testimonial__col">
            <figure class="testimonial__image">
                <?php
                echo wp_get_attachment_image(
                    absint( $image['ID'] ),
                    'full',
                    false,
                    array( 'class' => 'testimonial__img' )
                );
                ?>
            </figure>
        </div>
    <?php endif; ?>
</div>
