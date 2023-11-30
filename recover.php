<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require('assets/libs/PHPMailer-master/src/PHPMailer.php');
require('assets/libs/PHPMailer-master/src/SMTP.php');
require('assets/libs/PHPMailer-master/src/Exception.php');

include("include/db.php");

function generateRandomString($length = 30)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_@#$*';
    $charactersLength = strlen(($characters));
    $randomToken = '';

    for ($i = 0; $i < $length; $i++) {
        $randomToken .= $characters[(rand(0, $charactersLength - 1))];
    }

    return $randomToken;
}

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

$settings = array(
    'instance_email_host' => 'smtp.hostinger.com',
    'instance_url' => 'http://localhost:8888/mmi-lan-2023/',
    'instance_email_port' => 465,
    'instance_email_username' => 'noreply@mmilan-toulon.fr',
    'instance_email_password' => '4v9n)@:}:Y1@@*]WUNae',
    'instance_email_support' => 'elyessekourdourli@gmail.com',
    'name' => 'mmi-lan-2023',
);

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $email = $_POST["email"];

    $query = $db2->prepare("SELECT * FROM player WHERE PlayerEmail = :PlayerEmail ");

    $query->bindParam(':PlayerEmail', $email, PDO::PARAM_STR);
    $query->execute();

    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($result);

    if (isset($result[0])) {
        $result = $result[0];
    } else {
        echo ' votre compte est inexistant';
        // arrete le script
        die();
    }

    $token = generateRandomString(30);

    $recover_link = $settings['instance_url'] . '/recover.php' . '?RecoverToken=' . $token . '&RecoverCode=' . $result['PlayerId'];

    $mail_template_recover = "{[URL_RECOVER]} {[MAIL_RECOVER]} {[NAME_RECOVER]}";
    $mail_template_recover = str_replace("{[URL_RECOVER]}", $recover_link, $mail_template_recover);
    $mail_template_recover = str_replace("{[MAIL_RECOVER]}", $settings['instance_email_support'], $mail_template_recover);
    $mail_template_recover = str_replace("{[NAME_RECOVER]}", $settings['name'], $mail_template_recover);

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = $settings['instance_email_host'];
        $mail->SMTPAuth = true;
        $mail->Username = $settings['instance_email_username'];
        $mail->Password = $settings['instance_email_password'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = $settings['instance_email_port'];

        $mail->Encoding = 'base64';
        $mail->CharSet = 'UTF-8';

        $mail->setFrom($settings['instance_email_username'], $settings['name']);
        $mail->addAddress($email);
        $mail->addReplyTo($settings['instance_email_username'], $settings['name']);
        $mail->addCC('mmi.lan.dev2023@gmail.com');
        //                $mail->addBCC('bcc@example.com');

        $mail->isHTML(true);
        $mail->Subject = 'Réinitialisation du mot de passe - ' . $settings['name'];
        $mail->Body = $mail_template_recover;
        $mail->AltBody = 'Bonjour, Une demande de réinitialisation de mot de passe a été déclenchée le : ' . date('Y-m-d H:i:s') . '  
					Utilisez le lien suivant pour réinitialiser votre mot de passe :  ' . $recover_link;
        $mail->send();

        $query = $db2->prepare("INSERT INTO recover (RecoverDate, RecoverToken, PlayerId) 
									VALUES (?, ?, ?)");
        $query->bindValue(1, date('Y-m-d H:i:s'));
        $query->bindValue(2, $token);
        $query->bindValue(3, $result['PlayerId']);
        $query->execute(); // create token reintialisation
        $result2 = $query->fetchAll(PDO::FETCH_ASSOC);
        echo 'Mail envoyé';
    } catch (Exception $e) {
        echo "Mail non envoyé<br>Merci de transmettre ces informations à l'administrateur : {$mail->ErrorInfo}";
    }
}

// Faire une condition sur le token pour que celui ci soit vérifier dans l'url pour afficher en condition le html du changement de mot de passe



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recover - MMI LAN</title>
</head>

<body>

    <div class="container">
        <h1>Recup de mdp</h1>
        <form action="" method="post">
            <div class="inputs">
                <input class="space1" type="email" name="email" placeholder="Entrer votre adresse mail" required />
            </div>
            <button id="connexion" type="submit">Envoyer</button>
        </form>
    </div>
</body>

</html>