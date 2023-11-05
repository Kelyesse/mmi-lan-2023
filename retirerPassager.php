<?php
    session_start();
    require_once("[fichier_test]connexionbdd.php");
    $req = $db->prepare("DELETE FROM belongcovoit WHERE PlayerId=? AND CovoitId=?");
    $req->execute([$_SESSION['playerId'], $_GET['retirerCovoitId']]);
    header("Location: afficheCovoits.php");
?>