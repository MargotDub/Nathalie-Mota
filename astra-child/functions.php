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

require_once('ajax-functions.php');

// Charger les scripts et les styles
function child_enqueue_styles() {
    // Chargement du CSS du thème parent
    wp_enqueue_style( 'nathalie-mota-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_NATHALIE_MOTA_VERSION, 'all' );
    // Chargement du css/style.css pour nos personnalisations
    wp_enqueue_style('css-style', get_stylesheet_directory_uri() . '/css/style.css');
    // Chargement du CSS de Select2
    wp_enqueue_style('select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
    // Chargement de Javascript
    wp_enqueue_script( 'js-script', get_stylesheet_directory_uri() . '/js/script.js', array('jquery'), '1.0', true);
    // Chargement de Select2
    wp_enqueue_script('select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array('jquery'), '', true);
}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

// Charger AJAX //
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');

// AFFICHAGE LIEN AVANT ET APRES PUBLICATIONS POST PHOTOS //
function custom_previous_post_link( $format = '%link', $link = '&#x27F5;', $in_same_term = false, $excluded_terms = '', $taxonomy = 'categorie' ) {
    $format = str_replace('&#x27F5;', '', $format);
    echo get_previous_post_link( $format, $link, $in_same_term, $excluded_terms, $taxonomy );
}

function custom_next_post_link( $format = '%link', $link = '&#x27F6;', $in_same_term = false, $excluded_terms = '', $taxonomy = 'categorie' ) {
    $format = str_replace('&#x27F6;', '', $format);
    echo get_next_post_link( $format, $link, $in_same_term, $excluded_terms, $taxonomy );
}

// function custom_previous_post_link( $format = '%link', $link = '&#x27F5;', $in_same_term = false, $excluded_terms = '', $taxonomy = 'categorie' ) {
//     $format = str_replace('&#x27F5;', '', $format);
//     $prev_post = get_previous_post();
//     if ($prev_post) {
//         $thumbnail = get_the_post_thumbnail_url($prev_post->ID, 'thumbnail');
//         echo '<a href="' . get_permalink($prev_post->ID) . '" class="custom-prev-post-link" data-thumbnail="' . $thumbnail . '">' . $link . '</a>';
//     } else {
//         echo '<span class="custom-prev-post-link disabled">' . $link . '</span>';
//     }
// }

// function custom_next_post_link( $format = '%link', $link = '&#x27F6;', $in_same_term = false, $excluded_terms = '', $taxonomy = 'categorie' ) {
//     $format = str_replace('&#x27F6;', '', $format);
//     $next_post = get_next_post();
//     if ($next_post) {
//         $thumbnail = get_the_post_thumbnail_url($next_post->ID, 'thumbnail');
//         echo '<a href="' . get_permalink($next_post->ID) . '" class="custom-next-post-link" data-thumbnail="' . $thumbnail . '">' . $link . '</a>';
//     } else {
//         echo '<span class="custom-next-post-link disabled">' . $link . '</span>';
//     }
// }
