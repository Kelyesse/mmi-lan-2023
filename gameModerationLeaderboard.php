<?php
if (!isset($_SESSION['PlayerId'])) {
    header('Location: index.php');
    exit;
}

$PlayerId = $_SESSION['PlayerId'];

include_once('./connexionbdd.php');
$sql = "SELECT PlayerStatus FROM player WHERE PlayerId = $PlayerId";
$stmt = $db->query($sql);
$status = $stmt->fetch(PDO::FETCH_COLUMN)[0];

if ($status != "AdminJeu") {
    header('Location: index.php');
    exit;
}

$jsonFilePath = 'assets/json/gameLeaderboard.json';
$content = json_decode(file_get_contents($jsonFilePath), true);

if (isset($_POST['pseudo'])) {
    $pseudo = $_POST['pseudo'];
    $newPseudo = $_POST['newPseudo'];
    $min = $_POST['min'];
    $sec = $_POST['sec'];
    $cent = $_POST['cent'];

    $playerScores = [];

    if (isset($_POST['suppr'])) {
        foreach ($content as $player) {
            if (
                $pseudo != $player['pseudo'] ||
                $min != $player['time']['m'] ||
                $sec != $player['time']['s'] ||
                $cent != $player['time']['ms']
            ) {
                $playerScores[] = $player;
            }
        }
    }

    if (isset($_POST['modif'])) {
        foreach ($content as $player) {
            if (
                $pseudo == $player['pseudo'] &&
                $min == $player['time']['m'] &&
                $sec == $player['time']['s'] &&
                $cent == $player['time']['ms']
            ) {
                $player['pseudo'] = $newPseudo;
            }
            $playerScores[] = $player;
        }
    }

    file_put_contents($jsonFilePath, json_encode($playerScores, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    header('Location: gameModerationLeaderboard.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/style/game_moderation.css">
    <title>Modération leaderboard</title>
</head>

<body>
    <?php foreach ($content as $lines) : ?>
        <form action="./gameModerationLeaderboard.php" method="POST" id="player-score-zone">
            <div id="player-info-zone">
                <div id="player-pseudo-zone">
                    <input type="hidden" value="<?= $lines["pseudo"]; ?>" name="pseudo">
                    <input type="text" value="<?= $lines["pseudo"]; ?>" name="newPseudo" id="player-pseudo-input">
                </div>
                <div id="player-time-zone">
                    <input type="text" value="<?= $lines["time"]["m"]; ?>" name="min" class="player-time-input">:
                    <input type="text" value="<?= $lines["time"]["s"]; ?>" name="sec" class="player-time-input">.
                    <input type="text" value="<?= $lines["time"]["ms"] ?>" name="cent" class="player-time-input">
                </div>

                <?php if ($lines["state"]) : ?>
                    <div id="player-state-green">Visible</div>
                <?php else : ?>
                    <div id="player-state-red">Invisible</div>
                <?php endif; ?>

            </div>

            <div id="player-button-zone">
                <input type="submit" value="Modifier" name="modif" id="player-modif-button">
                <input type="submit" value="Supprimer" name="suppr" id="player-suppr-button">
            </div>
        </form>
    <?php endforeach; ?>
</body>

</html>