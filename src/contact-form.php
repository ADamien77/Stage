<?php 
/* ==========================================================================
   5️⃣ — FORMULAIRE DE CONTACT PERSONNALISÉ
   ========================================================================== */

/**
 * Traitement du formulaire de contact "en dur"
 */
function montheme_traitement_formulaire() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_contact'])) {

        $nom     = isset($_POST['nom'])     ? sanitize_text_field($_POST['nom'])     : '';
        $prenom  = isset($_POST['prenom'])  ? sanitize_text_field($_POST['prenom'])  : '';
        $email   = isset($_POST['email'])   ? sanitize_email($_POST['email'])        : '';
        $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';

        $to      = 'abadie.damien@devadam.fr';
        $subject = "Nouveau message de $prenom $nom via le formulaire de contact";
        $body    = "Nom : $nom\nPrénom : $prenom\nEmail : $email\n\nMessage :\n$message";
        $headers = array('Content-Type: text/plain; charset=UTF-8');

        if (wp_mail($to, $subject, $body, $headers)) {
            echo '<div class="confirmation">✅ Merci, votre message a bien été envoyé.</div>';
        } else {
            echo '<div class="erreur">❌ Une erreur est survenue, merci de réessayer.</div>';
        }
    }
}
add_action('init', 'montheme_traitement_formulaire');

