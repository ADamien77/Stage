<?php
/* ==========================================================================
   3️⃣ — SUPPORTS & FONCTIONNALITÉS DU THÈME
   ========================================================================== */

/**
 * Activer certaines fonctionnalités natives WordPress
 */
function montheme_theme_supports() {

    // Balise <title> dynamique
    add_theme_support('title-tag');

    // Logo personnalisé (Customizer)
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Image à la une
    add_theme_support('post-thumbnails');

    // Support HTML5 pour certains éléments
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption'
    ));

    // Compatibilité WooCommerce
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'montheme_theme_supports');


/**
 * Taille d’image personnalisée
 */
add_action('after_setup_theme', function() {
    add_image_size('personnalise', 1200, 400, true);
});

