<?php
    require_once('connexionbdd.php');
    $req = $db->prepare('DELETE FROM belongcovoit WHERE PlayerId = :userId AND CovoitId= :covoitId');
    $req->bindParam(':userId', $_GET['playerId'], PDO::PARAM_INT);
    $req->bindParam(':covoitId', $_GET['covoitId'], PDO::PARAM_INT);
    $req->execute();
    header('Location: covoiturage_passager.php');

?>