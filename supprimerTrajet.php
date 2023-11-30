<?php
    session_start();
    require_once("connexionbdd.php");
    $req = $db->prepare("DELETE FROM belongcovoit WHERE CovoitId=?");
    $req->execute([$_GET['supprimerCovoitId']]);
    $req = $db->prepare("DELETE FROM covoit WHERE CovoitId=?");
    $req->execute([$_GET['supprimerCovoitId']]);
    header("Location: covoiturage_passager.php");
?>