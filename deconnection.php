<?php
session_start();

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer l'ID du joueur depuis la session
    $playerId = isset($_SESSION['PlayerId']) ? $_SESSION['PlayerId'] : null;

    // Vérifier si l'ID du joueur est valide
    if (!empty($playerId)) {
        // Supprimer le cookie de connexion automatique s'il existe
        if (isset($_COOKIE['remember_user'])) {
            setcookie('remember_user', '', time() - 3600, '/');
        }

        // Détruire la session actuelle
        session_destroy();

        // Régénérer l'ID de session (sécurité)
        session_regenerate_id(true);

        // Rediriger vers la page de connexion
        header('Location: connexion.php');
        exit();
    } else {
        header('Location: connexion.php');
        exit();
    }
} else {
    $_SESSION['error_message'] = 'Accès non autorisé.';
    header('Location: mon_compte.php');
    exit();
}
