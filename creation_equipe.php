<?php
require_once 'connexion.php';

function getPlayersOptions($bdd) {
    $options = '';
    $result = $bdd->query("SELECT PlayerId, PlayerPseudo FROM player");
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value=\"{$row['PlayerId']}\">{$row['PlayerPseudo']}</option>";
    }
    return $options;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teamName = $_POST['nom'];
    $teamDesc = $_POST['desc_team'];
    $playerOneId = $_POST['player-one'];
    $playerTwoId = $_POST['player-two'];
    $creatorDesc = $_POST['desc_creator'];

    if (empty($teamName)) {
        die('Le nom de l\'équipe est obligatoire.');
    }

    $teamStatus = empty($playerTwoId) ? 'active' : 'full';

    if (isset($_FILES['img_equipe']) && $_FILES['img_equipe']['error'] == 0) {
        $allowed = ['png', 'jpeg', 'jpg', 'gif'];
        $filename = $_FILES['img_equipe']['name'];
        $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (!in_array($file_ext, $allowed)) {
            die('Type de fichier non autorisé pour le logo.');
        }

        $logoData = file_get_contents($_FILES['img_equipe']['tmp_name']);
        $logoData = mysqli_real_escape_string($bdd, $logoData);
    } else {
        die('Erreur lors du téléchargement du logo.');
    }

    $query = $bdd->prepare("INSERT INTO team (TeamName, TeamLogo, TeamStatus, TeamDesc) VALUES (?, ?, ?, ?)");
    $query->bind_param("ssss", $teamName, $logoData, $teamStatus, $teamDesc);
    if ($query->execute()) {
        $teamId = $query->insert_id;

        $belongQuery = $bdd->prepare("INSERT INTO belong (PlayerId, TeamId, BelongRole, BelongStatus) VALUES (?, ?, 'membre', 'actif')");
        if (!empty($playerOneId)) {
            $belongQuery->bind_param("ii", $playerOneId, $teamId);
            $belongQuery->execute();
        }
        if (!empty($playerTwoId)) {
            $belongQuery->bind_param("ii", $playerTwoId, $teamId);
            $belongQuery->execute();
        }

        echo "<p>Équipe créée avec succès ! ID de l'équipe : {$teamId}</p>";
    } else {
        echo "<p>Erreur : " . $query->error . "</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création d'équipe</title>
    <link rel="stylesheet" href="./assets/style/crea_equipe.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</head>
<body>
    <header>
        <?php
        include('./navbar.php');
        ?>
    </header>
    </div>
    <main>
        <div>
            <div id="title">
                <h1>Création d'équipe</h1>
                <h2>Créer votre propre équipe !</h2>
            </div>
            <div id="form">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <input type="text" placeholder="Nom de l'équipe" name="nom" id="nom" required><br>
                    <input type="file" name="img_equipe" id="img_equipe" required><br>
                    <select name="player-one" id="player-one" required><br><br>
                        <option value="">Sélectionnez un joueur</option>
                        <?php echo getPlayersOptions($bdd); ?>
                    </select><br>
                    <select name="player-two" id="player-two">
                        <option value="">Sélectionnez un deuxième joueur (optionnel)</option>
                        <?php echo getPlayersOptions($bdd); ?>
                    </select><br><br>
                    <textarea placeholder="Écrire une description de l’équipe" name="desc_team" id="desc_team" cols="30" rows="10" required></textarea><br>
                    <textarea placeholder="Écrire une description de vous" name="desc_creator" id="desc_creator" cols="30" rows="10" required></textarea><br>
                    <input type="submit" id="submit" value="Rejoindre l’aventure">
                </form>
            </div>
        </div>
    </main>
</body>
<script src="./assets/js/joueur2.js"></script>
<script src="./assets/js/countDown.js"></script>
</html>
