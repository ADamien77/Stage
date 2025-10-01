<?php
/**
 * Fonctions principales du thème
 */

// 🔹 Charger les styles et scripts
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
        array('theme-style'), // dépend de style.css
        '1.0'
    );

    // JS personnalisé (dans /assets/js/main.js)
    wp_enqueue_script(
        'theme-script',
        get_template_directory_uri() . '/assets/js/main.js',
        array('jquery'), // dépend de jQuery
        '1.0',
        true // chargé en footer
    );
}
add_action('wp_enqueue_scripts', 'montheme_enqueue_assets');


// 🔹 Enregistrer les emplacements de menus
function montheme_register_menus() {
    register_nav_menus( array(
        'primary' => __( 'Menu principal', 'monthemeperso' ), // menu du header
        'footer'  => __( 'Menu pied de page', 'monthemeperso' ) // menu du footer
    ) );
}
add_action( 'after_setup_theme', 'montheme_register_menus' );


// 🔹 Activer certaines fonctionnalités utiles de WordPress
function montheme_theme_supports() {
    // Balises <title> dynamiques
    add_theme_support( 'title-tag' );

    // Logo personnalisé (ajout via le Customizer)
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Images à la une (featured image)
    add_theme_support( 'post-thumbnails' );

    // Support HTML5 pour certains éléments
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
}
add_action( 'after_setup_theme', 'montheme_theme_supports' );


// 🔹 Traitement du formulaire contact en dur
function montheme_traitement_formulaire() {
    if ( isset($_POST['form_contact']) ) {
        
        // Sécurisation des champs
        $nom     = sanitize_text_field($_POST['nom']);
        $prenom  = sanitize_text_field($_POST['prenom']);
        $email   = sanitize_email($_POST['email']);
        $message = sanitize_textarea_field($_POST['message']);

        // Destinataire de l'email
        $to = 'abadie.damien@devadam.com';

        // Sujet de l’email
        $subject = "Nouveau message de $prenom $nom via le formulaire de contact";

        // Corps de l’email
        $body = "Nom : $nom\nPrénom : $prenom\nEmail : $email\n\nMessage :\n$message";

        // En-têtes
        $headers = array('Content-Type: text/plain; charset=UTF-8');

        // Envoi
        if ( wp_mail($to, $subject, $body, $headers) ) {
            echo '<div class="confirmation">✅ Merci, votre message a bien été envoyé.</div>';
        } else {
            echo '<div class="erreur">❌ Une erreur est survenue, merci de réessayer.</div>';
        }
    }
}
add_action('wp_head', 'montheme_traitement_formulaire');


// 🔹 Définir une taille pour le premier article mis en avant
add_action('after_setup_theme', function() {
    add_image_size('personnalise', 1200, 400, true); // largeur 1200px, hauteur 400px, crop forcé
});

function mon_theme_add_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mon_theme_add_woocommerce_support' );


function mon_theme_enqueue_styles() {
    // Charger le style global
    wp_enqueue_style('theme-style', get_stylesheet_uri());

    // Charger le CSS de la fiche produit uniquement sur les pages produit
    if (is_product()) {
        wp_enqueue_style(
            'product-sheet-style',
            get_stylesheet_directory_uri() . '/assets/css/single-product.css',
            array('theme-style'), // dépend du style global
            filemtime(get_stylesheet_directory() . '/assets/css/single-product.css') // version auto = clear cache
        );
    }
}
add_action('wp_enqueue_scripts', 'mon_theme_enqueue_styles');

// Rafraîchir le compteur panier en AJAX
add_filter( 'woocommerce_add_to_cart_fragments', 'refresh_cart_count_ajax' );
function refresh_cart_count_ajax( $fragments ) {
    ob_start();
    ?>
    <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
    <?php
    $fragments['.cart-count'] = ob_get_clean();
    return $fragments;
}