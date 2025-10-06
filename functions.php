<?php
/**
 * ============================================================
 * 🎨 FUNCTIONS.PHP — Fonctions principales du thème
 * ============================================================
 * Ce fichier gère :
 * - Le chargement des styles & scripts
 * - Les menus WordPress
 * - Les supports du thème (logo, images à la une, etc.)
 * - La compatibilité WooCommerce
 * - Le formulaire de contact natif
 * - Les personnalisations WooCommerce (ex. champ gravure)
 * - Les optimisations de recherche (produits + redirection)
 * ============================================================
 */

defined('ABSPATH') || exit; // Sécurité

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
            get_stylesheet_directory_uri() . '/assets/css/single-product.css',
            array('theme-style'),
            filemtime( get_stylesheet_directory() . '/assets/css/single-product.css' )
        );
    }
}
add_action('wp_enqueue_scripts', 'montheme_enqueue_assets');


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


/* -----------------------------------------------------------
   💡 Champs personnalisés : ajout d’image de gravure (produit ID 145)
   ----------------------------------------------------------- */

/**
 * 1️⃣ — Afficher le champ d’upload sur la fiche produit
 */
add_action('woocommerce_before_add_to_cart_button', function() {
    global $product;
    if ( $product->get_id() == 145 ) {
        echo '<div class="champ-image-gravure" style="margin-bottom:15px;">
                <label for="gravure_image">Téléversez votre image pour la gravure :</label><br>
                <input type="file" name="gravure_image" id="gravure_image" accept="image/*" />
              </div>';
    }
});

/**
 * 2️⃣ — Validation du champ avant ajout au panier
 */
add_filter('woocommerce_add_to_cart_validation', function($passed, $product_id) {

    if ($product_id == 145) {

        if (empty($_FILES['gravure_image']['name'])) {
            wc_add_notice('⚠️ Merci de téléverser votre image pour la gravure.', 'error');
            return false;
        }

        $allowed = array('jpg', 'jpeg', 'png', 'gif');
        $file_ext = pathinfo($_FILES['gravure_image']['name'], PATHINFO_EXTENSION);
        if (!in_array(strtolower($file_ext), $allowed)) {
            wc_add_notice('⚠️ Seules les images JPG, PNG ou GIF sont autorisées.', 'error');
            return false;
        }

        $file_type = wp_check_filetype($_FILES['gravure_image']['name']);
        if (strpos($file_type['type'], 'image') === false) {
            wc_add_notice('⚠️ Le fichier téléversé n’est pas une image valide.', 'error');
            return false;
        }
    }

    return $passed;
}, 10, 2);

/**
 * 3️⃣ — Ajout des métadonnées dans le panier
 */
add_filter('woocommerce_add_cart_item_data', function($cart_item_data, $product_id) {
    if ($product_id == 145 && !empty($_FILES['gravure_image']['name'])) {
        $upload = wp_upload_bits(
            $_FILES['gravure_image']['name'],
            null,
            file_get_contents($_FILES['gravure_image']['tmp_name'])
        );
        if (!$upload['error']) {
            $cart_item_data['gravure_image'] = $upload['url'];
        }
    }
    return $cart_item_data;
}, 10, 2);

/**
 * 4️⃣ — Afficher l’image dans le panier et le checkout
 */
add_filter('woocommerce_get_item_data', function($item_data, $cart_item) {
    if (isset($cart_item['gravure_image'])) {
        $item_data[] = array(
            'name'  => 'Image gravure',
            'value' => '<a href="' . esc_url($cart_item['gravure_image']) . '" target="_blank">Voir l’image</a>',
        );
    }
    return $item_data;
}, 10, 2);

/**
 * 5️⃣ — Sauvegarde de l’image dans la commande
 */
add_action('woocommerce_add_order_item_meta', function($item_id, $values) {
    if (isset($values['gravure_image'])) {
        wc_add_order_item_meta($item_id, 'Image gravure', $values['gravure_image']);
    }
}, 10, 2);


/* ==========================================================================
   5️⃣ — FORMULAIRE DE CONTACT PERSONNALISÉ
   ========================================================================== */

/**
 * Traitement du formulaire de contact "en dur"
 */
function montheme_traitement_formulaire() {
    if (isset($_POST['form_contact'])) {

        $nom     = sanitize_text_field($_POST['nom']);
        $prenom  = sanitize_text_field($_POST['prenom']);
        $email   = sanitize_email($_POST['email']);
        $message = sanitize_textarea_field($_POST['message']);

        $to      = 'abadie.damien@devadam.com';
        $subject = "Nouveau message de $prenom $nom via le formulaire de contact";
        $body    = "Nom : $nom\nPrénom : $prenom\nEmail : $email\n\nMessage :\n$message";
        $headers = array('Content-Type: text/plain; charset=UTF-8');

        if (wp_mail($to, $subject, $body, $headers)) {
            echo '<div class="confirmation">✅ Merci, votre message a bien été envoyé.</div>';
        } else {
            echo '<div class="erreur">❌ Une erreur est survenue, merci de réessayer.</div>';
        }
    }
}
add_action('wp_head', 'montheme_traitement_formulaire');


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
