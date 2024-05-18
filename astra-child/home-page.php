<?php
/*
Template Name: Home Page
*/

get_header(); ?>

<div class="container-accueil">
    <h1>PHOTOGRAPHE EVENT</h1>
    <img class="hero-accueil" src="<?php echo get_stylesheet_directory_uri(); ?>/images/hero-accueil.jpeg" alt="image d'en-tête Photographe Event"/>
</div>

<div class="ast-container photo-container">

<!-- Mise en place des filtres -->
<div class="filtres">
    <form method="get" action="">
        <p>
            <select name="categories" id="categories">
                <option class="filtre-none" value="">Catégories</option>
                <?php
                $categories = get_terms(array(
                    'taxonomy' => 'categorie',
                    'hide_empty' => false,
                ));
                foreach ($categories as $category) {
                    echo '<option value="' . $category->slug . '">' . $category->name . '</option>';
                }
                ?>
            </select>
        </p>
    </form>
    <form method="get" action="">
        <p>
            <select name="formats" id="formats">
                <option class="filtre-none" value="">Formats</option>
                <?php
                $formats = get_terms(array(
                    'taxonomy' => 'format',
                    'hide_empty' => false,
                ));
                foreach ($formats as $format) {
                    echo '<option value="' . $format->slug . '">' . $format->name . '</option>';
                }
                ?>
            </select>
        </p>
    </form>
    <form method="get" action="">
        <p>
            <select name="trier-par" id="trier-par">
                <option class="filtre-none" value="">Trier par</option>
                <option value="recent">À partir des plus récentes</option>
                <option value="ancien">À partir des plus anciennes</option>
            </select>
        </p>
    </form>
</div>

<div class="flexbox-layout">
<?php 
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
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
        ?>
    </div> 
    <div class="button-center">
        <button class="load-more-button">Charger plus</button>
    </div>
    <?php
    } else {
        echo 'Aucune photo trouvée.';
    }
?>
</div>

<?php get_footer(); ?>