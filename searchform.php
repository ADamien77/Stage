<?php
/**
 * searchform.php
 * Formulaire de recherche personnalisé pour remplacer celui par défaut de WP.
 */
?>

<form 
  role="search" 
  method="get" 
  class="search-form" 
  action="<?php echo esc_url( home_url( '/' ) ); ?>"
>
  <!-- Label caché pour accessibilité (lecteurs d'écran) -->
  <label for="search-field" class="screen-reader-text">
    <?php esc_html_e( 'Rechercher :', 'monthemeperso' ); ?>
  </label>

  <div class="search-field-wrap">
    <!-- Champ de recherche -->
    <input
      type="search"
      id="search-field"
      class="search-input"
      name="s"
      value="<?php echo get_search_query(); ?>"
      placeholder="<?php esc_attr_e( 'Rechercher…', 'monthemeperso' ); ?>"
      aria-label="<?php esc_attr_e( 'Recherche', 'monthemeperso' ); ?>"
    />

    <!-- Bouton de soumission avec icône loupe -->
    <button 
      type="submit" 
      class="search-submit" 
      aria-label="<?php esc_attr_e( 'Rechercher', 'monthemeperso' ); ?>"
    >
      <svg 
        width="20" 
        height="20" 
        viewBox="0 0 24 24" 
        aria-hidden="true" 
        focusable="false"
      >
        <path 
          d="M21 21l-4.35-4.35" 
          stroke="currentColor" 
          stroke-width="2" 
          stroke-linecap="round" 
          stroke-linejoin="round" 
          fill="none"
        />
        <circle 
          cx="10.5" 
          cy="10.5" 
          r="6.5" 
          stroke="currentColor" 
          stroke-width="2" 
          fill="none"
        />
      </svg>
    </button>
  </div>
</form>
