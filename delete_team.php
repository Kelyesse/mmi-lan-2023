<?php
session_start();

// Vérifier si le formulaire a été soumis en POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Rediriger vers une page d'erreur si le formulaire n'a pas été soumis
    $_SESSION['error_message'] = 'Une erreur s\'est produite lors de la suppression de l\'équipe.';
    header('Location: mon_compte.php');
    exit();
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['PlayerId'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: connection.php');
    exit();
}

// Inclure la configuration de la base de données
include_once('connectionbdd.php');

// Récupérer l'ID du joueur à partir de la session
$playerId = $_SESSION['PlayerId'];

// Récupérer l'ID de l'équipe à partir du formulaire
$teamId = isset($_POST['teamId']) ? $_POST['teamId'] : null;

// Vérifier si l'ID de l'équipe est défini
if (!$teamId) {
    // Rediriger vers une page d'erreur si l'ID de l'équipe n'est pas défini
    $_SESSION['error_message'] = 'Une erreur s\'est produite lors de la suppression de l\'équipe.';
    header('Location: mon_compte.php');
    exit();
}

// Vérifier si l'équipe est vide
$checkEmptyTeam = $db->prepare('SELECT COUNT(*) as isEmpty FROM belongteam WHERE TeamId = :teamId AND BelongStatus = "validé"');
$checkEmptyTeam->bindParam(':teamId', $teamId, PDO::PARAM_INT);
$checkEmptyTeam->execute();
$result = $checkEmptyTeam->fetch(PDO::FETCH_ASSOC);
$isEmptyTeam = $result['isEmpty'];

// Si l'équipe est vide, supprimer le belongTeam du créateur et l'équipe dans la table team
if ($isEmptyTeam === 1) {
    // Supprimer le belongTeam du créateur
    $deleteBelongTeam = $db->prepare('DELETE FROM belongteam WHERE TeamId = :teamId AND PlayerId = :playerId');
    $deleteBelongTeam->bindParam(':teamId', $teamId, PDO::PARAM_INT);
    $deleteBelongTeam->bindParam(':playerId', $playerId, PDO::PARAM_INT);
    $deleteBelongTeam->execute();

    // Supprimer l'équipe dans la table team
    $deleteTeam = $db->prepare('DELETE FROM team WHERE TeamId = :teamId');
    $deleteTeam->bindParam(':teamId', $teamId, PDO::PARAM_INT);
    $deleteTeam->execute();

    // Rediriger vers la page de compte (ou une autre page appropriée)
    $_SESSION['error_message'] = 'Votre équipe a bien été supprimée.';
    header('Location: mon_compte.php');
    exit();
} else {
    // Si l'équipe n'est pas vide, afficher un message d'erreur
    $_SESSION['error_message'] = 'Votre équipe ne peut pas être supprimée car elle contient encore des participant.';
    header('Location: mon_compte.php');
    exit();
}
