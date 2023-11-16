$(document).ready(function() {
    // Fonction de validation du mot de passe
    function validatePassword(password, confirmPassword) {
        const minLength = 8;
        const hasMinLength = password.length >= minLength;
        const hasLowerCase = /[a-z]/.test(password);
        const hasUpperCase = /[A-Z]/.test(password);
        const hasDigit = /\d/.test(password);
        const isMatch = password === confirmPassword;

        // Vérifiez chaque condition et mettez à jour la classe CSS en conséquence
        $("#config-psw").toggleClass("valid-min-length", hasMinLength);
        $("#config-psw").toggleClass("valid-lower-case", hasLowerCase);
        $("#config-psw").toggleClass("valid-upper-case", hasUpperCase);
        $("#config-psw").toggleClass("valid-digit", hasDigit);
        $("#config-psw").toggleClass("match-password", isMatch);

        return hasMinLength && hasLowerCase && hasUpperCase && hasDigit && isMatch;
    }

    // Écoutez les événements de changement dans les champs de mot de passe
    $('input[name="mdp1"], input[name="mdp2"]').on('input', function() {
        const passwordValue = $('input[name="mdp1"]').val();
        const confirmPasswordValue = $('input[name="mdp2"]').val();
        validatePassword(passwordValue, confirmPasswordValue);
    });

    // Écoutez l'événement de soumission du formulaire
    $('form').submit(function(event) {
        const passwordValue = $('input[name="mdp1"]').val();
        const confirmPasswordValue = $('input[name="mdp2"]').val();

        if (!validatePassword(passwordValue, confirmPasswordValue)) {
            // Affichez un message d'erreur ou effectuez une action appropriée
            alert("Le mot de passe doit respecter les conditions, et les champs de mot de passe doivent correspondre.");

            // Empêchez la soumission du formulaire
            event.preventDefault();
        }
    });
});
