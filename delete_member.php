<?php
// Initialiser la session
session_start();

// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_member'])) {
    // Assurez-vous que les champs nécessaires sont présents
    if (isset($_POST['teamId']) && isset($_POST['userId'])) {
        // Récupérer les valeurs du formulaire
        $teamId = $_POST['teamId'];
        $userId = $_POST['userId'];

        // Traitement pour supprimer un membre de l'équipe
        require_once('connexionbdd.php');
        $db->query('DELETE FROM belongteam WHERE TeamId = ' . $teamId . ' AND PlayerId = ' . $userId);

        // Redirection vers la page d'origine avec un message de succès
        $_SESSION['success_message'] = 'Le membre a été supprimé avec succès de l\'équipe.';
        header('Location: mon_compte.php');
        exit();
    } else {
        // Si les champs nécessaires ne sont pas présents, stockez un message d'erreur dans la session
        $_SESSION['error_message'] = 'Une erreur s\'est produite lors du traitement du formulaire.';
        header('Location: mon_compte.php');
        exit();
    }
} else {
    $_SESSION['error_message'] = 'Accès non autorisé.';
    header('Location: mon_compte.php');
    exit();
}
