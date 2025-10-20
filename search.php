<?php
/**
 * Template de recherche personnalisé pour tous les contenus :
 * - Produits WooCommerce
 * - Articles
 * - Pages
 */

defined('ABSPATH') || exit;

get_header();
?>

<section class="search-section">

  <h1 class="search-title">
    Résultats pour : "<?php echo get_search_query(); ?>"
  </h1>

  <div class="cards">

    <?php if ( have_posts() ) : ?>

      <?php while ( have_posts() ) : the_post(); ?>

        <?php 
        // Vérifie si c’est un produit WooCommerce
        $is_product = 'product' === get_post_type();
        $product = $is_product ? wc_get_product( get_the_ID() ) : null;
        ?>

        <div class="card">

          <!-- Image -->
          <div class="image">
            <a href="<?php the_permalink(); ?>">
              <?php 
              if ( has_post_thumbnail() ) {
                the_post_thumbnail( 'medium' );
              } else {
                echo '<img src="' . wc_placeholder_img_src() . '" alt="placeholder">';
              }
              ?>
            </a>
          </div>

          <!-- Contenu -->
          <div class="contenu">
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

            <?php if ( $is_product && $product ) : ?>
              <!-- Étoiles WooCommerce -->
              <div class="avis">
                <?php echo wc_get_rating_html( $product->get_average_rating() ); ?>
              </div>
            <?php endif; ?>

            <div class="description">
              <?php the_excerpt(); ?>
            </div>
          </div>

          <!-- Bas de carte -->
          <div class="prix_bouton">
            <?php if ( $is_product && $product ) : ?>
              <div class="prix">
                <p><?php echo $product->get_price_html(); ?></p>
              </div>
              <div class="bouton">
                <a href="<?php the_permalink(); ?>">Plus d'informations</a>
              </div>
            <?php else : ?>
              <div class="bouton">
                <a href="<?php the_permalink(); ?>">Lire la suite</a>
              </div>
            <?php endif; ?>
          </div>

        </div><!-- /.card -->

      <?php endwhile; ?>

    <?php else : ?>

      <p>Aucun résultat trouvé pour votre recherche.</p>

    <?php endif; ?>

  </div><!-- /.cards -->

</section>

<?php get_footer(); ?>
