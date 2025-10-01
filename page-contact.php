<?php

/**
 * Template Name: Page Contact
 */

get_header(); // appelle header.php
?>

<div class="title_contact">
    <div class="separateur"></div>
    <h1><?php the_title(); ?></h1>
    <div class="separateur"></div>
</div>

<section class="contact">
    <div class="contenu">
        <div class="description">
            <p>Vous recherchez un artisan bois passionné capable de réaliser des pièces en bois sur mesure, qu’il s’agisse d’un petit élément de 1 cm ou d’une réalisation artisanale allant jusqu’à 1 mètre ? Vous êtes au bon endroit. Dans mon atelier de menuiserie artisanale, chaque projet est pensé pour répondre à vos besoins : objets en bois uniques, créations décoratives, accessoires pratiques ou pièces originales.</p>
            <h2>👉 Demande de devis bois personnalisé</h2>
            <p>Expliquez-moi vos attentes, vos dimensions et vos envies : je vous fournirai un devis clair et adapté. Grâce à un savoir-faire artisanal et un travail minutieux, chaque création est conçue pour allier authenticité, solidité et esthétique.</p>
            <h2>👉 Un échange direct avec votre artisan bois</h2>
            <p>📞 Contactez votre artisan bois dès aujourd’hui pour parler de votre projet et obtenir un devis gratuit et sans engagement.</p>
        </div>
        <div class="image">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/picture_contact.png" alt="Contact">
        </div>
    </div>
    <div class="formulaire">
        <form action="" method="post">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" required>

            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" id="prenom" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="message">Message</label>
            <textarea name="message" id="message" cols="30" rows="10" required></textarea>

            <!-- Champ caché pour savoir que c’est ce formulaire -->
            <input type="hidden" name="form_contact" value="1">

            <input class="bouton" type="submit" value="Envoyer">
        </form>
    </div>
</section>

<?php get_footer(); // appelle footer.php 
?>