<?php

include("include/db.php");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil | Connexion</title>
    <link rel="stylesheet" href="./assets/style/connexion.css" />
</head>

<body>
    <div class="container">
        <h1>Connexion</h1>
        <div class="flex-row">
            <div class="text-section">
                <p id="subtitle">Vous n’avez pas de compte ?<br><a href="inscription.php">Inscrivez vous ici !</a></p>
                <form method="post">
                    <div class="inputs">
                        <input class="space1" type="email" placeholder="Entrer votre adresse mail" required />
                        <input class="space2" type="password" placeholder="Entrer votre mot de passe" required />
                        <div class="flex-space-between">
                            <div class="remember-check">
                                <input id="remember" type="checkbox">
                                <label for="remember">Se souvenir de moi</label>
                            </div>
                            <a id="forgot-password" href="recover.php">Mot de passe oublié ?</a>
                        </div>
                    </div>
                    <button id="connexion" type="submit">Se connecter</button>
                </form>
            </div>
            <img id="illustration" src="assets/img/homepage_bg.png" />
        </div>
    </div>



</body>

</html>