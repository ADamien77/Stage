<?php

/**
 * Fonctions principales du thème
 */

/* ==========================================================================
   1. Chargement des styles et scripts
   ========================================================================== */
function montheme_enqueue_assets()
{
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

// Charger des styles spécifiques WooCommerce
function mon_theme_enqueue_styles()
{
    // Charger le style global
    wp_enqueue_style('theme-style', get_stylesheet_uri());

    // Charger le CSS de la fiche produit uniquement sur les pages produit
    if (is_product()) {
        wp_enqueue_style(
            'product-sheet-style',
            get_stylesheet_directory_uri() . '/assets/css/single-product.css',
            array('theme-style'),
            filemtime(get_stylesheet_directory() . '/assets/css/single-product.css') // version dynamique pour vider le cache
        );
    }
}
add_action('wp_enqueue_scripts', 'mon_theme_enqueue_styles');


/* ==========================================================================
   2. Enregistrement des menus
   ========================================================================== */
function montheme_register_menus()
{
    register_nav_menus(array(
        'primary' => __('Menu principal', 'monthemeperso'), // Menu du header
        'footer'  => __('Menu pied de page', 'monthemeperso') // Menu du footer
    ));
}
add_action('after_setup_theme', 'montheme_register_menus');


/* ==========================================================================
   3. Activation des fonctionnalités natives WordPress
   ========================================================================== */
function montheme_theme_supports()
{
    // Balises <title> dynamiques
    add_theme_support('title-tag');

    // Logo personnalisé (ajout via le Customizer)
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Images à la une (featured image)
    add_theme_support('post-thumbnails');

    // Support HTML5 pour certains éléments
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption'
    ));
}
add_action('after_setup_theme', 'montheme_theme_supports');

// Définir une taille d’image personnalisée
add_action('after_setup_theme', function () {
    add_image_size('personnalise', 1200, 400, true); // largeur 1200px, hauteur 400px, crop forcé
});


/* ==========================================================================
   4. Compatibilité WooCommerce
   ========================================================================== */
function mon_theme_add_woocommerce_support()
{
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'mon_theme_add_woocommerce_support');

// Rafraîchir le compteur panier en AJAX
add_filter('woocommerce_add_to_cart_fragments', 'refresh_cart_count_ajax');
function refresh_cart_count_ajax($fragments)
{
    ob_start(); ?>
    <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
<?php
    $fragments['.cart-count'] = ob_get_clean();
    return $fragments;
}


/* ==========================================================================
   5. Traitement du formulaire de contact (en dur)
   ========================================================================== */
function montheme_traitement_formulaire()
{
    if (isset($_POST['form_contact'])) {

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
        if (wp_mail($to, $subject, $body, $headers)) {
            echo '<div class="confirmation">✅ Merci, votre message a bien été envoyé.</div>';
        } else {
            echo '<div class="erreur">❌ Une erreur est survenue, merci de réessayer.</div>';
        }
    }
}
add_action('wp_head', 'montheme_traitement_formulaire');


/* ==========================================================================
   6. Ajout de champs personnels au panier
   ========================================================================== */

// 1️⃣ Ajouter le champ avant le bouton "Ajouter au panier"
add_action('woocommerce_before_add_to_cart_button', 'ajouter_champ_image_gravure');
function ajouter_champ_image_gravure()
{
    global $product;

    // ID du produit spécifique (Gravure sur bois)
    if ($product->get_id() == 145) {
        echo '<div class="champ-image-gravure" style="margin-bottom:15px;">
                <label for="gravure_image">Téléversez votre image pour la gravure :</label><br>
                <input type="file" name="gravure_image" id="gravure_image" accept="image/*" />
              </div>';
    }
}

// 2️⃣ Valider le champ avant l’ajout au panier
add_filter('woocommerce_add_to_cart_validation', 'verifier_champ_image_gravure', 10, 3);
function verifier_champ_image_gravure($passed, $product_id, $quantity)
{

    // Vérification uniquement pour le produit ID 145
    if ($product_id == 145) {

        // ⚠ Vérifie que le fichier est envoyé
        if (empty($_FILES['gravure_image']['name'])) {
            wc_add_notice('⚠️ Merci de téléverser votre image pour la gravure.', 'error');
            return false;
        }

        // ⚠ Vérifie l’extension du fichier
        $allowed = array('jpg', 'jpeg', 'png', 'gif');
        $file_ext = pathinfo($_FILES['gravure_image']['name'], PATHINFO_EXTENSION);

        if (! in_array(strtolower($file_ext), $allowed)) {
            wc_add_notice('⚠️ Seules les images JPG, PNG ou GIF sont autorisées.', 'error');
            return false;
        }

        // ⚠ Vérifie le type MIME pour sécurité
        $file_type = wp_check_filetype($_FILES['gravure_image']['name']);
        if (strpos($file_type['type'], 'image') === false) {
            wc_add_notice('⚠️ Le fichier téléversé n’est pas une image valide.', 'error');
            return false;
        }
    }

    return $passed;
}

// 3️⃣ Ajouter le fichier en meta produit dans le panier
add_filter('woocommerce_add_cart_item_data', 'ajouter_meta_image_gravure', 10, 2);
function ajouter_meta_image_gravure($cart_item_data, $product_id)
{
    if ($product_id == 145 && ! empty($_FILES['gravure_image']['name'])) {
        // Téléverse le fichier dans wp-content/uploads
        $upload = wp_upload_bits($_FILES['gravure_image']['name'], null, file_get_contents($_FILES['gravure_image']['tmp_name']));
        if (! $upload['error']) {
            $cart_item_data['gravure_image'] = $upload['url']; // Stocke l’URL dans le panier
        }
    }
    return $cart_item_data;
}

// 4️⃣ Afficher l’image dans le panier et checkout
add_filter('woocommerce_get_item_data', 'afficher_meta_image_gravure', 10, 2);
function afficher_meta_image_gravure($item_data, $cart_item)
{
    if (isset($cart_item['gravure_image'])) {
        $item_data[] = array(
            'name'  => 'Image gravure',
            'value' => '<a href="' . esc_url($cart_item['gravure_image']) . '" target="_blank">Voir l’image</a>'
        );
    }
    return $item_data;
}

// 5️⃣ Sauvegarder l’image dans la commande
add_action('woocommerce_add_order_item_meta', 'sauvegarder_meta_image_gravure', 10, 2);
function sauvegarder_meta_image_gravure($item_id, $values)
{
    if (isset($values['gravure_image'])) {
        wc_add_order_item_meta($item_id, 'Image gravure', $values['gravure_image']);
    }
}
