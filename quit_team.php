<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['PlayerId'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: connection.php');
    exit();
}

// Inclure la configuration de la base de données
include_once('config.php');

// Récupérer l'ID du joueur à partir de la session
$playerId = $_SESSION['PlayerId'];

// Récupérer l'ID de l'équipe à partir du formulaire
$teamId = isset($_GET['teamId']) ? $_GET['teamId'] : null;

// Vérifier si l'ID de l'équipe est défini
if (!$teamId) {
    // Rediriger vers une page d'erreur si l'ID de l'équipe n'est pas défini
    $_SESSION['error_message'] = 'Une erreur s\'est produite lors de la sortie de l\'équipe.';
    header('Location: mon_compte.php');
    exit();
}

require_once('connexionbdd.php');
// Vérifier si le joueur appartient à l'équipe
$checkBelongTeam = $db->prepare('SELECT * FROM belongteam WHERE TeamId = :teamId AND PlayerId = :playerId');
$checkBelongTeam->bindParam(':teamId', $teamId, PDO::PARAM_INT);
$checkBelongTeam->bindParam(':playerId', $playerId, PDO::PARAM_INT);
$checkBelongTeam->execute();
$belongTeam = $checkBelongTeam->fetch(PDO::FETCH_ASSOC);

// Si le joueur appartient à l'équipe, le retirer de l'équipe
if ($belongTeam) {
    // Supprimer le joueur de l'équipe
    $deleteBelongTeam = $db->prepare('DELETE FROM belongteam WHERE TeamId = :teamId AND PlayerId = :playerId');
    $deleteBelongTeam->bindParam(':teamId', $teamId, PDO::PARAM_INT);
    $deleteBelongTeam->bindParam(':playerId', $playerId, PDO::PARAM_INT);
    $deleteBelongTeam->execute();

    // Rediriger vers la page de compte (ou une autre page appropriée)
    $_SESSION['error_message'] = 'Vous venez de quitter votre équipe.';
    header('Location: mon_compte.php');
    exit();
} else {
    // Si le joueur n'appartient pas à l'équipe, afficher un message d'erreur
    $_SESSION['error_message'] = 'Vous ne pouvez pas quitter une équipe à laquelle vous n\'appartenez pas.';
    header('Location: mon_compte.php');
    exit();
}
