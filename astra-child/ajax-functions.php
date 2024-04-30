<!-- REQUETE AJAX -->
<?php
function custom_post_type() {
    $args = array(
        'public' => true,
        'label'  => 'photo',
    );
    register_post_type( 'photo', $args );
}
add_action( 'init', 'custom_post_type' );

function load_more_photos() {
    $paged = $_POST['page'];
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $paged,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) :
            $query->the_post();
            ?>
                <?php the_post_thumbnail('thumbnail'); ?>
                <?php the_content(); ?>
            <?php
        endwhile;
    endif;

    wp_reset_postdata();

    die();
}
?>

<?php
