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
   💡 Champs personnalisés : ajout d’image et d’options gravure (produit ID 202)
   ----------------------------------------------------------- */

/**
 * 1️⃣ — Afficher les champs personnalisés sur la fiche produit
 */
add_action('woocommerce_before_add_to_cart_button', function() {
    global $product;

    // ✅ On cible uniquement le produit Gravure (ID 202)
    if ($product->get_id() == 202) {
        ?>
        <div class="champ-gravure" style="margin-bottom:20px;">

            <!-- 🖼️ Upload image -->
            <label for="gravure_image"><strong>📷 Téléversez votre image pour la gravure :</strong></label><br>
            <input type="file" name="gravure_image" id="gravure_image" accept="image/*" />
            <p id="upload_message" style="display:none; color:green; font-weight:bold;">✅ Photo bien enregistrée</p>

            <hr style="margin:15px 0;">

            <!-- 📝 Message client -->
            <label for="gravure_commentaire"><strong>🖊️ Message pour la gravure :</strong></label><br>
            <textarea name="gravure_commentaire" id="gravure_commentaire" rows="3" placeholder="Vos consignes pour la gravure"></textarea>

            <hr style="margin:15px 0;">

            <!-- ⚙️ Options payantes -->
            <label><input type="checkbox" name="gravure_amelioration" value="oui"> ✅ Pour 3€ améliorer ma photo (retouche qualité)</label><br>
            <label><input type="checkbox" name="gravure_texte_dos" value="oui"> ✅ Pour 3€ ajouter un mot sur la photo ou au dos</label><br>

            <hr style="margin:15px 0;">

            <!-- 📐 Choix dimension -->
            <label for="gravure_dimension"><strong>📏 Choisissez la dimension :</strong></label><br>
            <select name="gravure_dimension" id="gravure_dimension" required>
                <option value="">-- Sélectionnez une dimension --</option>
                <option value="10x15">10x15 cm</option>
                <option value="15x21">15x21 cm</option>
                <option value="20x30">20x30 cm</option>
            </select>

            <br><br>

            <!-- 🖼️ Choix avec/sans cadre -->
            <label for="gravure_cadre"><strong>🖼️ Avec ou sans cadre :</strong></label><br>
            <select name="gravure_cadre" id="gravure_cadre" required>
                <option value="">-- Choisissez une option --</option>
                <option value="avec_cadre">Avec cadre</option>
                <option value="sans_cadre">Sans cadre</option>
            </select>

            <hr style="margin:15px 0;">

            <!-- 🎁 Envoi personnalisé -->
            <label>
                <input type="checkbox" name="gravure_cadeau" id="gravure_cadeau" value="oui">
                🎁 Pour 1€ supplémentaire : emballage cadeau + carte message
            </label>

            <!-- ✍️ Message cadeau (affiché uniquement si case cochée) -->
            <div id="zone_message_cadeau" style="display:none; margin-top:10px;">
                <label for="gravure_message_cadeau"><strong>💌 Message à écrire sur la carte :</strong></label><br>
                <textarea name="gravure_message_cadeau" id="gravure_message_cadeau" rows="3" placeholder="Ex : Joyeux anniversaire, je pense à toi !"></textarea>
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('gravure_image');
            const uploadMsg = document.getElementById('upload_message');
            const cadeauCheckbox = document.getElementById('gravure_cadeau');
            const zoneMessageCadeau = document.getElementById('zone_message_cadeau');

            // ✅ Message quand une image est choisie
            if (fileInput) {
                fileInput.addEventListener('change', function() {
                    if (this.files.length > 0) uploadMsg.style.display = 'block';
                });
            }

            // ✅ Affiche ou cache le champ message cadeau
            if (cadeauCheckbox && zoneMessageCadeau) {
                cadeauCheckbox.addEventListener('change', function() {
                    zoneMessageCadeau.style.display = this.checked ? 'block' : 'none';
                });
            }

            // ✅ Vérifie que le fichier est bien sélectionné avant ajout au panier
            const form = document.querySelector('form.cart');
            if (form && fileInput) {
                form.addEventListener('submit', function(e) {
                    if (fileInput.files.length === 0) {
                        e.preventDefault();
                        alert("⚠️ Merci de téléverser une image avant d’ajouter le produit au panier.");
                        fileInput.focus();
                    }
                });
            }
        });
        </script>
        <?php
    }
});



/**
 * 2️⃣ — Validation avant ajout au panier
 */
add_filter('woocommerce_add_to_cart_validation', function($passed, $product_id) {
    if ($product_id == 202) {

        // Vérifie l’upload obligatoire
        if (empty($_FILES['gravure_image']['name'])) {
            wc_add_notice('⚠️ Merci de téléverser votre image pour la gravure.', 'error');
            return false;
        }

        // Vérifie le format
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $file_ext = strtolower(pathinfo($_FILES['gravure_image']['name'], PATHINFO_EXTENSION));

        if (!in_array($file_ext, $allowed)) {
            wc_add_notice('⚠️ Seules les images JPG, PNG ou GIF sont autorisées.', 'error');
            return false;
        }
    }

    return $passed;
}, 10, 2);



/**
 * 3️⃣ — Sauvegarder les données dans le panier
 */
add_filter('woocommerce_add_cart_item_data', function($cart_item_data, $product_id) {
    if ($product_id == 202) {

        // 📸 Image uploadée
        if (!empty($_FILES['gravure_image']['name'])) {
            $upload = wp_upload_bits(
                $_FILES['gravure_image']['name'],
                null,
                file_get_contents($_FILES['gravure_image']['tmp_name'])
            );
            if (!$upload['error']) {
                $cart_item_data['gravure_image'] = $upload['url'];
            }
        }

        // 🧾 Autres champs personnalisés
        $fields = [
            'gravure_commentaire',
            'gravure_amelioration',
            'gravure_texte_dos',
            'gravure_dimension',
            'gravure_cadre',
            'gravure_cadeau',
            'gravure_message_cadeau', // 💌 Nouveau champ
        ];

        foreach ($fields as $field) {
            if (!empty($_POST[$field])) {
                $cart_item_data[$field] = sanitize_text_field($_POST[$field]);
            }
        }
    }

    return $cart_item_data;
}, 10, 2);



/**
 * 4️⃣ — Afficher dans le panier et la commande
 */
add_filter('woocommerce_get_item_data', function($item_data, $cart_item) {
    $labels = [
        'gravure_image'         => 'Image gravure',
        'gravure_commentaire'   => 'Message client',
        'gravure_amelioration'  => 'Amélioration photo (+3€)',
        'gravure_texte_dos'     => 'Texte sur photo/dos (+3€)',
        'gravure_dimension'     => 'Dimension',
        'gravure_cadre'         => 'Cadre',
        'gravure_cadeau'        => 'Emballage cadeau (+1€)',
        'gravure_message_cadeau'=> 'Message cadeau 💌',
    ];

    foreach ($labels as $key => $label) {
        if (!empty($cart_item[$key])) {
            $value = $cart_item[$key];
            if ($key === 'gravure_image') {
                $value = '<a href="' . esc_url($value) . '" target="_blank">Voir l’image</a>';
            }
            $item_data[] = [
                'name'  => esc_html($label),
                'value' => wp_kses_post($value),
            ];
        }
    }

    return $item_data;
}, 10, 2);



/**
 * 5️⃣ — Sauvegarde des métadonnées dans la commande
 */
add_action('woocommerce_add_order_item_meta', function($item_id, $values) {
    $fields = [
        'gravure_image'         => 'Image gravure',
        'gravure_commentaire'   => 'Message client',
        'gravure_amelioration'  => 'Amélioration photo (+3€)',
        'gravure_texte_dos'     => 'Texte sur photo/dos (+3€)',
        'gravure_dimension'     => 'Dimension',
        'gravure_cadre'         => 'Cadre',
        'gravure_cadeau'        => 'Emballage cadeau (+1€)',
        'gravure_message_cadeau'=> 'Message cadeau 💌',
    ];

    foreach ($fields as $key => $label) {
        if (!empty($values[$key])) {
            wc_add_order_item_meta($item_id, $label, $values[$key]);
        }
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

/* -----------------------------------------------------------
   🪵 FICHE PRODUIT : PLAQUE DE PRÉNOM (ID = 204)
   ----------------------------------------------------------- */

/**
 * 1️⃣ — Afficher les champs personnalisés sur la fiche produit
 */
add_action('woocommerce_before_add_to_cart_button', function() {
    global $product;

    if ($product->get_id() == 204) {
        ?>
        <div class="plaque-prenom-options" style="margin-bottom:25px;">

            <!-- 🧾 Prénom à graver -->
            <label for="prenom_gravure"><strong>🔤 Prénom à graver :</strong></label><br>
            <input type="text" name="prenom_gravure" id="prenom_gravure" placeholder="Ex : Emma" required />

            <br><br>

            <!-- 💬 Message sous le prénom -->
            <label for="message_plaque"><strong>💬 Message (optionnel) :</strong></label><br>
            <input type="text" name="message_plaque" id="message_plaque" placeholder="Ex : Pour toujours dans nos cœurs" />

            <hr style="margin:15px 0;">

            <!-- ✍️ Choix police (libre) -->
<label for="police_plaque"><strong>✍️ Choisissez la police d’écriture :</strong></label><br>

<div class="champ-police">
  <input list="fonts_list" name="police_plaque" id="police_plaque" placeholder="Ex : Poppins, Roboto, Dancing Script" value="Poppins" autocomplete="off" />

</div>

<datalist id="fonts_list">
  <option value="Poppins">
  <option value="Roboto">
  <option value="Montserrat">
  <option value="Lato">
  <option value="Oswald">
  <option value="Raleway">
  <option value="Dancing Script">
  <option value="Playfair Display">
  <option value="Open Sans">
  <option value="Merriweather">
  <option value="Nunito">
  <option value="Bebas Neue">
  <option value="Caveat">
  <option value="Pacifico">
  <option value="Lobster">
  <option value="Indie Flower">
  <option value="Fjalla One">
  <option value="Amatic SC">
  <option value="Abril Fatface">
  <option value="Comfortaa">
  <option value="Arvo">
  <option value="Teko">
  <option value="Anton">
  <option value="Cormorant Garamond">
  <option value="Exo 2">
  <option value="Inconsolata">
  <option value="Kalam">
  <option value="Lobster Two">
  <option value="Maven Pro">
  <option value="Noto Sans">
  <option value="Orbitron">
  <option value="Patua One">
  <option value="Permanent Marker">
  <option value="Quicksand">
  <option value="Righteous">
  <option value="Rubik">
  <option value="Satisfy">
  <option value="Shadows Into Light">
  <option value="Signika">
  <option value="Tangerine">
  <option value="Titillium Web">
  <option value="Ubuntu">
  <option value="Varela Round">
  <option value="Zilla Slab">
  <!-- … tu peux en ajouter encore, jusqu’à ~300 sans problème -->
</datalist>

<small style="display:block;margin-top:6px;color:#666;">
  Tapez le nom d’une police Google Fonts (ex : <em>Poppins</em>). Si la police existe, elle sera chargée et appliquée à l’aperçu.
</small>


            <br><br>

            <!-- 🔠 Taille police -->
            <label for="taille_police"><strong>🔠 Taille du texte :</strong></label><br>
            <select name="taille_police" id="taille_police">
                <option value="small">Petite</option>
                <option value="medium" selected>Moyenne</option>
                <option value="large">Grande</option>
                <option value="xlarge">Très grande</option>
            </select>

            <hr style="margin:15px 0;">

            <!-- 📏 Épaisseur -->
            <label><strong>📏 Choisissez l’épaisseur :</strong></label><br>
            <label><input type="radio" name="epaisseur_plaque" value="0.2" checked> 0.2 cm</label><br>
            <label><input type="radio" name="epaisseur_plaque" value="0.5"> 0.5 cm</label>

            <hr style="margin:15px 0;">

            <!-- 🧮 Simulateur -->
            <div class="simulateur-plaque">
                <h4>🧮 Aperçu du rendu :</h4>
                <div id="preview_plaque" style="
                    margin-top:10px;
                    padding:20px;
                    text-align:center;
                    border:2px dashed #ccc;
                    border-radius:10px;
                    background:#f8f8f8;
                    font-family:'Poppins', sans-serif;
                    font-size:24px;
                    transition: all 0.3s ease;">
                    Votre texte s’affichera ici
                </div>
            </div>

        </div>
        <?php
    }
});

/**
 * 2️⃣ — Sauvegarde des données dans le panier
 */
add_filter('woocommerce_add_cart_item_data', function($cart_item_data, $product_id) {

    if ($product_id == 204) {
        $fields = [
            'prenom_gravure',
            'message_plaque',
            'police_plaque',
            'taille_police',
            'epaisseur_plaque',
        ];

        foreach ($fields as $field) {
            if (!empty($_POST[$field])) {
                $cart_item_data[$field] = sanitize_text_field($_POST[$field]);
            }
        }
    }

    return $cart_item_data;
}, 10, 2);

/**
 * 3️⃣ — Affichage des infos dans le panier et la commande
 */
add_filter('woocommerce_get_item_data', function($item_data, $cart_item) {
    $labels = [
        'prenom_gravure'   => 'Prénom à graver',
        'message_plaque'   => 'Message',
        'police_plaque'    => 'Police d’écriture',
        'taille_police'    => 'Taille du texte',
        'epaisseur_plaque' => 'Épaisseur (cm)',
    ];

    foreach ($labels as $key => $label) {
        if (!empty($cart_item[$key])) {
            $item_data[] = [
                'name'  => esc_html($label),
                'value' => esc_html($cart_item[$key]),
            ];
        }
    }

    return $item_data;
}, 10, 2);

/**
 * 4️⃣ — Sauvegarde dans les métadonnées de commande
 */
add_action('woocommerce_add_order_item_meta', function($item_id, $values) {
    $fields = [
        'prenom_gravure'   => 'Prénom à graver',
        'message_plaque'   => 'Message',
        'police_plaque'    => 'Police d’écriture',
        'taille_police'    => 'Taille du texte',
        'epaisseur_plaque' => 'Épaisseur (cm)',
    ];

    foreach ($fields as $key => $label) {
        if (!empty($values[$key])) {
            wc_add_order_item_meta($item_id, $label, $values[$key]);
        }
    }
}, 10, 2);
