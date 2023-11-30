<?php
    require_once('connexionbdd.php');
    $req = $db->prepare('UPDATE belongcovoit SET BelongCovoitStatus=? WHERE CovoitId=? AND PlayerId=?');
    $req->execute(['validé', $_GET['covoitId'], $_GET['playerId'] ]);
    header('Location: covoiturage_passager.php');
?>