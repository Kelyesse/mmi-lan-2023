<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['logoFile']) && isset($_POST['teamId'])) {
    // Se connecter à la base de données en utilisant des requêtes préparées
    require_once('connexionbdd.php');

    // Récupérer et valider l'ID de l'équipe
    $teamId = filter_var($_POST['teamId'], FILTER_VALIDATE_INT);
    if ($teamId === false || $teamId <= 0) {
        // Rediriger avec un message d'erreur si l'ID de l'équipe n'est pas valide
        $_SESSION['error_message'] = 'ID de l\'équipe non valide.';
        header('Location: ./mon_compte.php');
        exit();
    }

    // Vérifier si l'équipe existe et si l'utilisateur est le créateur en utilisant une requête préparée
    $stmt = $db->prepare('SELECT * FROM belongteam WHERE TeamId = ? AND PlayerId = ? AND BelongRole = "Créateur"');
    $stmt->execute([$teamId, $_SESSION['PlayerId']]);
    $teamData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($teamData) {
        // Définir le dossier de téléchargement
        $uploadDirectory = './assets/img/';

        // Vérifier si le dossier existe, sinon le créer
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }

        // Valider le type et la taille du fichier téléchargé
        $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];
        $maxFileSize = 5 * 1024 * 1024; // 5 Mo

        $fileExtension = pathinfo($_FILES['logoFile']['name'], PATHINFO_EXTENSION);

        if (!in_array(strtolower($fileExtension), $allowedFileTypes) || $_FILES['logoFile']['size'] > $maxFileSize) {
            // Rediriger avec un message d'erreur si le fichier n'est pas valide
            $_SESSION['error_message'] = 'Le type ou la taille du fichier n\'est pas valide.';
            header('Location: ./mon_compte.php');
            exit();
        }

        // Générer un nom de fichier unique avec le nom de l'équipe
        $teamName = $teamData['TeamName'];
        $newFileName = strtolower(str_replace(' ', '_', $teamName)) . '_logo.' . $fileExtension;

        // Déplacer le fichier téléchargé vers le dossier
        $targetPath = $uploadDirectory . $newFileName;
        if (!move_uploaded_file($_FILES['logoFile']['tmp_name'], $targetPath)) {
            // Rediriger avec un message d'erreur si le déplacement du fichier échoue
            $_SESSION['error_message'] = 'Le téléchargement du fichier a échoué.';
            header('Location: ./mon_compte.php');
            exit();
        }

        // Mettre à jour le chemin du logo dans la base de données en utilisant une requête préparée
        $updateQuery = $db->prepare('UPDATE team SET TeamLogo = ? WHERE TeamId = ?');
        $updateQuery->execute([$newFileName, $teamId]);

        // Rediriger avec un message de succès
        $_SESSION['success_message'] = 'Logo changé avec succès !';
        header('Location: ./mon_compte.php');
        exit();
    } else {
        // Rediriger avec un message d'erreur si l'utilisateur n'est pas autorisé à changer le logo
        $_SESSION['error_message'] = 'Vous n\'êtes pas autorisé à changer le logo de cette équipe.';
        header('Location: ./mon_compte.php');
        exit();
    }
} else {
    // Rediriger avec un message d'erreur si la requête n'est pas correcte
    $_SESSION['error_message'] = 'Une erreur s\'est produite lors du changement de logo.';
    header('Location: ./mon_compte.php');
    exit();
}
