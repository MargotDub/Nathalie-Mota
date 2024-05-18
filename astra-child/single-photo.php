<?php
/* Template Name: Photos*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header(); ?>

<!-- RECUPERATION DES DONNEES DES POSTS -->
<div class="ast-container">
<div id="single-photo-details">
    <div class="single-contenu">
        <?php
            // Récupération des données de la photo en cours
            $photo_id = get_the_ID();
            $photo_title = get_the_title();
            $photo_reference = get_post_meta($photo_id, 'reference', true);
            $photo_type = get_post_meta($photo_id, 'type', true);
            $post_date = get_the_date('Y', $photo_id);

            // Récupération des catégories associées à la photo
            $categories = get_the_terms($photo_id, 'categorie');
            $category_names = array();
            if ($categories) {
                foreach ($categories as $category) {
                    $category_names[] = $category->name;
                }
            }
            $category_list = implode(', ', $category_names);

            // Récupération des formats associés à la photo
            $formats = get_the_terms($photo_id, 'format');
            $format_names = array();
            if ($formats) {
                foreach ($formats as $format) {
                    $format_names[] = $format->name;
                }
            }
            $format_list = implode(', ', $format_names);

            // Affichage des détails de la photo
            echo '<h2>' . $photo_title . '</h2>';
            echo '<p>Référence : ' . $photo_reference . '</p>';
            echo '<p>Catégorie : ' . $category_list . '</p>';
            echo '<p>Format : ' . $format_list . '</p>';
            echo '<p>Type : ' . $photo_type . '</p>';
            echo '<p>Année : ' . $post_date . '</p>';

        ?>
    </div>
    <?php echo get_the_post_thumbnail($photo_id); ?>
</div>

<!-- BOUTON DE CONTACT -->
<div class="border-button-responsive"></div>
<div class="single-button">
    <p> Cette photo vous intéresse ? </p>
    <button class="contact-button" id="contact-button">Contact</button>

    <div class="fleches-previous-next">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                ?>

                <div class="previous-post-link">
                    <?php custom_previous_post_link(); ?>
                    <?php $prev_post_id = get_previous_post()->ID; ?>
                    <?php if (has_post_thumbnail($prev_post_id)): ?>
                        <?php $prev_thumbnail_url = get_the_post_thumbnail_url($prev_post_id, 'thumbnail'); ?>
                        <img src="<?php echo $prev_thumbnail_url; ?>" class="previous-photo" alt="Previous Photo">
                    <?php endif; ?>
                </div>

                <div class="next-post-link">
                    <?php custom_next_post_link(); ?>
                    <?php $next_post_id = get_next_post()->ID; ?>
                    <?php if (has_post_thumbnail($next_post_id)): ?>
                        <?php $next_thumbnail_url = get_the_post_thumbnail_url($next_post_id, 'thumbnail'); ?>
                        <img src="<?php echo $next_thumbnail_url; ?>" class="next-photo" alt="Next Photo">
                    <?php endif; ?>
                </div>

                <?php
            endwhile;
        endif;
        ?>
    </div>
</div>
<div class="border-button"></div>

<!-- WP_QUERY POUR RECUPERATION DE DEUX PHOTOS ALEATOIRES -->
<?php
$current_photo_id = get_the_ID();

$photo_categories = get_the_terms($current_photo_id, 'categorie');

// Vérifie si des catégories ont été trouvées pour la photo actuelle
if (!empty($photo_categories)) {
    $random_category_id = $photo_categories[array_rand($photo_categories)]->term_id;

    $random_photos_query = new WP_Query(array(
        'post_type' => 'photo',
        'posts_per_page' => 2,
        'orderby' => 'rand',
        'tax_query' => array(
            array(
                'taxonomy' => 'categorie',
                'field' => 'id',
                'terms' => $random_category_id,
            ),
        ),
        'post__not_in' => array($current_photo_id),
    ));

    // Vérifie si des posts ont été trouvés
    if ($random_photos_query->have_posts()) :
?>
        <h3 class="single-title-h3">VOUS AIMEREZ AUSSI</h3>
        <div class="flexbox-layout">
            <?php
            while ($random_photos_query->have_posts()) : $random_photos_query->the_post();
                $random_photo_id = get_the_ID();
                $random_photo_title = get_the_title();
                $random_photo_reference = get_post_meta($random_photo_id, 'reference', true);
                $random_photo_categories = get_the_terms($random_photo_id, 'categorie');
                $random_category_names = array();

                if ($random_photo_categories) {
                    foreach ($random_photo_categories as $category) {
                        $random_category_names[] = $category->name;
                    }
                }
                $random_category_list = implode(', ', $random_category_names);
            ?>
            <div class="photo-item">
                <?php the_post_thumbnail('full'); ?>
                <div class="buttons-container">
                    <button class="fullscreen-button" data-image-url="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" data-reference="<?php echo esc_attr($random_photo_reference); ?>" data-category="<?php echo esc_attr($random_category_list); ?>"></button>
                    <button class="eye-button" data-image-url="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" data-post-url="<?php the_permalink(); ?>"></button>
                    <?php
                        echo '<p class="title_lightbox-hover">' . esc_html($random_photo_title) . '</p>';
                        echo '<p class="categorie_lightbox-hover">' . esc_html($random_category_list) . '</p>';
                    ?>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
<?php
    wp_reset_postdata();
    endif;
}
?>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const photoReference = "<?php echo esc_js($photo_reference); ?>";
    const contactButton = document.getElementById('contact-button');

    // Ajoutez un écouteur d'événement pour le clic sur le bouton
    contactButton.addEventListener('click', function() {
        // Remplir le champ de référence dans le formulaire de contact
        const refPhotoField = document.getElementById('refPhoto').querySelector('input[type="text"]');
        if (refPhotoField) {
            refPhotoField.value = photoReference;
        }
    });
});
</script>

<?php get_footer(); ?> 