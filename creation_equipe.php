<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once('connexionbdd.php');

function getPlayersOptions($db, $excludePlayerId = null)
{
    $options = '';
    $query = "SELECT PlayerId, PlayerPseudo FROM player";
    if ($excludePlayerId !== null) {
        $query .= " WHERE PlayerId != :excludePlayerId";
    }
    $stmt = $db->prepare($query);
    if ($excludePlayerId !== null) {
        $stmt->bindParam(':excludePlayerId', $excludePlayerId, PDO::PARAM_INT);
    }
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $options .= "<option value=\"{$row['PlayerId']}\">{$row['PlayerPseudo']}</option>";
    }
    return $options;
}

$creatorId = isset($_SESSION['PlayerId']) ? $_SESSION['PlayerId'] : null;
$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teamName = $_POST['nom'];
    $teamDesc = $_POST['desc_team'];
    // $playerOneId = $_POST['player-one'];
    // $playerTwoId = $_POST['player-two'];
    // $creatorDesc = $_POST['desc_creator'];
    if (strlen($teamDesc) >= 255) {
        $errorMessage = 'Votre description est trop longue ! (max: 255 caractères)';
    }
    if (strlen($teamName) >= 45) {
        $errorMessage = 'Votre nom d"équipe est trop long ! (max: 45 caractères)';
    }
    if (empty($teamName)) {
        die('Le nom de l\'équipe est obligatoire.');
    }

    $checkQuery = $db->prepare("SELECT TeamId FROM team WHERE TeamName = ?");
    $checkQuery->bindParam(1, $teamName);
    $checkQuery->execute();
    if ($checkQuery->rowCount() > 0) {
        die('Une équipe avec ce nom existe déjà.');
    }

    // $teamStatus = empty($playerTwoId) ? 'active' : 'full';
    $teamStatus = 'active';


    if (isset($_FILES['img_equipe']) && $_FILES['img_equipe']['error'] == 0) {
        $allowed = ['png', 'jpeg', 'jpg'];
        $filename = $_FILES['img_equipe']['name'];
        $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (!in_array($file_ext, $allowed)) {
            die('Type de fichier non autorisé pour le logo.');
        }

        $uploadDirectory = "./assets/img/";
        $filenameToSave = $teamName . '_logo.' . $file_ext;
        $fullPath = $uploadDirectory . $filenameToSave;

        if (!move_uploaded_file($_FILES['img_equipe']['tmp_name'], $fullPath)) {
            die('Erreur lors de la sauvegarde du fichier.');
        }
    } else {
        die('Erreur lors du téléchargement du logo.');
    }
    if (!$errorMessage) {


        $insertQuery = $db->prepare("INSERT INTO team (TeamName, TeamLogo, TeamStatus, TeamDesc) VALUES (?, ?, ?, ?)");
        $insertQuery->bindParam(1, $teamName);
        $insertQuery->bindParam(2, $filenameToSave);
        $insertQuery->bindParam(3, $teamStatus);
        $insertQuery->bindParam(4, $teamDesc);
        if ($insertQuery->execute()) {
            $teamId = $db->lastInsertId();

            if ($creatorId) {
                $belongQuery = $db->prepare("INSERT INTO belongteam (PlayerId, TeamId, BelongRole, BelongStatus) VALUES (?, ?, 'Créateur', 'validé')");
                $belongQuery->bindParam(1, $creatorId, PDO::PARAM_INT);
                $belongQuery->bindParam(2, $teamId, PDO::PARAM_INT);
                $belongQuery->execute();
            }

            // if (!empty($playerOneId) && $playerOneId != $creatorId) {
            //     $belongQuery = $db->prepare("INSERT INTO belongteam (PlayerId, TeamId, BelongRole, BelongStatus) VALUES (?, ?, 'participant', 'validé')");
            //     $belongQuery->bindParam(1, $playerOneId, PDO::PARAM_INT);
            //     $belongQuery->bindParam(2, $teamId, PDO::PARAM_INT);
            //     $belongQuery->execute();
            // }

            // if (!empty($playerTwoId) && $playerTwoId != $creatorId) {
            //     $belongQuery = $db->prepare("INSERT INTO belongteam (PlayerId, TeamId, BelongRole, BelongStatus) VALUES (?, ?, 'participant', 'validé')");
            //     $belongQuery->bindParam(1, $playerTwoId, PDO::PARAM_INT);
            //     $belongQuery->bindParam(2, $teamId, PDO::PARAM_INT);
            //     $belongQuery->execute();
            // }

            echo "<p>Votre équipe a été créée avec succès !</p>";
            header('Location: listing_equipe.php');
        } else {
            $errorInfo = $insertQuery->errorInfo();
            echo "<p>Erreur lors de l’exécution de la requête : " . htmlspecialchars($errorInfo[2]) . "</p>";
        }
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
            <?php
            if ($errorMessage) {
                echo '  <span class="error-message">
                    ' . $errorMessage . '
                </span>';
            }
            ?>

            <div id="form">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                    enctype="multipart/form-data">
                    <input type="text" placeholder="Nom de l'équipe" name="nom" id="nom" required><br>
                    <div class="import-file">
                        <label for="img_equipe" class="custom-file-upload">
                            Importez un logo pour votre équipe
                        </label>
                        <input type="file" name="img_equipe" id="img_equipe" required accept='.png,.jpg,.jpeg'>
                    </div>
                    <br>
                    <!-- <select name="player-one" id="player-one">
                        <option value="">Sélectionnez un joueur</option>
                        <?php // echo getPlayersOptions($db, $creatorId); ?>
                    </select><br>

                    <select name="player-two" id="player-two">
                        <option value="">Sélectionnez un deuxième joueur (optionnel)</option>
                        <?php  // echo getPlayersOptions($db, $creatorId); ?>
                    </select><br><br> -->
                    <textarea placeholder="Écrire une description de l’équipe" name="desc_team" id="desc_team" cols="30"
                        rows="10" required></textarea><br>
                    <!-- <textarea placeholder="Écrire une description de vous" name="desc_creator" id="desc_creator"
                        cols="30" rows="10" required></textarea><br> -->
                    <input type="submit" id="submit" value="Rejoindre l’aventure">
                </form>
            </div>
        </div>
    </main>
    <?php
    include('footer.php');
    ?>
</body>
<script src="./assets/js/joueur2.js"></script>
<script src="./assets/js/countDown.js"></script>

</html>