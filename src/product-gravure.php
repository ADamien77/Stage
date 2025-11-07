<?php
/* -----------------------------------------------------------
   💡 Champs personnalisés : ajout d’image et d’options gravure (produit ID 202)
   ----------------------------------------------------------- */

/**
 * 1️⃣ — Afficher les champs personnalisés sur la fiche produit
 */
add_action('woocommerce_before_add_to_cart_button', function () {
    global $product;

    // ✅ On cible uniquement le produit Gravure (ID 202)
    if (in_array($product->get_id(), [202, 217, 219])) {
?>
        <div class="champ-gravure">

            <!-- 🖼️ Upload image -->
            <label for="gravure_image"><strong>📷 Téléversez votre image pour la gravure :</strong></label><br>
            <input type="file" name="gravure_image" id="gravure_image" accept="image/*" />
            <p id="upload_message" style="display:none; color:green; font-weight:bold;">✅ Photo bien enregistrée</p><br>

            <!-- 📝 Message client -->
            <label for="gravure_commentaire"><strong>🖊️ Message pour la gravure :</strong></label><br>
            <textarea name="gravure_commentaire" id="gravure_commentaire" rows="3" placeholder="Vos consignes pour la gravure"></textarea><br>

            <!-- ⚙️ Options payantes -->
            <label><input type="checkbox" name="gravure_amelioration" value="oui"> ✅ Pour 3€ améliorer ma photo (retouche qualité)</label><br>
            <label><input type="checkbox" name="gravure_texte_dos" value="oui"> ✅ Pour 3€ ajouter un mot sur la photo ou au dos</label><br>

            <!-- 🖼️ Option cadre (sans supplément) -->
            <label><input type="checkbox" name="gravure_cadre" id="gravure_cadre" value="oui"> 🖼️ Avec cadre</label><br>

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

<?php
    }
});


/**
 * 2️⃣ — Validation avant ajout au panier
 */
add_filter('woocommerce_add_to_cart_validation', function ($passed, $product_id) {
    if (in_array($product_id, [202, 217, 219])) {
        if (empty($_FILES['gravure_image']['name'])) {
            wc_add_notice('⚠️ Merci de téléverser votre image pour la gravure.', 'error');
            return false;
        }

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
 * 3️⃣ — Sauvegarde des données dans le panier + gestion des prix
 */
add_filter('woocommerce_add_cart_item_data', function ($cart_item_data, $product_id) {
    if (in_array($product_id, [202, 217, 219])) {
        $extras = 0;

        if (!empty($_FILES['gravure_image']['name'])) {
            $upload = wp_upload_bits($_FILES['gravure_image']['name'], null, file_get_contents($_FILES['gravure_image']['tmp_name']));
            if (!$upload['error']) {
                $cart_item_data['gravure_image'] = $upload['url'];
            }
        }

        $fields = [
            'gravure_commentaire',
            'gravure_amelioration',
            'gravure_texte_dos',
            'gravure_dimension',
            'gravure_cadre',
            'gravure_cadeau',
            'gravure_message_cadeau',
        ];
        foreach ($fields as $field) {
            if (!empty($_POST[$field])) {
                $cart_item_data[$field] = sanitize_text_field($_POST[$field]);
            }
        }

        // 💰 Surcoûts
        if (!empty($_POST['gravure_amelioration'])) $extras += 3;
        if (!empty($_POST['gravure_texte_dos'])) $extras += 3;
        if (!empty($_POST['gravure_cadeau'])) $extras += 1;

        // 💰 Supplément "cadre"
        if (!empty($_POST['gravure_cadre'])) {
            $cadre_prices = [
                202 => 2,
                217 => 3,
                219 => 4,
            ];
            if (isset($cadre_prices[$product_id])) {
                $extras += $cadre_prices[$product_id];
            }
        }

        $cart_item_data['gravure_extra_price'] = $extras;
    }

    return $cart_item_data;
}, 10, 2);

/**
 * 4️⃣ — Appliquer le supplément au prix du panier
 */
add_action('woocommerce_before_calculate_totals', function ($cart) {
    if (is_admin() && !defined('DOING_AJAX')) return;
    foreach ($cart->get_cart() as $item) {
        if (isset($item['gravure_extra_price'])) {
            $item['data']->set_price($item['data']->get_price() + $item['gravure_extra_price']);
        }
    }
});

/**
 * 5️⃣ — Affichage panier / commande
 */
add_filter('woocommerce_get_item_data', function ($item_data, $cart_item) {
    $labels = [
        'gravure_image'         => 'Image gravure',
        'gravure_commentaire'   => 'Message client',
        'gravure_amelioration'  => 'Amélioration photo (+3€)',
        'gravure_texte_dos'     => 'Texte sur photo/dos (+3€)',
        'gravure_dimension'     => 'Dimension',
        'gravure_cadre'         => 'Cadre',
        'gravure_cadeau'        => 'Emballage cadeau (+1€)',
        'gravure_message_cadeau' => 'Message cadeau 💌',
    ];
    foreach ($labels as $key => $label) {
        if (!empty($cart_item[$key])) {
            $value = $cart_item[$key];
            if ($key === 'gravure_image') {
                $value = '<a href="' . esc_url($value) . '" target="_blank">Voir l’image</a>';
            }
            $item_data[] = ['name' => esc_html($label), 'value' => wp_kses_post($value)];
        }
    }
    return $item_data;
}, 10, 2);

/**
 * 6️⃣ — Sauvegarde dans la commande
 */
add_action('woocommerce_add_order_item_meta', function ($item_id, $values) {
    $fields = [
        'gravure_image'         => 'Image gravure',
        'gravure_commentaire'   => 'Message client',
        'gravure_amelioration'  => 'Amélioration photo (+3€)',
        'gravure_texte_dos'     => 'Texte sur photo/dos (+3€)',
        'gravure_dimension'     => 'Dimension',
        'gravure_cadre'         => 'Cadre',
        'gravure_cadeau'        => 'Emballage cadeau (+1€)',
        'gravure_message_cadeau' => 'Message cadeau 💌',
    ];
    foreach ($fields as $key => $label) {
        if (!empty($values[$key])) {
            wc_add_order_item_meta($item_id, $label, $values[$key]);
        }
    }
}, 10, 2);

/**
 * Ajoute l'attribut data-product-id au formulaire d'ajout au panier
 */
add_filter('woocommerce_product_add_to_cart_form_tag', function ($form_tag, $product) {
    if ($product && is_a($product, 'WC_Product')) {
        $product_id = $product->get_id();
        // On ajoute l'attribut data-product-id="123"
        $form_tag = str_replace(
            '<form',
            '<form data-product-id="' . esc_attr($product_id) . '"',
            $form_tag
        );
    }
    return $form_tag;
}, 10, 2);

/**
 * Forcer l'ajout de data-product-id sur le formulaire du produit
 */
add_action('woocommerce_before_add_to_cart_form', function () {
    global $product;

    // Ouvre un <div> avec l'attribut pour pouvoir le récupérer plus tard
    echo '<div id="js-product-data" data-product-id="' . esc_attr($product->get_id()) . '"></div>';
});
