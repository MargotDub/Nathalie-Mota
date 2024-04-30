<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

<div class="container-accueil">
	<h1>PHOTOGRAPHE EVENT</h1>
	<img class="hero-accueil" src="<?php echo get_stylesheet_directory_uri(); ?>./images/hero-accueil.jpeg" alt="image d'en-tête Photographe Event"/>
</div>

<div class="ast-container photo-container">

<!-- <div class="filtres">
    <form method="get" action="">
        <p>
            <select name="categories" id="categories">
                <option class="filtre-none">Catégorie</option>      
                    <option value="concert">Concert</option>
                    <option value="mariage">Mariage</option>
                    <option value="reception">Réception</option>
                    <option value="television">Télévision</option>
            </select>
        </p>
    </form>
    <form method="get" action="">
        <p>
            <select name="formats" id="formats">
                <option class="filtre-none">Formats</option>        
                    <option value="portrait">Portrait</option>
                    <option value="Paysage">Paysage</option>
            </select>
        </p>
    </form>
    <form method="get" action="">
        <p>
            <select name="trier-par" id="trier-par">
                <option class="filtre-none">Trier par</option>   
                    <option value="concert">A partir des plus récentes</option>
                    <option value="mariage">A partir des plus anciennes</option>
            </select>
        </p>
    </form>
</div> -->

<div class="filtres">
    <form method="get" action="">
        <p>
            <select name="categories" id="categories">
                <option class="filtre-none">Catégorie</option> 
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
                <option class="filtre-none">Formats</option>  
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
                <option class="filtre-none">Trier par</option>   
                <option value="recent">A partir des plus récentes</option>
                <option value="ancien">A partir des plus anciennes</option>
            </select>
        </p>
    </form>
</div>

    <div class="flexbox-layout">
<?php 
    // Récupérer mes photos pour la requête Ajax //
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
    );

    $photos_query = new WP_Query($args);

    if ($photos_query->have_posts()) {
        while ($photos_query->have_posts()) {
            $photos_query->the_post();
            ?>
            <div class="photo-item">
                <?php the_post_thumbnail('medium'); ?>
                <?php the_content(); ?>
            </div>
            <?php
        }
        wp_reset_postdata();
        ?>
        
        <!-- Bouton "charger plus" -->
        <button class="load-more-button">Charger plus</button>
        <?php
    } else {
        echo 'Aucune photo trouvée.';
    }
    ?>
    </div>
</div>

<?php get_footer(); ?>
