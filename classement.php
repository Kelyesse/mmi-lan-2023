<?php
include './connexionbdd.php';
session_start();

$sql = "SELECT * FROM team ORDER BY TeamScore DESC";
$stmt = $db->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <div id="board-title" class="board-title">L’équipe vainqueur est: </div>
        <div id="board" class="leaderboard">
            <?php
            if (count($result) > 0) {
                $position = 1;
                foreach ($result as $row) {
                    $class = ($position == 1) ? 'first-place' : (($position == 2) ? 'second-place' : (($position == 3) ? 'third-place' : 'normal-place'));

                    echo "<div class='team-block " . ($position > 3 ? "" : $class) . "'>";
                    echo "<div class='team-info'>";
                    echo "<img src='" . htmlspecialchars($row["TeamLogo"]) . "' alt='Team Logo' class='team-logo'>";
                    echo "<div class='team-details'>";
                    echo "<h3>" . htmlspecialchars($row["TeamName"]) . "</h3>";
                    echo "<p>" . htmlspecialchars($row["TeamScore"]) . " Points</p>";
                    echo "</div>"; 
                    echo "</div>"; 
                    echo "</div>"; 
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