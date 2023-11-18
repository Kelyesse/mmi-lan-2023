<?php
session_start();

// Vérifier si la requête provient d'une méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les données du formulaire sont présentes
    if (isset($_POST['userId']) && isset($_POST['oldPassword']) && isset($_POST['newPassword']) && isset($_POST['confirmPassword'])) {
        $userId = $_POST['userId'];
        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];

        // Vérifier les critères du nouveau mot de passe
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[\w\d\S]{8,}$/', $newPassword)) {
            $_SESSION['error_message'] = 'Les mots de passe ne respectent pas les critères.';
            header('Location: mon_compte.php');
            exit();
        }

        // Inclure le fichier de connexion à la base de données
        require_once('connexionbdd.php');

        try {
            // Récupérer l'ancien mot de passe de l'utilisateur depuis la base de données
            $getOldPasswordQuery = 'SELECT PlayerPassword FROM player WHERE PlayerId = :userId';
            $stmtOld = $db->prepare($getOldPasswordQuery);
            $stmtOld->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmtOld->execute();
            $oldPasswordHash = $stmtOld->fetchColumn();

            // Vérifier si l'ancien mot de passe correspond
            if (password_verify($oldPassword, $oldPasswordHash)) {
                // Vérifier la correspondance du nouveau mot de passe avec le champ de confirmation
                if ($newPassword === $confirmPassword) {
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
                } else {
                    // Les nouveaux mots de passe ne correspondent pas
                    $_SESSION['error_message'] = 'Les nouveaux mots de passe ne correspondent pas.';
                }
            } else {
                // Ancien mot de passe incorrect
                $_SESSION['error_message'] = 'Ancien mot de passe incorrect.';
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
