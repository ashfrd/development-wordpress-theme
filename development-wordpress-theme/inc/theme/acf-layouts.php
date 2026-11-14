<?php
/**
 * Convert an ACF layout name to its template directory.
 *
 * Handles existing layout names containing underscores or ampersands.
 */
function developmenttheme_acf_layout_folder( $layout ) {
    $folder = str_replace(
        array( '_&_', '_' ),
        array( '-and-', '-' ),
        $layout
    );

    return sanitize_title( $folder );
}

/**
 * Resolve a layout's Background/Text Colour fields into modifier classes and inline styles.
 * Palette choices become `{$base}--bg-*` / `{$base}--text-*` classes; "custom" becomes an inline colour.
 *
 * @param string $base       BEM block name of the layout.
 * @param string $default_bg Background used when the field is empty.
 * @param string $default_txt Text colour used when the field is empty.
 * @return array{classes: string[], styles: string[]}
 */
function developmenttheme_layout_colour_settings( $base, $default_bg = 'yellow', $default_txt = 'black' ) {
  $bg  = get_sub_field( 'background_colour' ) ?: $default_bg;
  $txt = get_sub_field( 'text_colour' ) ?: $default_txt;

  $classes = array();
  $styles  = array();

  if ( 'custom' === $bg ) {
    $custom_bg = sanitize_hex_color( (string) get_sub_field( 'custom_background_colour' ) );
    if ( $custom_bg ) {
      $styles[] = 'background-color:' . $custom_bg;
    }
  } elseif ( in_array( $bg, array( 'white', 'yellow', 'red', 'blue', 'black', 'grey' ), true ) ) {
    $classes[] = $base . '--bg-' . $bg;
  }

  if ( 'custom' === $txt ) {
    $custom_txt = sanitize_hex_color( (string) get_sub_field( 'custom_text_colour' ) );
    if ( $custom_txt ) {
      $styles[] = 'color:' . $custom_txt;
    }
  } elseif ( in_array( $txt, array( 'white', 'black' ), true ) ) {
    $classes[] = $base . '--text-' . $txt;
  }

  return array( 'classes' => $classes, 'styles' => $styles );
}

/**
 * Build the id/style attributes from a layout's Settings fields (Custom ID, Padding Top/Bottom).
 * Padding is output inline so it only overrides the default styles for this one instance.
 *
 * @param string[] $styles Extra inline declarations to merge in (e.g. 'color:#fff').
 * @return string Attribute string with a leading space, or an empty string.
 */
function developmenttheme_layout_settings_attrs( $styles = array() ) {
  $attrs = '';
  $id    = sanitize_html_class( (string) get_sub_field( 'custom_id' ) );

  if ( '' !== $id ) {
    $attrs .= ' id="' . esc_attr( $id ) . '"';
  }

  foreach ( array( 'padding_top' => 'padding-top', 'padding_bottom' => 'padding-bottom' ) as $field => $property ) {
    $value = get_sub_field( $field );

    if ( is_numeric( $value ) ) {
      $styles[] = $property . ':' . (float) $value . 'px';
    }
  }

  if ( $styles ) {
    $attrs .= ' style="' . esc_attr( implode( ';', $styles ) ) . '"';
  }

  return $attrs;
}


/**
 * Render every row of a flexible content field using its layout folder.
 *
 * Layout folders are resolved automatically from ACF layout names.
 *
 * @param string $field ACF flexible content field name.
 * @return void
 */
function developmenttheme_render_flexible_layouts( $field = 'flexible_column' ) {

    if ( ! function_exists( 'have_rows' ) || ! have_rows( $field ) ) {
        return;
    }

    while ( have_rows( $field ) ) {
        the_row();

        $layout = get_row_layout();

        if ( ! is_string( $layout ) || '' === $layout ) {
            continue;
        }

        $folder = developmenttheme_acf_layout_folder( $layout );

        if ( '' === $folder ) {
            continue;
        }

        get_template_part( 'acf-layouts/' . $folder . '/output' );
    }
}
