<?php
session_start();


// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    // Supprimer le cookie de connexion automatique s'il existe
    foreach ($_COOKIE as $key => $value) {
        setcookie($key, '', time() - 3600, '/');
    }

    // Détruire la session actuelle
    session_unset();
    session_destroy();

    // Rediriger vers la page de connexion
    header('Location: ./connexion.php');
    exit();
} else {
    $_SESSION['error_message'] = 'Accès non autorisé.';
    header('Location: ./mon_compte.php');
    exit();
}
