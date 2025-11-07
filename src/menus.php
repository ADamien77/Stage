<?php 
/* ==========================================================================
   2️⃣ — MENUS WORDPRESS
   ========================================================================== */

/**
 * Enregistre les emplacements de menus du thème
 */
function montheme_register_menus() {
    register_nav_menus(array(
        'primary' => __('Menu principal', 'monthemeperso'),
        'footer'  => __('Menu pied de page', 'monthemeperso'),
    ));
}
add_action('after_setup_theme', 'montheme_register_menus');