<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['PlayerId'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: connection.php');
    exit();
}

// Inclure la configuration de la base de données
include_once('connexionbdd.php');

// Récupérer l'ID de l'équipe à partir du formulaire
$teamId = $_GET['teamId'];

// Vérifier si l'ID de l'équipe est défini
if (!$teamId) {
    // Rediriger vers une page d'erreur si l'ID de l'équipe n'est pas défini
    $_SESSION['error_message'] = 'Une erreur s\'est produite lors de la suppression de l\'équipe.';
    header('Location: mon_compte.php');
    exit();
}

$deleteBelongTeam = $db->prepare('DELETE FROM belongteam WHERE TeamId = :teamId');
$deleteBelongTeam->bindParam(':teamId', $teamId, PDO::PARAM_INT);
$deleteBelongTeam->execute();

// Supprimer l'équipe dans la table team
$deleteTeam = $db->prepare('DELETE FROM team WHERE TeamId = :teamId');
$deleteTeam->bindParam(':teamId', $teamId, PDO::PARAM_INT);
$deleteTeam->execute();

// Rediriger vers la page de compte (ou une autre page appropriée)
$_SESSION['error_message'] = 'Votre équipe a bien été supprimée.';
header('Location: mon_compte.php');
exit();
?>
