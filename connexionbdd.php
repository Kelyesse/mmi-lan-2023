<?php
function Connexion()
{
    $hostname = '127.0.0.1:3306';

    $username = 'u886930443_Alexandre';
    $password = '$+DU#f8&N';
    $db = 'u886930443_mmilan';
    // Data Source Name
    $dsn = "mysql:host=$hostname;dbname=$db;charset=utf8mb4";
    try {
        $bdd = new PDO($dsn, $username, $password);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $bdd;
    } catch (PDOException $e) {
        echo "Erreur de connection ! </br>";
        echo $e->getMessage();
    }
}
$db = connexion();

if (!isset($_SESSION['PlayerId'])) {
    // Vérifiez si le cookie "remember_user" existe
    if (isset($_COOKIE['remember_user'])) {
        // Récupérez l'identifiant unique stocké dans le cookie
        $remember_user_id = $_COOKIE['remember_user'];

        // Assurez-vous que l'identifiant unique est une chaîne non vide
        if (!empty($remember_user_id)) {
            // Utilisez l'identifiant unique pour récupérer les informations de connexion côté serveur
            $stmt = $db->prepare("SELECT * FROM player WHERE PlayerId = :remember_user_id");
            $stmt->bindParam(':remember_user_id', $remember_user_id, PDO::PARAM_INT);
            $stmt->execute();
            $player = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérifiez si l'utilisateur a été trouvé
            if ($player) {
                // Connectez automatiquement l'utilisateur
                $_SESSION['PlayerId'] = $player['PlayerId'];
            }
        }
    }
}

// Si le script atteint ce point, l'utilisateur n'est pas connecté automatiquement
