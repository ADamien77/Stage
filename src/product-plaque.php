<?php 
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
