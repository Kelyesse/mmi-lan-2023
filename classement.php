<?php
session_start();
// Requête SQL pour récupérer le classement des équipes (à adapter selon votre structure de base de données)
$sql = "SELECT * FROM team ORDER BY TeamScore DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classement - MMI LAN</title>
    <link rel="shortcut icon" href="./assets/img/favicon.png">
    <link rel="stylesheet" href="./assets/style/header.css">
    <link rel="stylesheet" href="./assets/style/game.css">
    <link rel="stylesheet" href="./assets/style/footer.css">
    <link rel="stylesheet" href="./assets/style/classement.css">
</head>



<body>
    <?php include './navbar.php'; ?>
    <h1 class="en-tete">LES ÉQUIPES DE LA MMI LAN</h1>
    <div id="board-container">
        <div id="board-title" class="board-title">l’équipe vainqueur est: </div>
        <div id="board" class="leaderboard">
            <?php
            // Afficher les données du classement
            if ($result->num_rows > 0) {
                $position = 1;
            while ($row = $result->fetch_assoc()) {
                $class = ($position == 1) ? 'first-place' : (($position == 2) ? 'second-place' : (($position == 3) ? 'third-place' : 'normal-place'));

            if ($position > 3) {
                echo "<div class='team-block'>";
            } else {
                echo "<div class='team-block $class'>";
            }

            echo "<div class='team-info'>";
            echo "<img src='" . $row["TeamLogo"] . "' alt='Team Logo' class='team-logo'>";
            echo "<div class='team-details'>";
            echo "<h3>" . $row["TeamName"] . "</h3>";
            echo "<p>" . $row["TeamScore"] . " Points</p>";
            echo "</div>"; // Fermeture de la div team-details
            echo "</div>"; // Fermeture de la div team-info
            echo "</div>"; // Fermeture de la div team-block
            $position++;
            }
            } else {
            echo "<p>Aucune équipe trouvée.</p>";
            }
            ?>

        </div>
    </div>
    <?php include './footer.php'; ?>
</body>

</html>
<?php
$conn->close();
?>