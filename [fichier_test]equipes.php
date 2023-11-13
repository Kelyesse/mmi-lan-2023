<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    session_start();
    $_SESSION["playerId"] = 6;
    require_once("[fichier_test]connexionbdd.php");
    $req = $db->prepare("SELECT * FROM team");
    $req->execute();
    while ($team = $req->fetch()) {
        $onclick = 'window.location.href="details_equipes.php?teamId=' . $team['TeamId'] . '"';
        echo '<div onclick=' . $onclick . '>';
        echo '<img src="./assets/img/' . $team['TeamLogo'] . '">';
        echo '</div>';
    }
    ?>
</body>

</html>