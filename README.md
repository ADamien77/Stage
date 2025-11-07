# Site e-commerce – Artisan Bois

## Présentation du projet
Ce projet a été réalisé dans le cadre d’un **Titre Professionnel Developpeur Web et Web Mobile 2025** lors d’un **stage de développement web**.  
L’objectif était de **concevoir une boutique en ligne complète**, permettant à un artisan du bois de **vendre ses produits** mais également des **produits personnalisés** (plaques, gravures, etc.) avec des **options payantes configurables** directement sur la fiche produit.

Le projet repose sur **WordPress** et **WooCommerce**, et a nécessité la création d’un **thème sur mesure** codé en **PHP, HTML, CSS et JavaScript**.

---

## Objectifs du projet
- Créer un site e-commerce fonctionnel et responsive.  
- Intégrer un système de **personnalisation produit** avec upload d’image, message de gravure et options supplémentaires.  
- Mettre en place un **calcul automatique du prix** selon les options choisies.  
- Gérer le **panier, les commandes et le paiement** via WooCommerce.  
- Gérer une **interface administrateur** permettant de suivre les commandes.  
- Optimiser le thème pour une meilleure **expérience utilisateur (UX/UI)**.

---

## Technologies utilisées
| Outil / Langage | Rôle |
|------------------|------|
| **HTML5** | Structure du contenu |
| **CSS3** | Mise en forme et responsive design |
| **JavaScript** | Interactions et gestion dynamique des options |
| **PHP** | Logique serveur et intégration WordPress |
| **MySQL** | Base de données utilisée par WordPress |
| **WordPress** | CMS utilisé pour la gestion du site |
| **WooCommerce** | Extension e-commerce |
| **Local by Flywheel** | Environnement de développement local |

---

## Arborescence du projet
```
mon-theme/
│
├── assets/
│   ├── css/              → Feuilles de style principales
│   ├── img/              → Images du thème
│   └── js/               → Scripts JavaScript personnalisés
│
├── src/                  → Dossier contenant les modules PHP du thème
│   ├── contact-form.php          → Gestion du formulaire de contact
│   ├── enqueue-script.php        → Chargement des scripts et styles
│   ├── menus.php                 → Déclaration des menus de navigation
│   ├── product-gravure.php       → Personnalisation des produits gravés
│   ├── product-plaque.php        → Gestion des produits “plaques”
│   ├── search-redirect.php       → Optimisation et redirection de la recherche
│   ├── theme-supports.php        → Configuration du thème (logo, images à la une, etc.)
│   └── woocommerce-functions.php → Fonctions WooCommerce personnalisées
│
├── archive-product.php     → Modèle d’affichage des produits
├── footer.php              → Pied de page du site
├── functions.php           → Fichier principal du thème (inclusions des modules)
├── header.php              → En-tête du site
├── index.php               → Page d’accueil
├── page-*.php              → Pages personnalisées (panier, contact, blog, etc.)
├── search.php              → Page des résultats de recherche
├── single-product.php      → Fiche produit personnalisée
├── single-post.php         → Fiche article du blog
├── style.css               → Feuille de style principale du thème
└── README.md               → Documentation du projet
```

---

## Installation et configuration

1. **Installer WordPress** sur votre serveur local via *Local by Flywheel*.  
2. Cloner ou copier le dossier `mon-theme` dans :
   ```
   wp-content/themes/
   ```
3. Activer le thème depuis le **tableau de bord WordPress → Apparence → Thèmes**.  
4. Installer et activer le plugin **WooCommerce**.  
5. Configurer la boutique (produits, modes de paiement, transporteurs…).  
6. Créer les pages principales :
   - Accueil  
   - Boutique  
   - Panier / Commande  
   - Mon compte  
   - Contact  

7. Importer les produits.  
8. Tester le processus d’achat avec les options de personnalisation actives.

---

## Fonctionnalités principales

- Thème WordPress **entièrement développé sur mesure**  
- **Téléversement d’image** pour les produits à graver  
- Zone de **commentaire personnalisé** pour les instructions client  
- **Options payantes** (amélioration photo, texte au dos, emballage cadeau, cadre…)  
- **Calcul automatique du prix total** selon les options choisies  
- **Affichage des détails de personnalisation** dans le panier et la commande  
- Formulaire de contact fonctionnel (envoi via `wp_mail()`)  
- **Recherche optimisée** avec redirection automatique si correspondance exacte  
- **Compatibilité WooCommerce complète**  
- Code PHP modulaire via le dossier `/src`

---

## Points techniques notables
- Utilisation de `add_action()` et `add_filter()` pour étendre les fonctionnalités WordPress.  
- Gestion sécurisée des formulaires avec `sanitize_text_field()` et `sanitize_email()`.  
- Téléversement d’image via `wp_upload_bits()` et affichage du lien dans la commande.  
- Redirection dynamique avec `wp_redirect()` pour améliorer la navigation.  
- Application de suppléments tarifaires dans le panier via le hook `woocommerce_before_calculate_totals`.

---

## Interface administrateur
L’administration WooCommerce permet :
- de **consulter les commandes** avec toutes les informations de personnalisation,
- de **visualiser les images gravure envoyées** par les clients,
- et de **gérer les produits** personnalisés directement depuis le back-office WordPress.

---

## Auteur
**Nom :** Damien Abadie  
**Formation :** Titre Professionnel Developpeur Web et Web Mobile 2025  

---

## Conclusion
Ce projet m’a permis de renforcer mes compétences en **développement**, tout en apprenant à structurer un thème professionnel, à gérer la **sécurité des formulaires** et à proposer une **expérience utilisateur fluide et intuitive**.
