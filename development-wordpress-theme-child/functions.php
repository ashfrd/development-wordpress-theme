<?php
/**
 * Functions and setup for the Development Theme child theme.
 *
 * @package DevelopmentThemeChild
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Load ACF field groups from the parent theme.
 *
 * ACF automatically loads JSON from the active child theme.
 * This also includes field groups defined by the parent.
 *
 * @param array $paths Existing ACF JSON load paths.
 * @return array
 */
function devthemechild_acf_json_load_paths( $paths ) {
    $parent_path = get_template_directory() . '/acf-json';

    if ( is_dir( $parent_path ) && ! in_array( $parent_path, $paths, true ) ) {
        $paths[] = $parent_path;
    }

    return $paths;
}
add_filter( 'acf/settings/load_json', 'devthemechild_acf_json_load_paths' );

/**
 * Route ACF JSON saves to the appropriate theme.
 *
 * Standard field groups: Parent theme.
 * ACF block field groups: Child theme.
 *
 * @param array $paths Available JSON save paths.
 * @param array $post  ACF field group settings.
 * @return array
 */
function devthemechild_acf_json_save_paths( $paths, $post ) {

    // Only modify field group save locations.
    if ( empty( $post['key'] ) || 0 !== strpos( $post['key'], 'group_' ) ) {
        return $paths;
    }

    $is_block_group = false;

    // Check whether the field group targets an ACF block.
    foreach ( $post['location'] ?? array() as $rule_group ) {
        foreach ( $rule_group as $rule ) {
            if ( isset( $rule['param'] ) && 'block' === $rule['param'] ) {
                $is_block_group = true;
                break 2;
            }
        }
    }

    if ( $is_block_group ) {
        // ACF block field groups belong to the child theme.
        return array( get_stylesheet_directory() . '/acf-json' );
    }

    // All other field groups belong to the parent theme.
    return array( get_template_directory() . '/acf-json' );
}
add_filter( 'acf/json/save_paths', 'devthemechild_acf_json_save_paths', 10, 2 );

/**
 * Register custom ACF blocks.
 *
 * Requires ACF Pro.
 */
function devthemechild_register_acf_blocks() {

    if ( ! function_exists( 'acf' ) ) {
        return;
    }

    register_block_type(
        get_stylesheet_directory() . '/blocks/testimonial'
    );
}
add_action( 'init', 'devthemechild_register_acf_blocks', 5 );
