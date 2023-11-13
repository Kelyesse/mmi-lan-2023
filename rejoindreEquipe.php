<?php
session_start();
require_once("[fichier_test]connexionbdd.php"); //A MODIFIER
$req = $db->prepare("INSERT INTO belongteam(PlayerId, TeamId, BelongRole, BelongStatus) VALUES(?,?,?,?)");
$req->execute([$_SESSION['playerId'], $_GET['teamId'], "participant", "en attente"]);
$req = $db->prepare("SELECT PlayerId FROM belongteam WHERE TeamId=? AND BelongRole=?");
$req->execute([$_GET['teamId'], "Créateur"]);
$createurId = $req->fetch()['PlayerId'];
$req = $db->prepare("SELECT PlayerLastName, PlayerFirstName, PlayerEmail FROM player WHERE PlayerId=?");
$req->execute([$createurId]);
$nomcreateur = $req->fetch()[1] . " " . $req->fetch()[0];
$createurmail = $req->fetch()[2];
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

// require('assets/libs/PHPMailer-master/src/PHPMailer.php');
// require('assets/libs/PHPMailer-master/src/SMTP.php');
// require('assets/libs/PHPMailer-master/src/Exception.php');

// $mail = new PHPMailer(true);

// try {
//     //A MODIFIER UNE FOIS HEBERGE
//     $mail->isSMTP();
//     $mail->Host       = 'localhost';
//     $mail->SMTPAuth   = true;
//     $mail->Username   = 'root';
//     $mail->Password   = '';
//     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
//     $mail->Port       = 80;

//     $mail->Encoding = 'base64';
//     $mail->CharSet = 'UTF-8';

//     $mail->setFrom('email@test.fr', 'MMI LAN 2023');
//     $mail->addAddress($createurmail);
//     $mail->addReplyTo('email@test.fr', 'MMI LAN 2023');
//     $mail->addCC('mmi.lan.dev2023@gmail.com');

//     $mail->isHTML(true);
//     $mail->Subject = "Demande d'adhésion à votre équipe de la MMI LAN";
//     $mail->Body    = "<p>Bonjour ".$nomcreateur.", un participant à la MMI LAN souhaite rejoindre votre équipe</p><p>".$_POST['playerDesc']."</p><p>Pour accepter ou refuser sa demande, veuillez vous rendre sur <a href=''>votre page Mon Compte du site de la MMI LAN</a> </p>";
//     $mail->AltBody = '';
//     $mail->send();
// } 
// catch (Exception $e) {
//     echo $email_not_sent . "<br>Merci de transmettre ces informations à l'administrateur : {$mail->ErrorInfo}";
// }
header("Location: details_equipes.php?teamId=" . $_GET['teamId']);
