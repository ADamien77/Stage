<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/main.css" />
    <title>A propos</title>
  </head>
  <body>
<?php get_header(); // appelle header.php ?>
    <div class="title_about">
      <div class="separateur"></div>
      <h1>Au coeur de notre atelier</h1>
      <div class="separateur"></div>
    </div>
    <section class="qui_sommes_nous">
      <div class="contenu">
        <h2>Qui sommes-nous ?</h2>
        <p>
          In feugiat tempor placerat. Aliquam suscipit, quam in finibus gravida,
          ex lorem consequat nisl, sit amet suscipit est mi at odio. Maecenas
          scelerisque finibus nisl, quis varius sem pretium egestas. Vivamus
          fringilla eros at quam malesuada efficitur. Vivamus ex turpis,
          fermentum sed magna sit amet, dapibus rutrum enim. Sed laoreet posuere
          tortor eu tincidunt. Quisque facilisis nulla sed risus fringilla
          tempus. Duis pretium viverra orci, nec mollis metus lacinia id.
          Integer vitae dapibus nibh. Ut dictum varius metus in aliquam.
          Phasellus ut condimentum urna, ac bibendum turpis. Proin sollicitudin
          metus id turpis posuere pulvinar. Proin tristique ante quis leo
          malesuada fermentum eget eget ligula. Fusce accumsan vitae nibh vel
          volutpat. Suspendisse dictum, orci ut ultrices pulvinar, est mauris
          condimentum purus, at accumsan libero leo eget dui.
        </p>
      </div>
      <div class="image">
         <img src="<?php echo get_template_directory_uri(); ?>/assets/img/qui_sommes_nous.png" alt="Photo de profil utilisateur" />
    </div>
    </section>
    <div class="separateur"></div>
    <section class="notre_histoire">
        <div class="contenu">
            <h2>Notre histoire</h2>
            <p>In feugiat tempor placerat. Aliquam suscipit, quam in finibus gravida, ex lorem consequat nisl, sit amet suscipit est mi at odio. Maecenas scelerisque finibus nisl, quis varius sem pretium egestas. Vivamus fringilla eros at quam malesuada efficitur. Vivamus ex turpis, fermentum sed magna sit amet, dapibus rutrum enim. Sed laoreet posuere tortor eu tincidunt. Quisque facilisis nulla sed risus fringilla tempus. Duis pretium viverra orci, nec mollis metus lacinia id. Integer vitae dapibus nibh. Ut dictum varius metus in aliquam. Phasellus ut condimentum urna, ac bibendum turpis. Proin sollicitudin metus id turpis posuere pulvinar. Proin tristique ante quis leo malesuada fermentum eget eget ligula. Fusce accumsan vitae nibh vel volutpat. Suspendisse dictum, orci ut ultrices pulvinar, est mauris condimentum purus, at accumsan libero leo eget dui.</p>
        </div>
    </section>
    <div class="separateur"></div>
    <section class="notre_boutique">
        <div class="contenu">
            <h2>Notre boutique</h2>
            <p>In feugiat tempor placerat. Aliquam suscipit, quam in finibus gravida, ex lorem consequat nisl, sit amet suscipit est mi at odio. Maecenas scelerisque finibus nisl, quis varius sem pretium egestas. Vivamus fringilla eros at quam malesuada efficitur. Vivamus ex turpis, fermentum sed magna sit amet, dapibus rutrum enim. Sed laoreet posuere tortor eu tincidunt. Quisque facilisis nulla sed risus fringilla tempus. Duis pretium viverra orci, nec mollis metus lacinia id. Integer vitae dapibus nibh. Ut dictum varius metus in aliquam. Phasellus ut condimentum urna, ac bibendum turpis. Proin sollicitudin metus id turpis posuere pulvinar. Proin tristique ante quis leo malesuada fermentum eget eget ligula. Fusce accumsan vitae nibh vel volutpat. Suspendisse dictum, orci ut ultrices pulvinar, est mauris condimentum purus, at accumsan libero leo eget dui.</p>
        </div>
        <div class="bouton">
            <a href="/public/pages/products.html">NOTRE BOUTIQUE</a>
        </div>
    </section>
    <div class="separateur"></div>
    <section class="contact_about">
        <div class="contenu">
            <h2>Comment nous contacter ?</h2>
            <p>In feugiat tempor placerat. Aliquam suscipit, quam in finibus gravida, ex lorem consequat nisl, sit amet suscipit est mi at odio. Maecenas scelerisque finibus nisl, quis varius sem pretium egestas. Vivamus fringilla eros at quam malesuada efficitur. Vivamus ex turpis, fermentum sed magna sit amet, dapibus rutrum enim. Sed laoreet posuere tortor eu tincidunt. Quisque facilisis nulla sed risus fringilla tempus. Duis pretium viverra orci, nec mollis metus lacinia id. Integer vitae dapibus nibh. Ut dictum varius metus in aliquam. Phasellus ut condimentum urna, ac bibendum turpis. Proin sollicitudin metus id turpis posuere pulvinar. Proin tristique ante quis leo malesuada fermentum eget eget ligula. Fusce accumsan vitae nibh vel volutpat. Suspendisse dictum, orci ut ultrices pulvinar, est mauris condimentum purus, at accumsan libero leo eget dui.</p>
        </div>
        <div class="bouton">
            <a href="/public/pages/contact.html">NOUS CONTACTER</a>
        </div>
    </section>
<?php get_footer(); // appelle footer.php ?>
  </body>
</html>
