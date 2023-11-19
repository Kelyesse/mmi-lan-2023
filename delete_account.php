<?php
session_start();

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer l'ID du joueur depuis la session
    $playerId = isset($_SESSION['PlayerId']) ? $_SESSION['PlayerId'] : null;

    // Vérifier si l'ID du joueur est valide
    if (!empty($playerId)) {
        require_once('connexionbdd.php');
        $req = $db->prepare('SELECT BelongRole, TeamId FROM belongteam WHERE PlayerId=?');
        $req->execute([$playerId]);
        $equipe = $req->fetch();
        $role = $equipe['BelongRole'];
        if($role == "Créateur"){
            $teamId = $equipe['TeamId'];
            $req = $db->prepare('DELETE FROM belongteam WHERE TeamId=?');
            $req->execute([$teamId]);
            $req = $db->prepare('DELETE FROM team WHERE TeamId=?');
            $req->execute([$teamId]);
        }
        $req = $db->prepare('DELETE FROM belongteam WHERE PlayerId=?');
        $req->execute([$playerId]);
        $req = $db->prepare('DELETE FROM belongcovoit WHERE PlayerId=?');
        $req->execute([$playerId]);
        $req = $db->prepare('DELETE FROM player WHERE PlayerId=?');
        $req->execute([$playerId]);
        
        // Détruire la session actuelle
        session_destroy();

        // Régénérer l'ID de session (sécurité)
        session_regenerate_id(true);
        header('Location: inscription.php');
    } 
    else {
        header('Location: connexion.php');
        exit();
    }
} else {
    $_SESSION['error_message'] = 'Accès non autorisé.';
    header('Location: mon_compte.php');
    exit();
}
