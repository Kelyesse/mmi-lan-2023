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
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="./assets/style/contact.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</head>

<body>
    <header>
        <?php
            include('navbar.php');
        ?>
    </header>
    <main>
        <div id="title">
            <h1>CONTACTEZ NOUS !</h1>
        </div>
        <section>
            <div id="info" >
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <div>
                    <h4>70 Avenue Roger Devoucoux, 83000 Toulon</h4>
                </div>
                <div>
                    <img src="./assets/img/mail.svg" alt="">
                    <h4>info@form.com</h4>
                </div>
                <div>
                    <a href="https://www.tiktok.com/@mmi.lan?is_from_webapp=1&sender_device=pc">
                        <img src="./assets/img/tiktok-logo.svg" alt="">
                    </a>
                    <a href="https://www.instagram.com/mmi_lan2023/">
                        <img src="./assets/img/insta-logo.svg" alt="">
                    </a>
                    <a href="https://www.youtube.com/@MMILAN_2023?sub_confirmation=1">
                        <img src="./assets/img/yt-logo.svg" alt="">
                    </a>
                    <a href="https://x.com/MMI_LAN_2023?s=20">
                        <img src="./assets/img/twitter-logo.svg" alt="">
                    </a>
                </div>
            </div>
            <div id="form">
                <form action="" method="post">
                    <div>
                        <div class="double-inp">
                            <input type="text" placeholder="Entrer votre nom" name="nom" required>
                            <input type="text" placeholder="Entrer votre prénom" name="prenom" required>
                        </div>
                        <div class="simple-inp">
                            <img src="./assets/img/mail.svg" alt="">
                            <input type="email" placeholder="Entrer votre email" name="email" id="email" required>
                        </div>
                        <div class="simple-inp">
                            <img src="./assets/img/profil.svg" alt="">
                            <input type="text" placeholder="Objet" name="objet" id="obj" required>
                        </div>
                        <div class="simple-inp">
                            <textarea name="" id="" cols="1000" rows="10" placeholder="Votre messages" name="mess" id="message"></textarea>
                        </div>
                        <div id="sub">
                            <a href="./reglement.php">En nous contactant vous acceptez le RGPD</a>
                            <input type="submit" id="submit" value="envoyer">
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>
</html>