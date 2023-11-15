<?php
// Inclure la connexion à la base de données
include_once 'connexionbdd.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer le nouveau pseudo depuis le formulaire
    $newPseudo = $_POST['newPseudo'];

    // Récupérer l'identifiant du joueur
    $playerId = $_SESSION['PlayerId'];

    // Préparer la requête SQL pour mettre à jour le pseudo
    $sql = "UPDATE player SET PlayerPseudo = :newPseudo WHERE PlayerId = :playerId";

    // Préparer la requête
    $stmt = $pdo->prepare($sql);

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
    // Redirection si le formulaire n'a pas été soumis
    header('Location: index.php');
    exit();
}
