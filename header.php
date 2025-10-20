<?php
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <!-- Encodage et responsive -->
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Hooks WordPress (styles, scripts, meta, etc.) -->
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <!-- ===================== HEADER ===================== -->
  <header>
    <div class="container-header">

      <!-- ========== Logo ========== -->
      <div class="logo">
        <?php
        if (function_exists('the_custom_logo') && has_custom_logo()) {
          // Logo personnalisé via l'option WordPress
          the_custom_logo();
        } else { ?>
          <!-- Logo par défaut si aucun n'est défini -->
          <a href="<?php echo esc_url(home_url('/')); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="<?php bloginfo('name'); ?>" />
          </a>
        <?php } ?>
      </div>

      <!-- ========== Barre de recherche (desktop/tablette) ========== -->
      <div class="barre-recherche">
        <?php get_search_form(); ?>
      </div>

      <!-- ========== Icônes (recherche mobile, panier, compte) ========== -->
      <div class="icons">

        <!-- Icône recherche (affichée uniquement sur mobile) -->
        <a href="#" class="search-toggle">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/research.png" alt="Recherche" width="28" height="28" />
        </a>

        <!-- Panier WooCommerce -->
        <?php if (class_exists('WooCommerce')) : ?>
          <a href="<?php echo wc_get_cart_url(); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/basket.png" alt="Panier" width="30" height="30" />
            <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
          </a>
        <?php endif; ?>

        <!-- Compte client WooCommerce -->
        <?php if (class_exists('WooCommerce')) : ?>
          <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>"
            id="account-icon"
            class="account-icon"
            aria-label="Mon Compte">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/account.png" alt="Compte" width="30" height="30" />
          </a>
        <?php endif; ?>

        <!-- Menu Mon Compte (affiché uniquement sur mobile) -->
        <div id="mobile-account-menu" class="mobile-account-menu">
          <?php if (is_user_logged_in()) : ?>
            <a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>">Mes commandes</a>
            <a href="<?php echo esc_url(wc_get_account_endpoint_url('edit-account')); ?>">Mes informations</a>
            <a href="<?php echo esc_url(wc_logout_url()); ?>">Déconnexion</a>
          <?php else : ?>
            <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>">Connexion / Inscription</a>
          <?php endif; ?>
        </div>

      </div>

      <!-- ========== Bouton burger (menu mobile) ========== -->
      <div class="burger">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>

    <!-- ========== Barre de recherche overlay (mobile) ========== -->
    <div class="search-overlay">
      <div class="search-box">
        <?php get_search_form(); ?>
      </div>
    </div>

    <!-- ========== Navigation principale dynamique ========== -->
    <nav>
      <?php
      wp_nav_menu(array(
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => '',
        'fallback_cb'    => false,
      ));
      ?>
    </nav>
  </header>