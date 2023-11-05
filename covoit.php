<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Covoiturages - MMI LAN</title>
</head>
<body>
    <?php 
        session_start();
        $_SESSION["playerId"] = 1;
    ?>
    <h1>Covoiturage</h1>
    <p>Un système de covoiturage est mis en place pour permettre au plus grand nombre d'étudiants de participer à la MMI LAN !</p>
    <h2>Je veux :</h2>
    <div id="choix">
        <div id="propTrajet">
            <p>Proposer un covoiturage</p>
            <a href="propCovoit.php">➡️</a>
        </div>
        <div id="voirTrajet">
            <p>Trouver un covoiturage</p>
            <a href="afficheCovoits.php">➡️</a>
        </div>
    </div>
    <p>Ensemble, rendons nos trajets vers la MMI LAN aussi pratique et écologique que possible  !</p>
</body>
</html>