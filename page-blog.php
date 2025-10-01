<?php
/**
 * Template personnalisé : Page Blog
 */

get_header(); ?>

<!-- =========================
     🏷️ Titre principal du blog
     ========================= -->
<div class="title_blog">
  <div class="separateur"></div>
  <h1>Notre Blog</h1>
  <div class="separateur"></div>
</div>

<?php
// =========================================================
// 🔹 ARTICLE MIS EN AVANT (dernier article publié)
// =========================================================
$highlight = new WP_Query([
  'posts_per_page' => 1
]);

$highlight_id = 0; // On stocke l’ID du premier article pour l’exclure ensuite

if ( $highlight->have_posts() ) :
  while ( $highlight->have_posts() ) : $highlight->the_post();
    $highlight_id = get_the_ID();
?>
  <section class="article_1">
    <!-- Image de l’article -->
    <div class="image">
      <?php the_post_thumbnail('personnalise'); ?>
    </div>

    <!-- Contenu -->
    <div class="contenu">
      <h2><?php the_title(); ?></h2>
      
      <?php 
      // On tronque le contenu à 120 mots
      $texte = wp_trim_words(get_the_content(), 120, '...');
      echo wpautop($texte);
      ?>
      
      <!-- Lien vers l’article -->
      <a class="lien-article" href="<?php the_permalink(); ?>">Lire l’article</a>
    </div>
  </section>
<?php
  endwhile;
endif;
wp_reset_postdata();
?>

<?php
// =========================================================
// 🔹 AUTRES ARTICLES (grille)
// =========================================================
$grid = new WP_Query([
  'posts_per_page' => -1,
  'post__not_in'   => [$highlight_id] // Exclut l’article mis en avant
]);

if ( $grid->have_posts() ) : ?>
  <section class="articles-grid">
    <?php while ( $grid->have_posts() ) : $grid->the_post(); ?>
      <article class="article-card">
        
        <!-- Partie haute -->
        <div class="content">
          <div class="image">
            <?php the_post_thumbnail('medium'); ?>
          </div>
          <h3><?php the_title(); ?></h3>
          <p><?php the_excerpt(); ?></p>
        </div>
        
        <!-- Lien bas -->
        <a class="lien-article" href="<?php the_permalink(); ?>">Lire l’article</a>
      </article>
    <?php endwhile; ?>
  </section>
<?php endif; wp_reset_postdata(); ?>

<?php get_footer(); ?>
