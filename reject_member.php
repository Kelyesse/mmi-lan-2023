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

// Récupérer l'ID du joueur connecté
$loggedInPlayerId = $_SESSION['PlayerId'];

// Récupérer l'ID du joueur à rejeter à partir du formulaire
$userIdToReject = isset($_POST['userId']) ? $_POST['userId'] : null;

// Vérifier si l'ID du joueur à rejeter est défini
if (!$userIdToReject) {
    // Rediriger vers une page d'erreur si l'ID du joueur n'est pas défini
    $_SESSION['error_message'] = 'Une erreur s\'est produite lors du rejet du membre de l\'équipe.';
    header('Location: mon_compte.php');
    exit();
}

require_once('connexionbdd.php');
// Supprimer le membre de l'équipe en mettant à jour la table belongteam
$deleteMemberQuery = $db->prepare('DELETE FROM belongteam WHERE PlayerId = :userId AND BelongStatus = "en attente"');
$deleteMemberQuery->bindParam(':userId', $userIdToReject, PDO::PARAM_INT);
$deleteMemberQuery->execute();

// Rediriger vers la page de compte (ou une autre page appropriée)
header('Location: mon_compte.php');
exit();
?>