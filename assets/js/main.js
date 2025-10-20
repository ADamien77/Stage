// ======================================================
// ⚡ Script principal du thème
// - Gère le header (burger + recherche + sous-menus)
// - Gère la galerie produit (image principale + miniatures)
// ======================================================

document.addEventListener("DOMContentLoaded", () => {
  initHeaderEvents();   // Gestion du burger + overlay recherche
  initSubmenus();       // Gestion des sous-menus
  initProductGallery(); // Gestion de la galerie produit
});


// ======================================================
// 🔹 1. Gestion du burger et de la recherche overlay
// ======================================================
function initHeaderEvents() {
  const searchToggle   = document.querySelector(".search-toggle");  // Bouton loupe
  const searchOverlay  = document.querySelector(".search-overlay"); // Overlay recherche
  const burger         = document.querySelector(".burger");         // Bouton burger
  const nav            = document.querySelector("nav");             // Navigation principale

  // Toggle overlay recherche (mobile)
  if (searchToggle && searchOverlay) {
    searchToggle.addEventListener("click", (e) => {
      e.preventDefault();
      searchOverlay.classList.toggle("active"); // affiche/masque l’overlay
    });
  }

  // Toggle menu burger (mobile)
  if (burger && nav) {
    burger.addEventListener("click", () => {
      burger.classList.toggle("active"); // animation du burger
      nav.classList.toggle("open");      // ouverture/fermeture nav
    });
  }
}


// ======================================================
// 🔹 2. Gestion des sous-menus (au clic)
// ======================================================
function initSubmenus() {
  const submenuParents = document.querySelectorAll("nav .menu-item-has-children");

  // Ouverture / fermeture au clic
  submenuParents.forEach((parent) => {
    const link = parent.querySelector("a");

    link.addEventListener("click", (e) => {
      e.preventDefault();

      // Ferme tous les autres sous-menus
      submenuParents.forEach((other) => {
        if (other !== parent) other.classList.remove("open");
      });

      // Ouvre/ferme le sous-menu cliqué
      parent.classList.toggle("open");
    });
  });

  // Ferme tous les sous-menus si clic en dehors de la nav
  document.addEventListener("click", (e) => {
    const nav = document.querySelector("nav");
    if (nav && !nav.contains(e.target)) {
      submenuParents.forEach((parent) => parent.classList.remove("open"));
    }
  });
}


// ======================================================
// 🔹 3. Utilitaires pour animations (slideUp / slideDown)
// ======================================================
function slideDown(element) {
  if (!element) return;

  element.style.display = "block";                  // rendre visible
  const height = element.scrollHeight + "px";       // récupérer hauteur
  element.style.maxHeight = "0";                    // départ fermé
  element.offsetHeight;                             // forcer reflow
  element.style.transition = "max-height 0.3s ease";
  element.style.maxHeight = height;                 // ouverture animée

  // Après animation, reset max-height
  element.addEventListener("transitionend", function handler() {
    element.style.maxHeight = "none";
    element.removeEventListener("transitionend", handler);
  });
}

function slideUp(element) {
  if (!element) return;

  element.style.maxHeight = element.scrollHeight + "px"; // départ ouvert
  element.offsetHeight;                                  // forcer reflow
  element.style.transition = "max-height 0.3s ease";
  element.style.maxHeight = "0";                         // fermeture animée

  element.addEventListener("transitionend", function handler() {
    element.style.display = "none"; // cacher après animation
    element.removeEventListener("transitionend", handler);
  });
}


// ======================================================
// 🔹 4. Galerie produit (image principale + miniatures)
// ======================================================
function initProductGallery() {
  const galerie   = document.querySelector(".images_secondaires .track"); // conteneur des miniatures
  const mainImage = document.querySelector(".image_principale img");      // image principale

  if (!galerie || !mainImage) return;

  // ✅ Clic sur miniature => met en image principale
  galerie.querySelectorAll(".thumb").forEach((thumb) => {
    const thumbImg = thumb.querySelector("img");

    thumb.addEventListener("click", () => {
      if (!thumbImg) return;

      // Sauvegarde des sources actuelles
      const oldSrc    = mainImage.getAttribute("src");
      const oldSrcset = mainImage.getAttribute("srcset");
      const newSrc    = thumbImg.getAttribute("src");
      const newSrcset = thumbImg.getAttribute("srcset");

      // ⚡ Swap (échange image principale <-> miniature)
      mainImage.setAttribute("src", newSrc);
      if (newSrcset) {
        mainImage.setAttribute("srcset", newSrcset);
      } else {
        mainImage.removeAttribute("srcset");
      }

      thumbImg.setAttribute("src", oldSrc);
      if (oldSrcset) {
        thumbImg.setAttribute("srcset", oldSrcset);
      } else {
        thumbImg.removeAttribute("srcset");
      }
    });
  });
}

document.addEventListener('DOMContentLoaded', function() {
  const accountIcon = document.getElementById('account-icon');
  const mobileMenu = document.getElementById('mobile-account-menu');

  if (!accountIcon || !mobileMenu) return;

  accountIcon.addEventListener('click', function(e) {
    if (window.innerWidth <= 1024) { // Mobile/tablette
      e.preventDefault();
      mobileMenu.classList.toggle('active');
    }
    // sinon, comportement normal : lien vers la page Mon Compte
  });

  // Fermer le menu si clic à l’extérieur
  document.addEventListener('click', function(e) {
    if (
      mobileMenu.classList.contains('active') &&
      !mobileMenu.contains(e.target) &&
      e.target !== accountIcon
    ) {
      mobileMenu.classList.remove('active');
    }
  });
});

document.addEventListener('DOMContentLoaded', function() {
  const form = document.querySelector('form.cart');
  const fileInput = document.getElementById('gravure_image');
  const uploadMsg = document.getElementById('upload_message');

  // Si le champ existe (produit gravure)
  if (fileInput) {

    // ✅ Affiche un message quand l’image est sélectionnée
    fileInput.addEventListener('change', function() {
      if (this.files.length > 0) uploadMsg.style.display = 'block';
      else uploadMsg.style.display = 'none';
    });

    // ✅ Bloque l’ajout au panier si aucune image
    if (form) {
      form.addEventListener('submit', function(e) {
        if (fileInput.files.length === 0) {
          e.preventDefault();
          alert("⚠️ Merci de téléverser une image avant d’ajouter le produit au panier.");
          fileInput.focus();
        }
      });
    }
  }
});

/* -----------------------------------------------------------
   🎨 Simulateur : chargement dynamique d'une Google Font choisie
   ----------------------------------------------------------- */

document.addEventListener('DOMContentLoaded', function() {
  const prenomInput = document.getElementById('prenom_gravure');
  const messageInput = document.getElementById('message_plaque');
  const policeInput = document.getElementById('police_plaque'); // maintenant input libre
  const tailleSelect = document.getElementById('taille_police');
  const preview = document.getElementById('preview_plaque');

  // Garde trace du <link> injecté pour éviter duplications
  let currentFontLinkId = 'dynamic-google-font';

  // Fonction qui injecte (ou remplace) le link Google Fonts dans le head
  function loadGoogleFont(family) {
    if (!family) return;

    // Normalise le nom pour l'URL Google Fonts : remplace les espaces par +
    const familyForUrl = family.trim().replace(/\s+/g, '+');

    const href = `https://fonts.googleapis.com/css2?family=${encodeURIComponent(familyForUrl)}:wght@400;700&display=swap`;

    // Supprime l'ancien link si existant
    const existing = document.getElementById(currentFontLinkId);
    if (existing) existing.parentNode.removeChild(existing);

    // Crée un nouveau link
    const link = document.createElement('link');
    link.id = currentFontLinkId;
    link.rel = 'stylesheet';
    link.href = href;
    document.head.appendChild(link);

    // Note : si la police n'existe pas sur Google Fonts, le navigateur utilisera le fallback.
  }

  // Met à jour l'aperçu : police, taille, prénom, message
  function updatePreview() {
    if (!preview) return;

    const prenom = prenomInput && prenomInput.value ? prenomInput.value : 'Votre texte ici';
    const message = messageInput && messageInput.value ? `<br><small>${escapeHtml(messageInput.value)}</small>` : '';
    const police = policeInput && policeInput.value ? policeInput.value.trim() : 'Poppins';
    const taille = tailleSelect && tailleSelect.value ? tailleSelect.value : 'medium';

    // Charge la police dynamiquement depuis Google Fonts
    if (police) loadGoogleFont(police);

    // Applique la police au preview (avec fallback)
    preview.style.fontFamily = `'${police}', sans-serif`;

    // Applique la taille
    let fontSize = '24px';
    if (taille === 'small') fontSize = '18px';
    if (taille === 'medium') fontSize = '24px';
    if (taille === 'large') fontSize = '32px';
    if (taille === 'xlarge') fontSize = '40px';
    preview.style.fontSize = fontSize;

    // Affiche
    preview.innerHTML = `${escapeHtml(prenom)}${message}`;
  }

  // Petit utilitaire pour échapper le HTML (sécurité)
  function escapeHtml(text) {
    const map = {
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#039;'
    };
    return String(text).replace(/[&<>"']/g, function(m) { return map[m]; });
  }

  // Écouteurs : entrée texte, police, taille
  [prenomInput, messageInput, policeInput, tailleSelect].forEach(el => {
    if (el) el.addEventListener('input', updatePreview);
  });

  // Initialisation
  updatePreview();
});

