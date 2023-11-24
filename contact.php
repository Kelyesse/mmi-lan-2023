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
        $to = "matthieu.biville@hotmail.fr";
        $subject = "Nouveau message de contact depuis votre site";
        $message = "Nom: $nom<br/>";
        $message .= "Prénom: $prenom<br/>";
        $message .= "Adresse e-mail: $email<br/>";
        $message .= "Objet: $obj<br/>";
        $message .= "Message:<br/>$mess";
        $headers = 'From: MMI LAN 2023 <noreply@mmilan-toulon.fr>' . "\r<br/>" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);

    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - MMI LAN</title>
    <link rel="stylesheet" href="./assets/style/contact.css">
    <link rel="icon" href="./assets/img/favicon.png" type="image/x-icon">
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
            <div id="info">
                <p>N'hésitez pas à nous contacter pour toute question, préoccupation ou collaboration potentielle. Nous
                    sommes là pour vous aider !</p>
                <div>
                    <img src="./assets/img/pin.svg" alt="">
                    <h4>70 Avenue Roger Devoucoux, 83000 Toulon</h4>
                </div>
                <div>
                    <img src="./assets/img/mail.svg" alt="">
                    <h4>mmilan.com2023@gmail.com</h4>
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
                    <a href="https://discord.gg/uPFq4y96vy" class="social-link" target="_blank">
                        <img src="./assets/img/discord-logo.svg" alt="discord-logo" class="social-img" />
                    </a>
                </div>
            </div>
            <div id="form">
                <form action="contact.php" method="post">
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
                            <img src="./assets/img/chatquote.svg" alt="">
                            <input type="text" placeholder="Objet" name="obj" id="obj" required>
                        </div>
                        <div class="simple-inp">
                            <textarea id="" cols="1000" rows="10" placeholder="Votre message..." name="mess"
                                id="message"></textarea>
                        </div>
                        <div id="sub">
                            <a class="rgpd-link" href="./RGPD.php">En nous contactant, vous acceptez le RGPD.</a>
                            <input type="submit" id="submit" value="Envoyer">
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <?php
    include('./footer.php');
    ?>
</body>

</html>