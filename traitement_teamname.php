<?php
session_start();

// Vérifier si la requête provient d'une méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les données du formulaire sont présentes
    if (isset($_GET['teamId']) && isset($_POST['newTeamName']) && isset($_POST['newDescName'])) {
        $teamId = $_GET['teamId'];
        $newTeamName = $_POST['newTeamName'];
        $newDescName = $_POST['newDescName'];

        if (!preg_match('/^[a-zA-ZÀ-ÖØ-öø-ÿ]+$/', $newTeamName)) {
            $_SESSION['error_message'] = 'Le nom d\'équipe doit contenir uniquement des lettres minuscules et majuscules.';
            header('Location: mon_compte.php');
            exit();
        }

        // Inclure le fichier de connexion à la base de données
        require_once('connexionbdd.php');

        try {
            // Mettre à jour le nom de l'équipe dans la table team
            $updateQuery = 'UPDATE team SET TeamName = :newTeamName, TeamDesc = :newTeamDesc WHERE TeamId = :teamId';
            $stmt = $db->prepare($updateQuery);
            $stmt->bindParam(':newTeamName', $newTeamName, PDO::PARAM_STR);
            $stmt->bindParam(':newTeamDesc', $newDescName, PDO::PARAM_STR);
            $stmt->bindParam(':teamId', $teamId, PDO::PARAM_INT);

            // Exécuter la requête
            if ($stmt->execute()) {
                // Mise à jour réussie
                $_SESSION['success_message'] = 'Le nom de l\'équipe a été mis à jour avec succès.';
            } else {
                // Échec de la mise à jour
                $_SESSION['error_message'] = 'Erreur lors de la mise à jour du nom de l\'équipe.';
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Une erreur est survenue lors de la mise à jour de la base de données.';
        }

        // Rediriger vers la page de gestion d'équipe ou toute autre page appropriée
        header('Location: mon_compte.php');
        exit();
    } else {
        // Données du formulaire manquantes
        $_SESSION['error_message'] = 'Données du formulaire manquantes.';
        header('Location: mon_compte.php');
        exit();
    }
} else {
    // Accès non autorisé
    $_SESSION['error_message'] = 'Accès non autorisé.';
    header('Location: mon_compte.php');
    exit();
}

?>
