// ======================================================
// ⚡ Script principal (header + galerie produit)
// ======================================================

document.addEventListener("DOMContentLoaded", () => {
  // Init header
  initHeaderEvents(); // burger + overlay recherche
  initSubmenus();     // sous-menus au clic

  // Init galerie produit
  initProductGallery();
});

// ======================================================
// 🔹 Gestion du burger et de la recherche overlay
// ======================================================
function initHeaderEvents() {
  const searchToggle = document.querySelector(".search-toggle");
  const searchOverlay = document.querySelector(".search-overlay");
  const burger = document.querySelector(".burger");
  const nav = document.querySelector("nav");

  // Toggle overlay recherche (mobile)
  if (searchToggle && searchOverlay) {
    searchToggle.addEventListener("click", (e) => {
      e.preventDefault();
      searchOverlay.classList.toggle("active"); // affiche/masque overlay
    });
  }

  // Toggle menu burger (mobile)
  if (burger && nav) {
    burger.addEventListener("click", () => {
      burger.classList.toggle("active"); // anime le burger
      nav.classList.toggle("open");      // ouvre/ferme la nav
    });
  }
}

// ======================================================
// 🔹 Gestion des sous-menus au clic
// ======================================================
function initSubmenus() {
  const submenuParents = document.querySelectorAll("nav .menu-item-has-children");

  submenuParents.forEach((parent) => {
    const link = parent.querySelector("a");

    link.addEventListener("click", (e) => {
      e.preventDefault();

      // Ferme les autres sous-menus
      submenuParents.forEach((other) => {
        if (other !== parent) other.classList.remove("open");
      });

      // Ouvre/ferme le sous-menu cliqué
      parent.classList.toggle("open");
    });
  });

  // Ferme les sous-menus si clic à l’extérieur
  document.addEventListener("click", (e) => {
    const nav = document.querySelector("nav");
    if (nav && !nav.contains(e.target)) {
      submenuParents.forEach((parent) => parent.classList.remove("open"));
    }
  });
}

// ======================================================
// 🔹 Utilitaires pour animations (slideUp / slideDown)
// ======================================================
function slideDown(element) {
  if (!element) return;
  element.style.display = "block";                  // visible
  const height = element.scrollHeight + "px";       // hauteur totale
  element.style.maxHeight = "0";                    // départ à 0
  element.offsetHeight;                             // force reflow
  element.style.transition = "max-height 0.3s ease";
  element.style.maxHeight = height;                 // anime vers la vraie hauteur

  // Après transition : enlever max-height fixe
  element.addEventListener("transitionend", function handler() {
    element.style.maxHeight = "none";
    element.removeEventListener("transitionend", handler);
  });
}

function slideUp(element) {
  if (!element) return;
  element.style.maxHeight = element.scrollHeight + "px"; // hauteur actuelle
  element.offsetHeight;                                  // force reflow
  element.style.transition = "max-height 0.3s ease";
  element.style.maxHeight = "0";                         // anime fermeture

  element.addEventListener("transitionend", function handler() {
    element.style.display = "none"; // cache après fermeture
    element.removeEventListener("transitionend", handler);
  });
}

// ======================================================
// 🔹 Galerie produit (image principale + miniatures)
// ======================================================
function initProductGallery() {
  const galerie = document.querySelector(".images_secondaires .track");
  const mainImage = document.querySelector(".image_principale img");
  if (!galerie || !mainImage) return;

  // ✅ Clic sur miniature => met en image principale
  galerie.querySelectorAll(".thumb").forEach((thumb) => {
    const thumbImg = thumb.querySelector("img");

    thumb.addEventListener("click", () => {
      if (!thumbImg) return;

      // Sauvegarde des sources
      const oldSrc = mainImage.getAttribute("src");
      const oldSrcset = mainImage.getAttribute("srcset");
      const newSrc = thumbImg.getAttribute("src");
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
