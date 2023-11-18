<?php
    session_start();
    require_once("connexionbdd.php");
    $req = $db->prepare("INSERT INTO belongteam(PlayerId, TeamId, BelongRole, BelongStatus) VALUES(?,?,?,?)");
    $req->execute([$_SESSION['PlayerId'], $_GET['teamId'], "Participant", "en attente"]);
    $req = $db->prepare("SELECT PlayerId FROM belongteam WHERE TeamId=? AND BelongRole=?");
    $req->execute([$_GET['teamId'], "Créateur"]);
    $createurId = $req->fetch()['PlayerId'];
    $req = $db->prepare("SELECT PlayerLastName, PlayerFirstName, PlayerEmail FROM player WHERE PlayerId=?");
    $req->execute([$createurId]);
    $createur = $req->fetch();
    $nomcreateur = $createur['PlayerFirstName']. " " . $createur['PlayerLastName'];
    $createurmail = $createur['PlayerEmail'];

    $to = $createurmail;
    $subject = "Demande d'adhésion à votre équipe de la MMI LAN";
    $message = "<p>Bonjour " . $nomcreateur . ", un participant à la MMI LAN souhaite rejoindre votre équipe</p><p><i>" . $_POST['playerDesc'] . "</i></p><p>Pour accepter ou refuser sa demande, veuillez vous rendre sur <a href='https://mmilan-toulon.fr/mon_compte.php'>votre page Mon Compte du site de la MMI LAN</a> </p>";
    $headers = 'From: MMI LAN 2023 <noreply@mmilan-toulon.fr>' . "\r\n" .
        'Content-type: text/html; charset=iso-8859-1'.
        'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);

    header("Location: details_equipes.php?teamId=" . $_GET['teamId']);
?>
