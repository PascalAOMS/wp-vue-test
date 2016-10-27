<?php

// PORTFOLIO
function cpt_portfolio() {

	$POST_TYPE_NAME = 'Portfolio';
	$POST_TYPE_NAME_PLURAL = 'Portfolios';
	$THEME_NAME = 'REST';

	$labels = array(
	    'name'                  => _x( $POST_TYPE_NAME, 'Post Type General Name', $THEME_NAME ),
	    'singular_name'         => _x( $POST_TYPE_NAME, 'Post Type Singular Name', $THEME_NAME ),
	    'menu_name'             => __( $POST_TYPE_NAME, $THEME_NAME ),
	    'all_items'             => __( 'All ' . $POST_TYPE_NAME_PLURAL, $THEME_NAME ),
	    'view_item'             => __( 'View ' . $POST_TYPE_NAME, $THEME_NAME ),
	    'add_new_item'          => __( 'Add New ' . $POST_TYPE_NAME, $THEME_NAME ),
	    'add_new'               => __( 'Add New', $THEME_NAME ),
	    'edit_item'             => __( 'Edit ' . $POST_TYPE_NAME, $THEME_NAME ),
	    'update_item'           => __( 'Update ' . $POST_TYPE_NAME, $THEME_NAME ),
	    'search_items'          => __( 'Search ' . $POST_TYPE_NAME, $THEME_NAME ),
	    'not_found'             => __( 'Not Found', $THEME_NAME ),
	    'not_found_in_trash'    => __( 'Not found in Trash', $THEME_NAME ),
	);

    $args = array(
		'label'                 => __( strtolower($POST_TYPE_NAME), $THEME_NAME ),
		'labels' 			    => $labels,
		'capability_type'		=> 'post',
		'exclude_from_search'	=> false,
		'has_archive' 			=> true,
		'hierarchical'			=> false,
		'menu_position'			=> 5,
		'public'				=> true,
		'rewrite' 				=> array('slug' => strtolower($POST_TYPE_NAME)),
		'publicly_queryable'	=> true,
		'query_var'				=> true,
		'menu_icon'				=> 'dashicons-admin-site',
		'supports'				=> array(
			'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'		// Need to register Thumbnails in add_theme_support
		),
		'taxonomies'			=> array( 'category', 'post_tag' ),
		'show_in_rest'          => true,			// REST API
  		//'rest_base'           => 'books-api',		// Custom Base URL
    );

    register_post_type( strtolower($POST_TYPE_NAME), $args );
}
add_action( 'init', 'cpt_portfolio' );
