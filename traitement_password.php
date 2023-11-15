<?php
session_start();

// Vérifier si la requête provient d'une méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les données du formulaire sont présentes
    if (isset($_POST['userId']) && isset($_POST['newPassword'])) {
        $userId = $_POST['userId'];
        $newPassword = $_POST['newPassword'];

        // Inclure le fichier de connexion à la base de données
        require_once('connexionbdd.php');

        try {
            // Hasher le nouveau mot de passe
            $hashedPassword = hash('sha256', $newPassword);

            // Mettre à jour le mot de passe de l'utilisateur dans la table player
            $updateQuery = 'UPDATE player SET PlayerPassword = :hashedPassword WHERE PlayerId = :userId';
            $stmt = $db->prepare($updateQuery);
            $stmt->bindParam(':hashedPassword', $hashedPassword, PDO::PARAM_STR);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

            // Exécuter la requête
            if ($stmt->execute()) {
                // Mise à jour réussie
                $_SESSION['success_message'] = 'Le mot de passe a été mis à jour avec succès.';
            } else {
                // Échec de la mise à jour
                $_SESSION['error_message'] = 'Erreur lors de la mise à jour du mot de passe.';
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Une erreur est survenue lors de la mise à jour de la base de données.';
        }

        // Rediriger vers la page de profil ou toute autre page appropriée
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
