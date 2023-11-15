<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_member'])) {
    //supprimer le joueur de l'équipe
    $sql = "DELETE FROM belongteam WHERE PlayerId = :playerid AND TeamId = :teamid;";
    //se connecter à la base
}
