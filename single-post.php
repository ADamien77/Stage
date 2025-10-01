<?php
/**
 * Template personnalisé : Affichage d'un article (single post)
 */

get_header(); // Appelle header.php
?>

<div class="single-article">

  <!-- ==============================
       🏷️ Titre de l'article
       ============================== -->
  <div class="title_blog">
    <div class="separateur"></div>
    <h1><?php the_title(); ?></h1>
    <div class="separateur"></div>
  </div>

  <?php
  // ===============================================
  // 🔹 Boucle WordPress : affichage du contenu
  // ===============================================
  if ( have_posts() ) :
    while ( have_posts() ) : the_post(); ?>

      <section class="article_1">
        <div class="contenu">

          <?php
          // 🖼️ Image à la une (si définie)
          if ( has_post_thumbnail() ) {
            the_post_thumbnail(
              'personnalise', // Taille d'image personnalisée (définie via add_image_size)
              array( 'class' => 'image-centree-magazine' ) // Classe CSS personnalisée
            );
          }

          // 📄 Contenu principal de l'article
          the_content();
          ?>

        </div>
      </section>

    <?php endwhile;
  endif;
  ?>
</div><!-- /.single-article -->

<?php get_footer(); // Appelle footer.php ?>
