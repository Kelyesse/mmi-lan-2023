<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['logoFile']) && isset($_POST['teamId'])) {
    // Se connecter à la base de données
    require_once('connexionbdd.php');

    // Récupérer l'ID de l'équipe
    $teamId = $_POST['teamId'];

    // Vérifier si l'équipe existe et si l'utilisateur est le créateur
    $query = $db->prepare('SELECT * FROM belongteam WHERE TeamId = ? AND PlayerId = ? AND BelongRole = "Créateur"');
    $query->execute([$teamId, $_SESSION['PlayerId']]);
    $teamData = $query->fetch(PDO::FETCH_ASSOC);

    if ($teamData) {
        // Définir le dossier de téléchargement
        $uploadDirectory = './assets/img/';

        // Vérifier si le dossier existe, sinon le créer
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }

        // Récupérer l'extension du fichier
        $fileExtension = pathinfo($_FILES['logoFile']['name'], PATHINFO_EXTENSION);

        // Générer un nom de fichier unique avec le nom de l'équipe
        $teamName = $teamData['TeamName'];
        $newFileName = strtolower(str_replace(' ', '_', $teamName)) . '_logo.' . $fileExtension;

        // Déplacer le fichier téléchargé vers le dossier
        $targetPath = $uploadDirectory . $newFileName;
        move_uploaded_file($_FILES['logoFile']['tmp_name'], $targetPath);

        // Mettre à jour le chemin du logo dans la base de données
        $updateQuery = $db->prepare('UPDATE team SET TeamLogo = ? WHERE TeamId = ?');
        $updateQuery->execute([$targetPath, $teamId]);

        // Rediriger avec un message de succès
        $_SESSION['success_message'] = 'Logo changé avec succès !';
        header('Location: ./mon_compte.php');
        exit();
    } else {
        // Rediriger avec un message d'erreur
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
