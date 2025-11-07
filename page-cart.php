<?php
get_header();
?>
<main id="site-content">
    <div class="title_cart">
    <div class="separateur"></div>
    <h1><?php the_title(); ?></h1>
    <div class="separateur"></div>
</div>
    <?php
    while ( have_posts() ) :
        the_post();
        the_content(); // Woo injecte le shortcode
    endwhile;
    ?>
</main>
<?php
get_footer();
