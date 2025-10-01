<?php
defined('ABSPATH') || exit;

get_header();

if (have_posts()) :
  while (have_posts()) : the_post();
    global $product;
?>

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
              echo get_the_post_thumbnail($product->get_id(), 'large');
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
                  $thumb = wp_get_attachment_image($attachment_id, 'medium');
                  $full = wp_get_attachment_image_url($attachment_id, 'large');

                  echo '<div class="thumb" data-full="' . esc_url($full) . '">' . $thumb . '</div>';
                }
                ?>
              </div>
            </div>

          <?php endif; ?>
        </div>

        <!-- ===============================
         📝 Bloc description produit
    ================================ -->
        <div class="description">
          <h1><?php the_title(); ?></h1>

          <div class="avis">
            <?php
            global $product;
            $average = $product->get_average_rating();
            echo wc_get_rating_html($average ? $average : 0);
            ?>
          </div>
          <div class="texte-produit">
            <?php woocommerce_template_single_excerpt(); ?>
          </div>

          <div class="prix_bouton">
            <?php woocommerce_template_single_price(); ?>
            <?php woocommerce_template_single_add_to_cart(); ?>
          </div>
        </div>
      </div>
    
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
