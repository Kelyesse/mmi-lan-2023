<?php
session_start();

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer l'ID du joueur depuis la session
    $playerId = isset($_SESSION['PlayerId']) ? $_SESSION['PlayerId'] : null;

    // Vérifier si l'ID du joueur est valide
    if (!empty($playerId)) {
        // Vérifier si le joueur n'est pas dans une équipe
        require_once('connexionbdd.php');
        $teamCheck = $db->prepare('SELECT COUNT(*) FROM belongteam WHERE PlayerId = :playerId');
        $teamCheck->bindParam(':playerId', $playerId, PDO::PARAM_INT);
        $teamCheck->execute();
        $isInTeam = $teamCheck->fetchColumn();

        // Vérifier si le joueur n'est pas dans un covoiturage
        $covoitCheck = $db->prepare('SELECT COUNT(*) FROM belongcovoit WHERE PlayerId = :playerId');
        $covoitCheck->bindParam(':playerId', $playerId, PDO::PARAM_INT);
        $covoitCheck->execute();
        $isInCovoit = $covoitCheck->fetchColumn();

        // Si le joueur n'est ni dans une équipe ni dans un covoiturage, on peut supprimer le compte
        if (!$isInTeam && !$isInCovoit) {
            // Supprimer le compte de la table player
            $deletePlayer = $db->prepare('DELETE FROM player WHERE PlayerId = :playerId');
            $deletePlayer->bindParam(':playerId', $playerId, PDO::PARAM_INT);
            $deletePlayer->execute();

            // Détruire la session actuelle
            session_destroy();

            // Régénérer l'ID de session (sécurité)
            session_regenerate_id(true);

            // Rediriger vers la page d'inscription
            header('Location: inscription.php');
            exit();
        } else {
            // Si le joueur est dans une équipe ou un covoiturage, afficher un message d'erreur
            $_SESSION['error_message'] = 'Vous ne pouvez pas supprimer votre compte car vous êtes actuellement dans une équipe et/ou un covoiturage.';
        }
    } else {
        header('Location: connexion.php');
        exit();
    }
} else {
    $_SESSION['error_message'] = 'Accès non autorisé.';
    header('Location: mon_compte.php');
    exit();
}
