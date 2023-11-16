<?php
session_start();
// Inclure la connexion à la base de données
include_once 'connexionbdd.php';

try {
    // Vérifier si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer le nouveau pseudo depuis le formulaire
        $newPseudo = $_POST['newPseudo'];

        if (!preg_match('/^[a-zA-ZÀ-ÖØ-öø-ÿ]+$/', $newPseudo)) {
            $_SESSION['error_message'] = 'Le pseudo doit contenir uniquement des lettres minuscules et majuscules.';
            // Redirection si la session existe pas
            header('Location: mon_compte.php');
            exit();
        } else {
            if (isset($_SESSION['PlayerId'])) {
                // Récupérer l'identifiant du joueur
                $playerId = $_SESSION['PlayerId'];

                // Préparer la requête SQL pour mettre à jour le pseudo
                $sql = "UPDATE player SET PlayerPseudo = :newPseudo WHERE PlayerId = :playerId";

                // Préparer la requête
                $stmt = $db->prepare($sql);

                // Liaison des paramètres
                $stmt->bindParam(':newPseudo', $newPseudo, PDO::PARAM_STR);
                $stmt->bindParam(':playerId', $playerId, PDO::PARAM_INT);

                // Exécution de la requête
                if ($stmt->execute()) {
                    // La mise à jour a réussi
                    $_SESSION['error_message'] = 'Vous venez de changer votre pseudo.';
                    header('Location: mon_compte.php');
                    exit();
                } else {
                    $_SESSION['error_message'] = 'Erreur lors de la mise à jour du pseudo.';
                }
            } else {
                // Redirection si la session existe pas
                header('Location: connexion.php');
                exit();
            }
        }
    } else {
        // Redirection si le formulaire n'a pas été soumis
        header('Location: mon_compte.php');
        exit();
    }
} catch (PDOException $e) {
    // Gestion des erreurs liées à la base de données
    $_SESSION['error_message'] = 'Erreur de base de données : ' . $e->getMessage();
    header('Location: mon_compte.php');
    exit();
} catch (Exception $e) {
    // Gestion des autres erreurs
    $_SESSION['error_message'] = 'Une erreur inattendue s\'est produite : ' . $e->getMessage();
    header('Location: mon_compte.php');
    exit();
}
