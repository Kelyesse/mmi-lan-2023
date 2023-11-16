<?php
session_start();

// Vérifier si la requête provient d'une méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les données du formulaire sont présentes
    if (isset($_POST['userId']) && isset($_POST['newEmail'])) {
        $userId = $_POST['userId'];
        $newEmail = $_POST['newEmail'];

        // Vérifier si l'adresse e-mail est valide
        if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_message'] = 'L\'adresse email n\'est pas valide.';
            header('Location: mon_compte.php');
            exit();
        }

        // Inclure le fichier de connexion à la base de données
        require_once('connexionbdd.php');

        try {
            // Mettre à jour l'adresse e-mail de l'utilisateur dans la table player
            $updateQuery = 'UPDATE player SET PlayerEmail = :newEmail WHERE PlayerId = :userId';
            $stmt = $pdo->prepare($updateQuery);
            $stmt->bindParam(':newEmail', $newEmail, PDO::PARAM_STR);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

            // Exécuter la requête
            if ($stmt->execute()) {
                // Mise à jour réussie
                $_SESSION['success_message'] = 'L\'adresse e-mail a été mise à jour avec succès.';
            } else {
                // Échec de la mise à jour
                $_SESSION['error_message'] = 'Erreur lors de la mise à jour de l\'adresse e-mail.';
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
