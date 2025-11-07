<?php
/* ==========================================================================
   1️⃣ — CHARGEMENT DES STYLES & SCRIPTS
   ========================================================================== */

/**
 * Charger les fichiers CSS et JS du thème
 */
function montheme_enqueue_assets() {

    // Style principal (style.css à la racine du thème)
    wp_enqueue_style(
        'theme-style',
        get_stylesheet_uri()
    );

    // CSS personnalisé (dans /assets/css/main.css)
    wp_enqueue_style(
        'theme-main',
        get_template_directory_uri() . '/assets/css/main.css',
        array('theme-style'),
        '1.0'
    );

    // JS personnalisé (dans /assets/js/main.js)
    wp_enqueue_script(
        'theme-script',
        get_template_directory_uri() . '/assets/js/main.js',
        array('jquery'),
        '1.0',
        true // en footer
    );

    // Charger le CSS de la fiche produit uniquement sur les pages produit WooCommerce
    if ( is_product() ) {
        wp_enqueue_style(
            'product-sheet-style',
            get_stylesheet_directory() . '/assets/css/single-product.css',
            array('theme-style'),
            filemtime( get_stylesheet_directory() . '/assets/css/single-product.css' )
        );
    }
}
add_action('wp_enqueue_scripts', 'montheme_enqueue_assets');