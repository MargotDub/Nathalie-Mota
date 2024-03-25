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

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );



// <?php
// // echo 'test';
// // function theme_enqueue_styles(){
// //     // Chargement du style.css du thème parent Twenty Twenty-one
// //     wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
// //     wp_enqueue_style('child-theme-style', get_stylesheet_uri(), array('parent-style'));
// //     // Chargement du css/style.css pour nos personnalisations
// //     wp_enqueue_style('css-style', get_stylesheet_directory_uri() . '/css/style.css');   

    
// // }
// // // Action qui permet de charger des scripts dans notre thème
// // add_action('wp_enqueue_scripts', 'theme_enqueue_styles');


// add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

// function enqueue_parent_styles() {
//    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
// }

// //load child theme custom CSS
// add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles', 11 );
// function my_theme_enqueue_styles() {
//     wp_enqueue_style( 'child-style', get_stylesheet_uri() );
// }