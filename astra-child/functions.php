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

// Charger les scripts et les styles
function child_enqueue_styles() {
    // Chargement du CSS du thème parent
    wp_enqueue_style( 'nathalie-mota-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_NATHALIE_MOTA_VERSION, 'all' );
    // Chargement du css/style.css pour nos personnalisations
    wp_enqueue_style('css-style', get_stylesheet_directory_uri() . '/css/style.css');
    // Chargement du css/style.css pour nos personnalisations
    wp_enqueue_style('lightbox-style', get_stylesheet_directory_uri() . '/css/lightbox.css');
    // Chargement de Javascript
    wp_enqueue_script( 'js-script', get_stylesheet_directory_uri() . '/js/script.js', array('jquery'), '1.0', true); 

    wp_localize_script( 'js-script', 'my_ajax_vars', array(
        'ajaxurl'       => admin_url( 'admin-ajax.php' )
    ));
}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );


add_action('wp_ajax_nopriv_data_custom_ajax', 'data_custom_ajax');
add_action('wp_ajax_data_custom_ajax', 'data_custom_ajax');

// AFFICHAGE LIEN AVANT ET APRES PUBLICATIONS POST PHOTOS //
function custom_previous_post_link( $format = '%link', $link = '&#x27F5;', $in_same_term = false, $excluded_terms = '', $taxonomy = 'categorie' ) {
    $format = str_replace('&#x27F5;', '', $format);
    echo get_previous_post_link( $format, $link, $in_same_term, $excluded_terms, $taxonomy );
}

function custom_next_post_link( $format = '%link', $link = '&#x27F6;', $in_same_term = false, $excluded_terms = '', $taxonomy = 'categorie' ) {
    $format = str_replace('&#x27F6;', '', $format);
    echo get_next_post_link( $format, $link, $in_same_term, $excluded_terms, $taxonomy );
}

add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');

function load_more_photos() {
    $page = $_POST['page'];
    $categories = $_POST['categories'];
    $formats = $_POST['formats'];
    $trierPar = $_POST['trierPar'];

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $page,
    );

    $photos_query = new WP_Query($args);

    if ($photos_query->have_posts()) {
        while ($photos_query->have_posts()) {
            $photos_query->the_post();
            $photo_id = get_the_ID();
            $photo_title = get_the_title();
            $photo_reference = get_post_meta($photo_id, 'reference', true);
            $categories = get_the_terms($photo_id, 'categorie');
            $category_names = array();

            if ($categories && !is_wp_error($categories)) {
                foreach ($categories as $category) {
                    $category_names[] = $category->name;
                }
            }
                $category_list = implode(', ', $category_names);
            ?>
            <div class="photo-item">
                <?php the_post_thumbnail('full'); ?>
                <?php the_content(); ?>
                    <button class="fullscreen-button" data-image-url="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" data-reference="<?php echo esc_attr($photo_reference); ?>" data-category="<?php echo esc_attr($category_list); ?>"></button>
                    <button class="eye-button" data-image-url="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" data-post-url="<?php the_permalink(); ?>"></button>
                    <?php
                        echo '<p class="title_lightbox-hover">' . esc_html($photo_title) . '</p>';
                        echo '<p class="categorie_lightbox-hover">' . esc_html($category_list) . '</p>';
                    ?>
                </div>
            <?php
        }
        wp_reset_postdata();
        exit;
    } else {
        echo 'fin';
        exit;
    }
}