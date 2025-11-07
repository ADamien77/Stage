/* ======================================================
   ⚡ Script principal du thème
   ------------------------------------------------------
   - Header : burger, recherche, sous-menus
   - Galerie produit : image principale + miniatures
   - Menu "Mon compte" mobile
   - Gestion gravure : image, texte, polices, options
   - Prix dynamiques sur les produits gravure
   ====================================================== */

document.addEventListener("DOMContentLoaded", () => {

  /* ======================================================
     🔹 1. Header : burger + overlay recherche
     ====================================================== */
  function initHeaderEvents() {
    const searchToggle  = document.querySelector(".search-toggle");   // Bouton loupe
    const searchOverlay = document.querySelector(".search-overlay");  // Overlay recherche
    const burger        = document.querySelector(".burger");          // Bouton burger
    const nav           = document.querySelector("nav");              // Menu principal

    // Toggle overlay recherche (mobile)
    if (searchToggle && searchOverlay) {
      searchToggle.addEventListener("click", (e) => {
        e.preventDefault();
        searchOverlay.classList.toggle("active");
      });
    }

    // Toggle menu burger (mobile)
    if (burger && nav) {
      burger.addEventListener("click", () => {
        burger.classList.toggle("active");
        nav.classList.toggle("open");
      });
    }
  }

  /* ======================================================
     🔹 2. Navigation : sous-menus
     ====================================================== */
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

        // Ouvre/ferme celui cliqué
        parent.classList.toggle("open");
      });
    });

    // Ferme si clic à l’extérieur
    document.addEventListener("click", (e) => {
      const nav = document.querySelector("nav");
      if (nav && !nav.contains(e.target)) {
        submenuParents.forEach((parent) => parent.classList.remove("open"));
      }
    });
  }

  /* ======================================================
     🔹 3. Galerie produit : image principale + miniatures
     ====================================================== */
  function initProductGallery() {
    const galerie   = document.querySelector(".images_secondaires .track");
    const mainImage = document.querySelector(".image_principale img");
    if (!galerie || !mainImage) return;

    galerie.querySelectorAll(".thumb").forEach((thumb) => {
      const thumbImg = thumb.querySelector("img");
      thumb.addEventListener("click", () => {
        if (!thumbImg) return;

        // Sauvegarde des sources actuelles
        const oldSrc = mainImage.getAttribute("src");
        const oldSrcset = mainImage.getAttribute("srcset");
        const newSrc = thumbImg.getAttribute("src");
        const newSrcset = thumbImg.getAttribute("srcset");

        // Échange image principale ↔ miniature
        mainImage.setAttribute("src", newSrc);
        if (newSrcset) mainImage.setAttribute("srcset", newSrcset);
        else mainImage.removeAttribute("srcset");

        thumbImg.setAttribute("src", oldSrc);
        if (oldSrcset) thumbImg.setAttribute("srcset", oldSrcset);
        else thumbImg.removeAttribute("srcset");
      });
    });
  }

  /* ======================================================
     🔹 4. Menu "Mon compte" mobile
     ====================================================== */
  function initAccountMenu() {
    const accountIcon = document.getElementById("account-icon");
    const mobileMenu = document.getElementById("mobile-account-menu");
    if (!accountIcon || !mobileMenu) return;

    accountIcon.addEventListener("click", function(e) {
      if (window.innerWidth <= 1024) { // Mobile/tablette
        e.preventDefault();
        mobileMenu.classList.toggle("active");
      }
    });

    // Fermer si clic à l’extérieur
    document.addEventListener("click", function(e) {
      if (
        mobileMenu.classList.contains("active") &&
        !mobileMenu.contains(e.target) &&
        e.target !== accountIcon
      ) {
        mobileMenu.classList.remove("active");
      }
    });
  }

  /* ======================================================
     🔹 5. Upload image gravure
     ====================================================== */
  function initFileUpload() {
    const form = document.querySelector("form.cart");
    const fileInput = document.getElementById("gravure_image");
    const uploadMsg = document.getElementById("upload_message");

    if (fileInput) {
      fileInput.addEventListener("change", function() {
        uploadMsg.style.display = this.files.length > 0 ? "block" : "none";
      });

      if (form) {
        form.addEventListener("submit", function(e) {
          if (fileInput.files.length === 0) {
            e.preventDefault();
            alert("⚠️ Merci de téléverser une image avant d’ajouter le produit au panier.");
            fileInput.focus();
          }
        });
      }
    }
  }

  /* ======================================================
     🔹 6. Simulateur de gravure (texte + police)
     ====================================================== */
  function initFontPreview() {
    const prenomInput = document.getElementById("prenom_gravure");
    const messageInput = document.getElementById("message_plaque");
    const policeInput = document.getElementById("police_plaque");
    const tailleSelect = document.getElementById("taille_police");
    const preview = document.getElementById("preview_plaque");
    let currentFontLinkId = "dynamic-google-font";

    function loadGoogleFont(family) {
      if (!family) return;
      const familyForUrl = family.trim().replace(/\s+/g, "+");
      const href = `https://fonts.googleapis.com/css2?family=${encodeURIComponent(familyForUrl)}:wght@400;700&display=swap`;

      const existing = document.getElementById(currentFontLinkId);
      if (existing) existing.remove();

      const link = document.createElement("link");
      link.id = currentFontLinkId;
      link.rel = "stylesheet";
      link.href = href;
      document.head.appendChild(link);
    }

    function escapeHtml(text) {
      const map = { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#039;" };
      return String(text).replace(/[&<>"']/g, (m) => map[m]);
    }

    function updatePreview() {
      if (!preview) return;

      const prenom = prenomInput?.value || "Votre texte ici";
      const message = messageInput?.value ? `<br><small>${escapeHtml(messageInput.value)}</small>` : "";
      const police = policeInput?.value?.trim() || "Poppins";
      const taille = tailleSelect?.value || "medium";

      loadGoogleFont(police);
      preview.style.fontFamily = `'${police}', sans-serif`;

      const tailles = { small: "18px", medium: "24px", large: "32px", xlarge: "40px" };
      preview.style.fontSize = tailles[taille] || "24px";

      preview.innerHTML = `${escapeHtml(prenom)}${message}`;
    }

    [prenomInput, messageInput, policeInput, tailleSelect].forEach((el) => {
      if (el) el.addEventListener("input", updatePreview);
    });

    updatePreview();
  }

  /* ======================================================
     🔹 7. Options cadeau / vérifications
     ====================================================== */
  function initGiftOptions() {
    const fileInput = document.getElementById("gravure_image");
    const uploadMsg = document.getElementById("upload_message");
    const cadeauCheckbox = document.getElementById("gravure_cadeau");
    const zoneMessageCadeau = document.getElementById("zone_message_cadeau");
    const form = document.querySelector("form.cart");

    if (fileInput) {
      fileInput.addEventListener("change", function() {
        if (this.files.length > 0) uploadMsg.style.display = "block";
      });
    }

    if (cadeauCheckbox && zoneMessageCadeau) {
      cadeauCheckbox.addEventListener("change", function() {
        zoneMessageCadeau.style.display = this.checked ? "block" : "none";
      });
    }

    if (form && fileInput) {
      form.addEventListener("submit", function(e) {
        if (fileInput.files.length === 0) {
          e.preventDefault();
          alert("⚠️ Merci de téléverser une image avant d’ajouter le produit au panier.");
          fileInput.focus();
        }
      });
    }
  }

  /* ======================================================
     🔹 8. Prix dynamiques (options gravure)
     ====================================================== */
  function initDynamicPricing() {
    const form = document.querySelector("form.cart");
    if (!form) return;

    // ID produit : récupéré depuis plusieurs sources possibles
    let productId =
      parseInt(form.dataset.productId) ||
      parseInt(document.querySelector("#js-product-data")?.dataset.productId) ||
      parseInt(form.querySelector('input[name="product_id"]')?.value) ||
      NaN;

    // Élément de prix
    let priceElement =
      document.querySelector(".woocommerce-Price-amount bdi") ||
      document.querySelector(".price .amount") ||
      document.querySelector(".price");

    if (!priceElement) return;

    function parsePrice(text) {
      if (!text) return NaN;
      const cleaned = text.replace(/[^\d.,-]/g, "").replace(/\s/g, "");
      if (cleaned.includes(",") && cleaned.includes(".")) {
        return parseFloat(cleaned.replace(/\./g, "").replace(",", "."));
      }
      return parseFloat(cleaned.replace(",", "."));
    }

    const rawPriceText = priceElement.innerText || priceElement.textContent;
    let basePrice = parsePrice(rawPriceText) || 0;

    // Suppléments spécifiques pour les cadres
    const cadrePrices = { 202: 2, 217: 3, 219: 4 };
    const cadreCheckbox = form.querySelector("#gravure_cadre") || form.querySelector('input[name="gravure_cadre"]');
    const checkboxes = form.querySelectorAll(".champ-gravure input[type='checkbox']");

    function updatePrice() {
      let total = basePrice;

      if (form.querySelector('input[name="gravure_amelioration"]:checked')) total += 3;
      if (form.querySelector('input[name="gravure_texte_dos"]:checked')) total += 3;
      if (form.querySelector('input[name="gravure_cadeau"]:checked')) total += 1;

      if (cadreCheckbox?.checked) {
        const add = cadrePrices[productId] ?? 2;
        total += add;
      }

      const formatted = total.toFixed(2).replace(".", ",") + " €";
      const innerBdi = priceElement.querySelector("bdi");
      if (innerBdi) innerBdi.textContent = formatted;
      else priceElement.textContent = formatted;
    }

    if (checkboxes.length) {
      checkboxes.forEach((box) => box.addEventListener("change", updatePrice));
    } else {
      form.addEventListener("change", updatePrice);
    }

    updatePrice();
  }

  // Initialisation des fonctions
  initHeaderEvents();
  initSubmenus();
  initProductGallery();
  initAccountMenu();
  initFileUpload();
  initFontPreview();
  initGiftOptions();
  initDynamicPricing();

});
