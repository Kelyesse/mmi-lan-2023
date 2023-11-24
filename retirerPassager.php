<?php
    session_start();
    require_once("connexionbdd.php");
    $req = $db->prepare("DELETE FROM belongcovoit WHERE PlayerId=? AND CovoitId=?");
    $req->execute([$_SESSION['PlayerId'], $_GET['retirerCovoitId']]);
    header("Location: covoiturage_passager.php");
?>