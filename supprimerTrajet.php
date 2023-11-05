<?php
    session_start();
    require_once("[fichier_test]connexionbdd.php");
    $req = $db->prepare("DELETE FROM belongcovoit WHERE CovoitId=?");
    $req->execute([$_GET['supprimerCovoitId']]);
    $req = $db->prepare("DELETE FROM covoit WHERE CovoitId=?");
    $req->execute([$_GET['supprimerCovoitId']]);
    header("Location: afficheCovoits.php");
?>