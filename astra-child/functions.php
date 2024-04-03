<?php
/**
 * Nathalie Mota Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Nathalie Mota
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_NATHALIE_MOTA_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {
	// Chargement du CSS du thème parent
	wp_enqueue_style( 'nathalie-mota-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_NATHALIE_MOTA_VERSION, 'all' );
	// Chargement du css/style.css pour nos personnalisations
	wp_enqueue_style('css-style', get_stylesheet_directory_uri() . '/css/style.css');
	// Chargement de Javascript //
	wp_enqueue_script( 'script', get_stylesheet_directory_uri() . '/js/script.js', '1.1', true);    
}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );
