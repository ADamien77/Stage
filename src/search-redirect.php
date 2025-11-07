<?php
/* ==========================================================================
   6️⃣ — RECHERCHE : OPTIMISATION ET REDIRECTION
   ========================================================================== */

/**
 * 🧭 1. Exclure les pages des résultats de recherche
 *     (on garde seulement les articles et produits)
 */
function my_search_include_only_posts_and_products($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_search()) {
        // On exclut les pages
        $query->set('post_type', array('post', 'product'));
    }
}
add_action('pre_get_posts', 'my_search_include_only_posts_and_products');


/**
 * 🚀 2. Rediriger automatiquement si le titre correspond exactement
 *     à une page ou un produit
 */
function redirect_exact_content_match() {
    if (is_search() && !is_admin() && isset($_GET['s'])) {
        $search_query = trim(sanitize_text_field($_GET['s']));

        // Vérifie d'abord s'il existe une page correspondant exactement
        $args_page = array(
            'post_type'      => 'page',
            'title'          => $search_query,
            'post_status'    => 'publish',
            'posts_per_page' => 1,
        );

        $page = get_posts($args_page);
        if ($page && count($page) === 1) {
            wp_redirect(get_permalink($page[0]->ID));
            exit;
        }

        // Sinon, on vérifie s'il existe un produit avec le même nom
        $args_product = array(
            'post_type'      => 'product',
            'title'          => $search_query,
            'post_status'    => 'publish',
            'posts_per_page' => 1,
        );

        $product = get_posts($args_product);
        if ($product && count($product) === 1) {
            wp_redirect(get_permalink($product[0]->ID));
            exit;
        }
    }
}
add_action('template_redirect', 'redirect_exact_content_match');



function mon_theme_scripts() {
  wp_enqueue_script(
    'theme-header-js',
    get_template_directory_uri() . '/assets/js/header.js',
    array(),
    null,
    true
  );
}
add_action('wp_enqueue_scripts', 'mon_theme_scripts');

function add_search_body_class( $classes ) {
    if ( is_search() && is_woocommerce() ) {
        $classes[] = 'search-woocommerce-page';
    }
    return $classes;
}
add_filter( 'body_class', 'add_search_body_class' );
