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
          <?php
          global $product;
          ?>
          <div class="avis">
            <?php echo wc_get_rating_html($product->get_average_rating()); ?>
          </div>

          <!-- 📄 Description complète (avec fallback) -->
          <div class="texte-produit">
            <?php
            $full = get_post_field('post_content', get_the_ID());

            if (! empty($full)) {
              echo apply_filters('the_content', $full);
            } else {
              // Si pas de description complète, on affiche la description courte
              echo wpautop(get_the_excerpt());
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
      <?php comments_template(); ?>

      <!-- ===============================
     Produits similaires
=============================== -->

      <div class="similaires">
        <h2>Produits similaires</h2>

        <?php
        global $wpdb, $product;

        // ID du produit actuel
        $current_product_id = $product->get_id();

        // Catégories du produit
        $categories = wp_get_post_terms($current_product_id, 'product_cat', array('fields' => 'ids'));

        if (!empty($categories)) {

          // Conversion en liste d'IDs séparés par des virgules
          $cat_ids = implode(',', array_map('intval', $categories));

          // ===============================
          // 🔹 Requête SQL personnalisée
          // ===============================
          $query = "
      SELECT DISTINCT p.ID, p.post_title
      FROM {$wpdb->posts} AS p
      INNER JOIN {$wpdb->term_relationships} AS tr ON (p.ID = tr.object_id)
      INNER JOIN {$wpdb->term_taxonomy} AS tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id)
      WHERE p.post_type = 'product'
      AND p.post_status = 'publish'
      AND tt.taxonomy = 'product_cat'
      AND tt.term_id IN ($cat_ids)
      AND p.ID != %d
      ORDER BY RAND()
      LIMIT 4
    ";

          // Exécution sécurisée
          $related_products = $wpdb->get_results($wpdb->prepare($query, $current_product_id));

          if (!empty($related_products)) {
            echo '<div class="related-products-grid">';

            foreach ($related_products as $related) {

              // Récupération du lien et de l’image du produit
              $link = get_permalink($related->ID);
              $thumbnail = get_the_post_thumbnail($related->ID, 'medium');

              // =======================================
              // 🎨 Affichage du produit similaire
              // =======================================
              echo '<div class="related-item">';

              // Image + titre cliquables
              echo '<a href="' . esc_url($link) . '">';
              echo $thumbnail;
              echo '<h3>' . esc_html($related->post_title) . '</h3>';
              echo '</a>';

              // Objet produit WooCommerce
              $related_product_obj = wc_get_product($related->ID);

              // Prix du produit
              if ($related_product_obj) {
                echo '<p class="price">' . $related_product_obj->get_price_html() . '</p>';
              }

              // Bouton “Plus d’informations”
              echo '<a href="' . esc_url($link) . '" class="button more-info-button">
                Plus d’informations
              </a>';

              echo '</div>'; // fin .related-item
            }

            echo '</div>'; // fin .related-products-grid
          } else {
            echo '<p>Aucun produit similaire trouvé.</p>';
          }
        }
        ?>
      </div>

    </section>

<?php
  endwhile;
endif;

get_footer();
