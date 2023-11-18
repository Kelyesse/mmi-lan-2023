<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les données du formulaire sont présentes
    if (isset($_POST['userId']) && isset($_POST['teamId'])) {
        $userId = $_POST['userId'];
        $teamId = $_POST['teamId'];

        // Connectez-vous à la base de données et effectuez les mises à jour nécessaires
        require_once('connexionbdd.php');

        try {
            // Mettre à jour le statut d'appartenance de l'utilisateur dans la table belongteam
            $updateQuery = 'UPDATE belongteam SET BelongStatus = "validé" WHERE PlayerId = :userId AND TeamId = :teamId';
            $stmt = $db->prepare($updateQuery);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':teamId', $teamId, PDO::PARAM_INT);

            if ($stmt->execute()) {
                // Mise à jour réussie
                $_SESSION['success_message'] = 'Le membre a été accepté dans l\'équipe.';
            } else {
                // Échec de la mise à jour
                $_SESSION['error_message'] = 'Erreur lors de l\'acceptation du membre dans l\'équipe.';
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Une erreur est survenue lors de la mise à jour de la base de données.';
        }

        // Rediriger vers la page mon_compte.php
        header('Location: mon_compte.php');
        exit();
    } else {
        $_SESSION['error_message'] = 'Données du formulaire manquantes.';
        header('Location: mon_compte.php');
        exit();
    }
} else {
    $_SESSION['error_message'] = 'Accès non autorisé.';
    header('Location: mon_compte.php');
    exit();
}
