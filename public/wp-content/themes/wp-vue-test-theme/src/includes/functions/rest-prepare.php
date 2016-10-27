<?php

// USE PLUGIN FOR CUSTOM FIELDS WITH ACF
// https://wordpress.org/plugins/acf-to-rest-api/


function rest_prepare( $data, $post, $request ) {

	$_data = $data->data;

// Next/Prev Post
	//Arguments: (in same term, exclude IDs, previous, taxonomy term)
	$prevPost = get_adjacent_post(false, '', false);
	$prevPost = $prevPost->ID;
	$nextPost = get_adjacent_post(false, '', true);
	$nextPost = $nextPost->ID;

	$_data['prev_post'] = $prevPost;
	$_data['next_post'] = $nextPost;

// Thumbnails
	$thumbnail_id = get_post_thumbnail_id( $post->ID );
	$thumbnail = wp_get_attachment_image_src( $thumbnail_id );
	$thumbnail_small = wp_get_attachment_image_src( $thumbnail_id, 'size-small' );
	$thumbnail_medium = wp_get_attachment_image_src( $thumbnail_id, 'size-medium' );
	$thumbnail_large = wp_get_attachment_image_src( $thumbnail_id, 'size-large' );

	$_data['thumbnail_url'] = $thumbnail[0];
	$_data['thumbnail_url_small'] = $thumbnail_small[0];
	$_data['thumbnail_url_medium'] = $thumbnail_medium[0];
	$_data['thumbnail_url_large'] = $thumbnail_large[0];


// Categories
	// Get Post specific Data
	$cats = get_the_category($post->ID);
	$_data['category_info'] = $cats;


	$data->data = $_data;
	return $data;

}
add_filter( 'rest_prepare_post', 'rest_prepare', 10, 3 );



// REGISTER CUSTOM FIELDS FROM ACF
function register_custom_fields_thumbnail() {
	register_rest_field(
		'portfolio',
		'thumbnail_url',
		array(
			'get_callback' => 'show_thumbnail'
		)
	);
}

function show_thumbnail($object, $field_name, $request) {
	$thumbnail_id = get_post_thumbnail_id( $object['id'] );
	$thumbnail = wp_get_attachment_image_src( $thumbnail_id );
	$thumbnail_small = wp_get_attachment_image_src( $thumbnail_id, 'size-small' );
	$thumbnail_medium = wp_get_attachment_image_src( $thumbnail_id, 'size-medium' );
	$thumbnail_large = wp_get_attachment_image_src( $thumbnail_id, 'size-large' );

	return $thumbnail_sizes = array(
			'thumb' => $thumbnail[0],
			'small'=> $thumbnail_small[0],
			'medium'=> $thumbnail_medium[0],
			'large'=> $thumbnail_large[0]
		);
}
add_action('rest_api_init', 'register_custom_fields_thumbnail');
