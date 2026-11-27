<?php
/**
 * Field and Vine theme functions.
 *
 * @package Field_And_Vine
 */

/**
 * Loads the editor stylesheet in the block editor.
 */
function field_and_vine_editor_style() {
	add_editor_style( 'assets/css/editor-style.css' );
}
add_action( 'after_setup_theme', 'field_and_vine_editor_style' );

/**
 * Loads the theme stylesheet on the front end.
 */
function field_and_vine_enqueue_styles() {
	wp_enqueue_style(
		'field-and-vine-style',
		get_parent_theme_file_uri( 'style.css' ),
		array(),
		wp_get_theme()->get( 'Version' )
	);
	wp_style_add_data( 'field-and-vine-style', 'path', get_parent_theme_file_path( 'style.css' ) );
}
add_action( 'wp_enqueue_scripts', 'field_and_vine_enqueue_styles' );
