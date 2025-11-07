<?php 
/* ==========================================================================
   4️⃣ — FONCTIONNALITÉS WOOCOMMERCE
   ========================================================================== */

/**
 * Met à jour dynamiquement le compteur du panier (AJAX)
 */
add_filter('woocommerce_add_to_cart_fragments', function($fragments) {
    ob_start(); ?>
    <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
    <?php
    $fragments['.cart-count'] = ob_get_clean();
    return $fragments;
});