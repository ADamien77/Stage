<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/assets/css/main.css">
  <title>Boutique artisanale</title>
</head>

<body>

  <?php get_header(); // appelle header.php 
  ?>

  <!-- HERO -->
  <section class="hero">
    <div class="button">
      <button>Découvrez notre boutique</button>
    </div>
    <div class="title">
      <h1>
        Gravure sur bois artisanale <br>
        Objets personnalisés et cadeaux originaux en bois
      </h1>
    </div>
  </section>

  <!-- PRESENTATION -->
  <section class="presentation">
    <div class="text">
      <h2>Découvrez l’art de la gravure sur bois artisanale et des créations faites main</h2>
      <p>
        Bienvenue dans l’univers de Alexandre, artisan passionné par le
        travail du bois et la gravure artisanale. Ici, chaque pièce est
        réalisée avec soin et authenticité, dans le respect des matières
        naturelles et d’un savoir-faire traditionnel. Spécialisé dans la
        gravure sur bois personnalisée, je crée des objets uniques qui
        racontent une histoire. Que vous recherchiez un cadeau original en
        bois, un objet décoratif gravé, ou encore un accessoire fait main
        comme des piques à cheveux en bois, vous trouverez dans ma boutique
        des créations artisanales durables et élégantes.
        <br><br>
        Mon atelier est dédié
        à la création artisanale en bois : je sélectionne des essences nobles
        pour fabriquer des articles qui allient esthétique et robustesse. La
        gravure sur bois personnalisée est mon activité principale : plaques
        gravées, décorations murales, bijoux en bois, accessoires et objets du
        quotidien. Chaque gravure est réalisée à la demande, ce qui vous
        garantit une pièce totalement unique.
        <br><br>
        Que vous soyez à la recherche
        d’un objet artisanal français, d’un cadeau personnalisé ou simplement
        d’un bel objet en bois fait main, vous êtes au bon endroit. Explorez
        mon univers et découvrez le mariage entre art, bois et tradition.
      </p>
    </div>
    <div class="cards">
      <div class="card_1">
        <h3>Sous titre h3</h3>
        <a href="">CTA</a>
      </div>
      <div class="card_2">
        <h3>Sous titre h3</h3>
        <a href="">CTA</a>
      </div>
    </div>
  </section>

  <!-- NOUVEAUTES -->
  <section class="nouveautes">
    <div class="title">
      <div class="separateur"></div>
      <h2>Nouveautés</h2>
      <div class="separateur"></div>
    </div>

    <div class="cards">
      <?php
      // Requête : récupérer les 3 derniers produits publiés
      $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 3,
        'orderby'        => 'date',
        'order'          => 'DESC',
      );

      $loop = new WP_Query($args);

      if ($loop->have_posts()) :
        while ($loop->have_posts()) : $loop->the_post();
          global $product;
      ?>
          <div class="card">
            <div class="image">
              <a href="<?php the_permalink(); ?>">
                <?php
                if (has_post_thumbnail()) {
                  the_post_thumbnail('medium');
                } else {
                  echo '<img src="' . wc_placeholder_img_src() . '" alt="Image produit" />';
                }
                ?>
              </a>
            </div>

            <div class="contenu">
              <h3><?php the_title(); ?></h3>

              <div class="avis">
                <?php
                // Affiche les étoiles WooCommerce si dispo
                if (wc_get_rating_html($product->get_average_rating())) {
                  echo wc_get_rating_html($product->get_average_rating());
                } else {
                  // Si pas d'avis, afficher 5 étoiles "vides"
                  for ($i = 0; $i < 5; $i++) {
                    echo '<img src="' . get_template_directory_uri() . '/assets/img/star.png" alt="Étoile de notation" />';
                  }
                }
                ?>
              </div>

              <div class="description">
                <p><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
              </div>
            </div>

            <div class="prix_bouton">
              <div class="prix">
                <p><?php echo $product->get_price_html(); ?></p>
              </div>
              <div class="bouton">
                <a href="<?php the_permalink(); ?>">Plus d'informations</a>
              </div>
            </div>
          </div>
      <?php
        endwhile;
      endif;
      wp_reset_postdata();
      ?>
    </div>
  </section>


  <!-- CONSEILS -->
  <section class="conseils">
    <div class="title">
      <div class="separateur"></div>
      <h2>Conseils du moment</h2>
      <div class="separateur"></div>
    </div>
    <div class="conseil">
      <h3>Entretenir vos objets en bois pour les garder comme neufs</h3>
      <p>
        Les objets en bois artisanaux méritent un entretien régulier pour conserver toute leur beauté.
        Pour nourrir le bois et le protéger, appliquez de temps en temps une fine couche d’huile naturelle
        (huile de lin, huile de noix ou cire d’abeille). Cela permet d’éviter le dessèchement, de raviver les couleurs
        et de prolonger la durée de vie de vos créations en bois fait main.
        <br><br>
        Évitez de laisser vos objets en bois au contact prolongé de l’eau ou exposés directement au soleil.
        Un simple nettoyage doux avec un chiffon sec ou légèrement humide suffit à préserver leur éclat naturel.
      </p>
    </div>
    <div class="button">
      <button>NOTRE BLOG</button>
    </div>
  </section>

  <!-- TEMOIGNAGES -->
  <section class="mur_temoignages">
    <div class="title">
      <div class="separateur"></div>
      <h2>Mur de témoignages</h2>
      <div class="separateur"></div>
    </div>
    <div class="temoignages">
      <!-- Témoignage 1 -->
      <div class="card">
        <div class="image">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/profil_1.png" alt="Photo de profil utilisateur" />
        </div>
        <div class="text">
          <h3>Nom Prénom (ou pseudo)</h3>
          <div class="avis">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/star.png" alt="Étoile de notation" />
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/star.png" alt="Étoile de notation" />
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/star.png" alt="Étoile de notation" />
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/star.png" alt="Étoile de notation" />
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/star.png" alt="Étoile de notation" />
          </div>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
        </div>
      </div>

      <!-- Témoignage 2 -->
      <div class="card">
        <div class="image">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/profil_2.png" alt="Photo de profil utilisateur" />
        </div>
        <div class="text">
          <h3>Nom Prénom (ou pseudo)</h3>
          <div class="avis">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/star.png" alt="Étoile de notation" />
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/star.png" alt="Étoile de notation" />
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/star.png" alt="Étoile de notation" />
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/star.png" alt="Étoile de notation" />
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/star.png" alt="Étoile de notation" />
          </div>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
        </div>
      </div>

      <!-- Témoignage 3 -->
      <div class="card">
        <div class="image">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/profil_3.png" alt="Photo de profil utilisateur" />
        </div>
        <div class="text">
          <h3>Nom Prénom (ou pseudo)</h3>
          <div class="avis">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/star.png" alt="Étoile de notation" />
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/star.png" alt="Étoile de notation" />
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/star.png" alt="Étoile de notation" />
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/star.png" alt="Étoile de notation" />
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/star.png" alt="Étoile de notation" />
          </div>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
        </div>
      </div>
    </div>
  </section>

  <?php get_footer(); // appelle footer.php 
  ?>

</body>

</html>