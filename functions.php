<?php

defined('ABSPATH') || exit; // Sécurité

include get_template_directory() . '/src/theme-supports.php'; /*Supports et fonctionnalités du thème*/
include get_template_directory() . '/src/enqueue-script.php';  /*Chargement des styles et scripts*/
include get_template_directory() . '/src/menus.php'; /*Menu WordPress*/

include get_template_directory() . '/src/woocommerce-functions.php'; /*Fonctionnalités WooCommerce globales*/
include get_template_directory() . '/src/product-gravure.php'; /*Fiche produit Gravure (ID 202)*/
include get_template_directory() . '/src/product-plaque.php'; /*Fiche produit Plaque de prénom (ID 204)*/

include get_template_directory() . '/src/contact-form.php'; /*Formulaire de contact personnalisé*/
include get_template_directory() . '/src/search-redirect.php'; /*Optimisation de recherche et redirection*/

add_action('init', function() {
    if ( isset($_GET['test_mail']) ) {

        error_log('✉️ Test mail lancé');

        $sent = wp_mail(
            'abadie.damien@devadam.com',
            'Test wp_mail() depuis Local',
            'Ceci est un test simple.'
        );

        if ( $sent ) {
            error_log('✉️ wp_mail() a renvoyé TRUE');
        } else {
            error_log('✉️ wp_mail() a renvoyé FALSE');
        }
    }
});
