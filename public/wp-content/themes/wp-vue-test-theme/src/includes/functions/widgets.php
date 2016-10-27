<?php

function widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Main Widget Area', 'THEME_NAME' ),
		'id'            => 'sidebar-primary',
		'description'   => __( 'Appears in the footer section of the site.', 'THEME_NAME' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Secondary Widget Area', 'THEME_NAME' ),
		'id'            => 'sidebar-secondary',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'THEME_NAME' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'widgets_init' );
