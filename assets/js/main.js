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
