<?php
    session_start();
    require_once("connexionbdd.php");
    $req = $db->prepare("INSERT INTO belongcovoit(PlayerId, CovoitId, BelongCovoitRole, BelongCovoitStatus) VALUES(?,?,?,?)");
    $req->execute([$_SESSION['PlayerId'], $_GET['covoitId'], "Passager", "en attente"]);
    $req = $db->prepare("SELECT PlayerId FROM belongcovoit WHERE CovoitId=? AND BelongCovoitRole=?");
    $req->execute([$_GET['covoitId'], "Conducteur"]);
    $createurId = $req->fetch()['PlayerId'];
    $req = $db->prepare("SELECT PlayerLastName, PlayerFirstName, PlayerEmail FROM player WHERE PlayerId=?");
    $req->execute([$createurId]);
    $createur = $req->fetch();
    $nomcreateur = $createur['PlayerFirstName']. " " . $createur['PlayerLastName'];
    $createurmail = $createur['PlayerEmail'];

    $to = $createurmail;
    $subject = "Demande d'adhésion à votre covoiturage de la MMI LAN";
    $message = "<p>Bonjour " . $nomcreateur . ", un participant à la MMI LAN souhaite rejoindre votre covoiturage</p>";
    $message .= "<p>Lieu de récupération souhaité : <i>" . $_POST['lieuRécup'] . "</i></p>";
    if(isset($_POST['matos'])){
        $message .= "<p>Matériel encombrant que la personne souhaite ammener : <i>" . $_POST['matos'] . "</i></p>";
    }
    if(isset($_POST['nomDiscord'])){
        $message .= "<p>Discord de la personne demandante : <i>" . $_POST['nomDiscord'] . "</i></p>";
    }
    $message .= "<p>Pour accepter ou refuser sa demande, veuillez vous rendre sur <a href='https://mmilan-toulon.fr/covoiturage_passager.php'>la page qui affiche les covoiturages du site de la MMI LAN</a> </p>";
    $headers = 'From: MMI LAN 2023 <noreply@mmilan-toulon.fr>' . "\r\n" .
        'Content-type: text/html; charset=iso-8859-1'.
        'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);

    header("Location: covoiturage_passager.php");
?>