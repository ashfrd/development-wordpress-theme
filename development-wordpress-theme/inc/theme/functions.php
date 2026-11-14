<?php

// Include parent page titles in the admin Pages list.

add_filter('the_title', function($title, $post_id) {
    if (!is_admin()) return $title;

    $screen = function_exists('get_current_screen') ? get_current_screen() : null;

    if ($screen && $screen->id === 'edit-page') {
        $post = get_post($post_id);

        if ($post && $post->post_parent) {
            $parent = get_post($post->post_parent);
            if ($parent) {
                return $parent->post_title . ' > ' . $title;
            }
        }
    }

    return $title;
}, 10, 2);

// Disable random content redirect in WordPress admin (added in WordPress 7.2+)

add_filter( 'wp_enable_random_content_redirect', '__return_false' );
