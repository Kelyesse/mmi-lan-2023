<?php
// Initialiser la session
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require('assets/libs/PHPMailer-master/src/PHPMailer.php');
require('assets/libs/PHPMailer-master/src/SMTP.php');
require('assets/libs/PHPMailer-master/src/Exception.php');

$errorMessage = '';
$messageSent = false;

if (isset($_POST["email"]) && isset($_POST["mess"])) {
    $email = $_POST["email"];
    $mess = $_POST["mess"];
    $nom = $_POST["nom"] ?? '';
    $prenom = $_POST["prenom"] ?? '';
    $obj = $_POST["obj"] ?? '';

    if (empty($nom) || !preg_match("/^[\p{L} \-'’]+$/u", $nom)) {
        $errorMessage .= 'Nom invalide.<br>';
    }
    if (empty($prenom) || !preg_match("/^[\p{L} \-'’]+$/u", $prenom)) {
        $errorMessage .= 'Prénom invalide.<br>';
    }
    if (empty($obj) || !preg_match("/^[\p{L} \-'’0-9]+$/u", $obj)) {
        $errorMessage .= 'Objet invalide.<br>';
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage .= 'Adresse e-mail invalide.<br>';
    }
    if (empty($mess)) {
        $errorMessage .= 'Message vide.<br>';
    }


    if (empty($errorMessage)) {
        $mail = new PHPMailer(true);
        try {
            // Paramètres de PHPMailer
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com'; // notre adresse de serveur smtp à mettre ici
            $mail->SMTPAuth = true;
            $mail->Username = 'noreply@mmilan-toulon.fr'; // notre adresse e-mail smtp
            $mail->Password = '4v9n)@:}:Y1@@*]WUNae'; // notre mdp smtp
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom('noreply@mmilan-toulon.fr', 'mmi-lan-2023');
            $mail->addAddress('mmilan.com2023@gmail.com'); // adresse de réception des messages peut être à changer
            $mail->addReplyTo($email, $nom);

            $mail->isHTML(true);
            $mail->Subject = 'Nouveau message de contact depuis votre site';
            $mail->Body = "Nom: $nom<br/>Prénom: $prenom<br/>Email: $email<br/>Objet: $obj<br/>Message:<br/>$mess";
            $mail->AltBody = strip_tags("Nom: $nom\nPrénom: $prenom\nEmail: $email\nObjet: $obj\nMessage:\n$mess");

            $mail->send();
            $messageSent = true;
        } catch (Exception $e) {
            $errorMessage = "Message non envoyé. Erreur : {$mail->ErrorInfo}";
        }
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
        <?php include('navbar.php'); ?>
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
                <?php if ($messageSent): ?>
                    <p>Votre message a été envoyé avec succès.</p>
                <?php else: ?>
                    <?php if (!empty($errorMessage)): ?>
                        <p>
                            <?php echo $errorMessage; ?>
                        </p>
                    <?php endif; ?>
                    <form action="contact.php" method="post">
                        <div>
                            <div class="double-inp">
                                <input type="text" placeholder="Entrez votre nom" name="nom" required>
                                <input type="text" placeholder="Entrez votre prénom" name="prenom" required>
                            </div>
                            <div class="simple-inp">
                                <img src="./assets/img/mail.svg" alt="">
                                <input type="email" placeholder="Entrez votre email" name="email" id="email" required>
                            </div>
                            <div class="simple-inp">
                                <img src="./assets/img/chatquote.svg" alt="">
                                <input type="text" placeholder="Objet" name="obj" id="obj" required>
                            </div>
                            <div class="simple-inp">
                                <textarea id="" cols="1000" rows="10" placeholder="Votre message..." name="mess"
                                    id="message" required></textarea>
                            </div>
                            <div id="sub">
                                <a class="rgpd-link" href="./RGPD.php">En nous contactant, vous acceptez le RGPD.</a>
                                <input type="submit" id="submit" value="Envoyer">
                            </div>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </section>
    </main>
    <?php include('./footer.php'); ?>
</body>

</html>