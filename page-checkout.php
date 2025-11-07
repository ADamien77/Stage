<?php
get_header();
?>
<main id="site-content">
    <?php
    while ( have_posts() ) :
        the_post();
        the_content(); //  Woo injecte le shortcode
    endwhile;
    ?>
</main>
<?php
get_footer();
