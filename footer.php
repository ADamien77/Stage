<footer class="site-footer">
  <div class="logo">
    <a href="<?php echo esc_url( home_url('/') ); ?>">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="<?php bloginfo('name'); ?>" />
    </a>
  </div>

  <!-- Pages légales -->
  <div class="pages_legales">
  <?php
    wp_nav_menu( array(
      'theme_location' => 'footer',
      'container'      => false,
      'menu_class'     => 'footer-menu',
    ) );
  ?>
</div>


  <!-- Paiement -->
  <div class="paiement">
    <p>Moyens de paiement</p>
    <ul>
      <li>Carte bancaire <img src="<?php echo get_template_directory_uri(); ?>/assets/img/cb.png" alt="Carte bancaire"></li>
      <li>Chèque <img src="<?php echo get_template_directory_uri(); ?>/assets/img/check.png" alt="Chèque"></li>
      <li>Paypal <img src="<?php echo get_template_directory_uri(); ?>/assets/img/paypal.png" alt="Paypal"></li>
    </ul>
  </div>

  <!-- Livraison + réseaux -->
  <div class="livraison_reseaux">
    <div class="livraison">
      <p>Modes de livraison</p>
      <ul>
        <li>Chronopost</li>
        <li>Mondial Relay</li>
      </ul>
    </div>
    <div class="reseau">
      <a href="https://www.facebook.com" target="_blank" rel="noopener">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/Facebook.png" alt="Facebook">
      </a>
      <a href="https://www.instagram.com" target="_blank" rel="noopener">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/Instagram.png" alt="Instagram">
      </a>
      <a href="https://www.linkedin.com" target="_blank" rel="noopener">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/Linkedin.png" alt="LinkedIn">
      </a>
      <a href="https://www.youtube.com" target="_blank" rel="noopener">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/Youtube.png" alt="YouTube">
      </a>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
