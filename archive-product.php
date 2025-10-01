<?php
/**
 * Template personnalisé WooCommerce : Archive / Catégorie produit
 * 
 * - Gère l'affichage de la boutique et des catégories produits
 * - Redirige la catégorie "tout-voir" vers la boutique
 * - Affiche les produits avec image, titre, avis, extrait, prix et bouton
 */

defined( 'ABSPATH' ) || exit; // Sécurité : empêche l'accès direct au fichier

// --------------------------------------------------
// 🔹 Redirection de la catégorie "tout-voir" vers la boutique
// --------------------------------------------------
if ( is_product_category( 'tout-voir' ) ) {
    wp_safe_redirect( get_permalink( wc_get_page_id( 'shop' ) ) );
    exit;
}

// Appelle le header du thème (header.php)
get_header();
?>

<section class="products">
  <!-- Titre principal avec séparateurs -->
  <div class="title">
    <div class="separateur"></div>
    <h1>
      <?php
      // Titre dynamique selon le contexte
      if ( is_shop() ) {
        // Page Boutique
        echo get_the_title( wc_get_page_id( 'shop' ) );
      } elseif ( is_product_category() ) {
        // Page catégorie produit
        single_term_title();
      } else {
        // Cas fallback (ex. autre archive)
        the_title();
      }
      ?>
    </h1>
    <div class="separateur"></div>
  </div>

  <div class="cards">
    <?php
    // --------------------------------------------------
    // 🔹 Boucle WooCommerce : affiche les produits
    // --------------------------------------------------
    if ( have_posts() ) :

      // Debug facultatif : nombre de produits trouvés
      // echo '<p>Produits trouvés : ' . $wp_query->found_posts . '</p>';

      while ( have_posts() ) : the_post();
        global $product; // Objet WC_Product courant
        ?>
        
        <div class="card">
          
          <!-- Image produit -->
          <div class="image">
            <a href="<?php the_permalink(); ?>">
              <?php the_post_thumbnail( 'medium' ); ?>
            </a>
          </div>

          <!-- Contenu texte produit -->
          <div class="contenu">
            <h3><?php the_title(); ?></h3>

            <!-- Avis (étoiles WooCommerce) -->
            <div class="avis">
              <?php echo wc_get_rating_html( $product->get_average_rating() ); ?>
            </div>

            <!-- Extrait -->
            <div class="description">
              <?php the_excerpt(); ?>
            </div>
          </div>

          <!-- Prix + bouton -->
          <div class="prix_bouton">
            <div class="prix">
              <p><?php echo $product->get_price_html(); ?></p>
            </div>
            <div class="bouton">
              <a href="<?php the_permalink(); ?>">Plus d'informations</a>
            </div>
          </div>

        </div><!-- /.card -->

        <?php
      endwhile;

    else :
      // Aucun produit trouvé
      echo "<p>Aucun produit trouvé</p>";
    endif;
    ?>
  </div><!-- /.cards -->
</section>

<?php
// Appelle le footer du thème (footer.php)
get_footer();
