<?php
/**
 * EdxChild (Twenty Twenty Child) functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage EdxChild
 * @since 1.0.0
 */

add_action( 'wp_enqueue_scripts', 'edxchild_enqueue_styles' );

/**
 * Register and Enqueue Styles.
 */
function edxchild_enqueue_styles() {

	$parent_style = 'twentytwenty-style'; // This is 'twentytwenty-style' for the Twenty Twenty theme.

	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css', '20191206', 'all' );
	wp_enqueue_style(
		'edxchild-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( $parent_style ),
		wp_get_theme()->get( 'Version' )
	);
}
