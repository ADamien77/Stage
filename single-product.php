<?php
/**
 * Template personnalisé : Fiche produit WooCommerce
 */
defined('ABSPATH') || exit;

get_header();

if (have_posts()) :
  while (have_posts()) : the_post();
    global $product;
?>

    <!-- Fil d'Ariane -->
    <div class="menu_product_sheet">
      <p><?php woocommerce_breadcrumb(); ?></p>
    </div>

    <section class="product_sheet">
      <div class="contenu">
        
        <!-- ===============================
         📷 Bloc images produit
        ================================ -->
        <div class="images">

          <!-- ✅ Image principale -->
          <div class="image_principale">
            <?php
            if (has_post_thumbnail()) {
              echo get_the_post_thumbnail($product->get_id(), 'large', [
                'class' => 'image-produit-principale'
              ]);
            }
            ?>
          </div>

          <!-- ✅ Galerie secondaire (max 2 images) -->
          <?php
          $attachment_ids = $product->get_gallery_image_ids();
          if ($attachment_ids) :
          ?>
            <div class="images_secondaires">
              <div class="track">
                <?php
                foreach ($attachment_ids as $attachment_id) {
                  $thumb = wp_get_attachment_image($attachment_id, 'medium', false, [
                    'class' => 'image-produit-secondaire'
                  ]);
                  $full = wp_get_attachment_image_url($attachment_id, 'large');

                  echo '<div class="thumb" data-full="' . esc_url($full) . '">' . $thumb . '</div>';
                }
                ?>
              </div>
            </div>
          <?php endif; ?>

        </div><!-- /.images -->

        <!-- ===============================
         📝 Bloc description produit
        ================================ -->
        <div class="description">
          <h1><?php the_title(); ?></h1>

         <!-- ⭐ Avis & étoiles -->
<div class="avis">
  <?php
  $average = $product->get_average_rating();

  if ($average > 0) {
    // ⭐ Affiche la notation WooCommerce (ex: 3,5 étoiles remplis / vides)
    echo wc_get_rating_html($average);
  } else {
    // ⭐ Aucun avis → afficher 5 étoiles vides comme dans ton design
    for ($i = 0; $i < 5; $i++) {
      echo '<img src="' . get_template_directory_uri() . '/assets/img/star.png" alt="Étoile de notation" />';
    }
  }
  ?>
</div>

      <!-- 📄 Description complète (avec fallback) -->
<div class="texte-produit">
  <?php
  $full = get_post_field( 'post_content', get_the_ID() );

  if ( ! empty( $full ) ) {
    echo apply_filters( 'the_content', $full );
  } else {
    // Si pas de description complète, on affiche la description courte
    echo wpautop( get_the_excerpt() );
  }
  ?>
</div>

          <!-- 💰 Prix + bouton panier -->
          <div class="prix_bouton">
            <?php woocommerce_template_single_price(); ?>
            <?php woocommerce_template_single_add_to_cart(); ?>
          </div>
        </div><!-- /.description -->

      </div><!-- /.contenu -->

      <!-- ===============================
       📌 Informations complémentaires
      ================================ -->
      <div class="info_complementaire">
        <div class="contenu_complementaire">
          <?php woocommerce_product_additional_information_tab(); ?>
        </div>
      </div>

    </section>

<?php
  endwhile;
endif;

get_footer();
