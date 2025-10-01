<?php
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Header -->
<header>
  <div class="container-header">
    
    <!-- Logo -->
    <div class="logo">
      <?php
      if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
        the_custom_logo();
      } else { ?>
        <a href="<?php echo esc_url( home_url('/') ); ?>">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="<?php bloginfo('name'); ?>" />
        </a>
      <?php } ?>
    </div>

    <!-- Barre de recherche (desktop/tablette) -->
    <div class="barre-recherche">
      <?php get_search_form(); ?>
    </div>

    <!-- Icônes -->
    <div class="icons">
      <!-- Icône recherche (mobile uniquement) -->
      <a href="#" class="search-toggle">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/research.png" alt="Recherche" width="28" height="28" />
      </a>

      <!-- Panier WooCommerce -->
      <?php if ( class_exists( 'WooCommerce' ) ) : ?>
        <a href="<?php echo wc_get_cart_url(); ?>">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/basket.png" alt="Panier" width="30" height="30" />
          <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
        </a>
      <?php endif; ?>

      <!-- Compte client WooCommerce -->
      <?php if ( class_exists( 'WooCommerce' ) ) : ?>
        <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/account.png" alt="Compte" width="30" height="30" />
        </a>
      <?php endif; ?>
    </div>

    <!-- Burger -->
    <div class="burger">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>

  <!-- Barre de recherche overlay (mobile uniquement) -->
  <div class="search-overlay">
    <div class="search-box">
      <?php get_search_form(); ?>
    </div>
  </div>

  <!-- Navigation dynamique -->
  <nav>
    <?php
    wp_nav_menu( array(
      'theme_location' => 'primary',
      'container'      => false,
      'menu_class'     => '',
      'fallback_cb'    => false,
    ) );
    ?>
  </nav>
</header>
