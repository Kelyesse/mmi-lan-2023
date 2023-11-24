<?php
session_start();
include("navbar.php");

// Vérifie si $_SESSION['PlayerId'] existe
if (isset($_SESSION['PlayerId'])) {
    // Si la session existe, redirige vers une autre page
    header('Location: mon_compte.php');
    exit();
}

// Vérifier si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['password'])) {
    // Partie à modifier : récupérer les valeurs du formulaire et les protéger contre les injections SQL
    $PlayerEmail = $_POST['email'];
    $PlayerPassword = $_POST['password'];

    $PlayerPassword_hash = hash('sha256', $PlayerPassword);

    // Partie à modifier : Utiliser une requête préparée avec PDO pour éviter les injections SQL
    $stmt = $db->prepare("SELECT * FROM player WHERE PlayerEmail = :PlayerEmail AND PlayerPassword = :PlayerPassword_hash");

    // Liaison des valeurs aux paramètres
    $stmt->bindParam(':PlayerEmail', $PlayerEmail, PDO::PARAM_STR);
    $stmt->bindParam(':PlayerPassword_hash', $PlayerPassword_hash, PDO::PARAM_STR);

    // Exécution de la requête préparée
    $stmt->execute();

    // Récupération des résultats
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Vérifier si la requête a réussi
    if ($result) {
        // Vérifier si l'utilisateur existe dans la base de données
        if (count($result) == 1) {
            // L'utilisateur est authentifié avec succès
            $PlayerId = $result[0]['PlayerId'];
            $_SESSION['PlayerId'] = $PlayerId;
            if (isset($_POST['remember_me']) && $_POST['remember_me'] == "on") {
                // Créez un cookie pour stocker les informations de connexion
                setcookie('remember_user', $PlayerId, time() + 60 * 60 * 24 * 30); // Valide pendant 30 jours
            }
            header("Location: mon_compte.php");
            exit();
        } else {
            // L'utilisateur n'existe pas
            $error_message = "Adresse e-mail ou mot de passe incorrect.";
        }
    } else {
        // Erreur lors de l'exécution de la requête SQL avec PDO
        $error_message = "Erreur lors de la connexion. Veuillez réessayer.";
    }
}



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['recover'])) {
    ///php mailer
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - MMI LAN</title>
    <link rel="stylesheet" href="./assets/style/connexion.css" />
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Récupérer les éléments nécessaires
            var forgotPasswordLink = document.getElementById('forgot-password');
            var popup = document.getElementById('popup');
            var closePopupButton = document.getElementById('close-popup');

            // Ajouter un écouteur d'événement pour le clic sur "Mot de passe oublié ?"
            forgotPasswordLink.addEventListener('click', function (e) {
                e.preventDefault();
                popup.style.display = 'block';
            });

            // Ajouter un écouteur d'événement pour le bouton de fermeture du popup
            closePopupButton.addEventListener('click', function () {
                popup.style.display = 'none';
            });
        });

        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('password');
            var eyeOpen = document.getElementById('eye-open');
            var eyeClosed = document.getElementById('eye-closed');

            // Basculer entre le type 'password' et 'text'
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text'
                eyeOpen.style.display = 'block'
                eyeClosed.style.display = 'none'
            } else {
                passwordInput.type = 'password'
                eyeOpen.style.display = 'none'
                eyeClosed.style.display = 'block'
            }
        }
    </script>
</head>

<body>
    <div class="container">
        <h1>Connexion</h1>
        <div class="flex-row">
            <div class="text-section">
                <p id="subtitle">Vous n’avez pas de compte ?<br><a href="inscription.php">Inscrivez vous ici !</a></p>
                <form method="POST">
                    <div class="inputs">
                        <div class="flex-logo-input space1">
                            <img class="logo-input" src="./assets/img/mail.svg">
                            <input class="style-input" type="email" name="email" placeholder="Entrer votre adresse mail"
                                required />
                        </div>
                        <div class="space2 flex-logo-input style-input">
                            <img class="logo-input" src="./assets/img/cadena.svg">
                            <input type="password" name="password" class="style-input" id="password"
                                placeholder="Entrer votre mot de passe" required />
                            <button type="button" id="toggle-password" onclick="togglePasswordVisibility()">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"
                                    id="eye-open">
                                    <path
                                        d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" id="eye-closed"
                                    viewBox="0 0 640 512">
                                    <path
                                        d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z" />
                                </svg>
                            </button>
                            <?php if (isset($error_message)): ?>
                                <p class="error-message">
                                    <?php echo $error_message; ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        <div class="flex-space-between">
                            <div class="remember-check">
                                <input id="remember" type="checkbox" name="remember_me">
                                <label for="remember">Se souvenir de moi</label>
                            </div>
                            <a id="forgot-password">Mot de passe oublié ?</a>
                        </div>
                    </div>
                    <button id="connexion" type="submit">Se connecter</button>
                </form>
            </div>
            <img id="illustration" src="assets/img/homepage_bg.png" />
        </div>
        <div id="popup" class="popup">
            <div class="popup-content">
                <span id="close-popup" class="close-popup">&times;</span>
                <form method="post" class="flex-popup">
                    <p id="title-change-password">Changer de mot de passe</p>
                    <input type="email" class="style-input" name="recover" placeholder="Entrer votre adresse mail">
                    <button type="submit">Recevoir le code</button>
                </form>
            </div>
        </div>
    </div>
    <?php
    include('./footer.php');
    ?>
</body>

</html>