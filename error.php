<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error404 - MMI LAN</title>
    <link rel="stylesheet" href="./assets/style/error.css">

</head>

<body>
    <?php
    include("./navbar.php");
    ?>
    <main>
        <!--texte en fond-->
        <p id="desole">désolé</p>
        <!--premier div avec le texte et bouton-->
        <div id="divfirst">
            <!-- div avec le texte sans le bouton -->
            <div id="divsec">
                <p id="qcq">404</p>
                <p id="exist">La page que vous cherchez n'existe pas</p>
            </div>
            <!--bouton-->
            <a href="./" id="backAcc">Retour à l'accueil</a>
        </div>
    </main>
    <?php
    include("./footer.php");
    ?>
</body>

</html>