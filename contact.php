<?php
// Initialiser la session
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (isset($_POST["email"]) && isset($_POST["mess"])) {
    $email = $_POST["email"];
    $mess = $_POST["mess"];

    if (isset($_POST["nom"])) {
        $nom = $_POST["nom"];
        if (!preg_match("/^[a-zA-Z]+$/", $nom)) {
            $nom = false;
        }
    }
    if (isset($_POST["prenom"])) {
        $prenom = $_POST["prenom"];
        if (!preg_match("/^[a-zA-Z]+$/", $prenom)) {
            $prenom = false;
        }
    }
    if (isset($_POST["obj"])) {
        $obj = $_POST["obj"];
        if (!preg_match("/^[a-zA-Z]+$/", $obj)) {
            $obj = false;
        }
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email = false;
    }
    if (!preg_match("/^[a-zA-Z]+$/", $mess)) {
        $mess = false;
    }

    // Envoyer le mail
    if ($email && $mess) {
        //A remplacer par php mailer
        $destinataire = "adresse@email.com"; // #### A REMPLACER par l'adresse amil de l'hebergeur ou celui de l'association ###
        $sujet = "Nouveau message de contact depuis votre site";

        $message = "Nom: $nom\n";
        $message .= "Prénom: $prenom\n";
        $message .= "Adresse e-mail: $email\n";
        $message .= "Objet: $obj\n";
        $message .= "Message:\n$mess";

        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        // Voir ce qu'on affiche quand le message a été envoyé ou s'il y a une erreur
        try {
            if (mail($destinataire, $sujet, $message, $headers)) {
            } else {
                throw new Exception("Une erreur s'est produite lors de l'envoi de votre message.");
            }
        } catch (Exception $e) {
            $errorMessage = "Erreur : " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang='fr'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0, shrink-to-fit=no'>
    <title>Contact</title>
</head>

<body>
    <header></header>
    <main>
        <div>
            <h1>Contactez nous</h1>
        </div>
        <form action="" method="post">
            <input type="text" placeholder="Entrez votre nom" name="nom">
            <input type="text" placeholder="Entrez votre prénom" name="prenom">
            <input type="email" placeholder="Entrez votre adresse mail *" name="email" required>
            <input type="text" placeholder="Objet" name="obj">
            <textarea name="mess" placeholder="Votre message *"></textarea>
            <div>
                <a href="#">En nous contactant vous acceptez le RGPD</a>
                <input type="submit" value="Envoyer">
            </div>
        </form>
    </main>
    <footer></footer>
</body>

</html>