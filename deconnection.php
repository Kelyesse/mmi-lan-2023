<?php
session_start();

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer l'ID du joueur depuis le champ caché
    $playerId = isset($_POST['playerId']) ? $_POST['playerId'] : null;

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
    }
}

// Si le formulaire n'a pas été soumis correctement, rediriger vers la page de connexion
header('Location: connexion.php');
exit();
