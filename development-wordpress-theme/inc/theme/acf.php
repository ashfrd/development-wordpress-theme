<?php
/*
* Name ACF JSON files using the title and unique item key.
*/
add_filter(
	'acf/json/save_file_name',
	function ( $filename, $post, $load_path ) {
		$title = sanitize_title( $post['title'] ?? '' );
		$key   = sanitize_file_name( $post['key'] ?? '' );

		if ( $title === '' || $key === '' ) {
			return $filename;
		}

		return $title . '_' . $key . '.json';
	},
	10,
	3
);
