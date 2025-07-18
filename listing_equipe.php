<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Equipes - MMI LAN</title>
    <link rel="stylesheet" href="./assets/style/style_listing_equipe.css">
    <link rel="stylesheet" href="./assets/style/variables.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="icon" href="./assets/img/favicon.png" type="image/x-icon">
</head>

<body>
    <header>
        <?php include 'navbar.php';?>
    </header>

    <main>
        <?php
            require_once("connexionbdd.php");
            if(isset($_POST['Tscore'])){
                $req = $db->prepare('UPDATE team SET TeamScore=? WHERE TeamId=?');
                $req->execute([$_POST['Tscore'], $_POST['Tid']]);
            }
        ?>
        <div class="en-tete">
            <h1>LES ÉQUIPES DE LA MMI LAN</h1>
            <div class="tri-container">
                <div class="tri-btn">
                    <div class="tri-text">Trier</div>
                    <div class="tri-svg"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 10">
                            <path
                                d="M8 10.828 1.354 4.182a1 1 0 0 1 1.414-1.414L8 8.586l5.232-5.232a1 1 0 1 1 1.414 1.414L8 10.828z" />
                        </svg>
                    </div>
                </div>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="listing_equipe.php?order=recent">Plus Récent</a>
                    <a class="dropdown-item" href="listing_equipe.php?order=ancien">Plus Ancien</a>
                    <a class="dropdown-item" href="listing_equipe.php?order=asc">Ordre Alphabétique</a>
                    <a class="dropdown-item" href="listing_equipe.php?order=desc">Inverse Alphabétique</a>
                </div>
            </div>
        </div>

        <div class="liste_equipe">

            <?php include 'listing_equipe_vignette.php'; ?>

        </div>
        <!--     <div class="LOGO"> 

    <?php //include 'listing_equipe_logo.php' ; ?>
    
    </div> -->
        <?php
        if (isset($_GET['rejoindreEquipe'])) {
            $teamName = $_GET['teamName'];
            $teamId = $_GET['teamId'];
        }
        ?>
        <div id="alertRejoindreEquipe">
            <h2>Vous allez rejoindre l'équipe
                <?php echo $teamName ?>
            </h2>
            <form action="rejoindreEquipe.php?teamId=<?php echo $teamId ?>" method="post">
                <textarea name="playerDesc" id="" cols="30" rows="10"
                    placeholder="Écrivez une description de vous..."></textarea>
                <div>
                    <input type="button" onclick='window.location.href="listing_equipe.php"' value="J'ai changé d'avis">
                    <input type="submit" value="Rejoindre">
                </div>
            </form>
        </div>
        <?php
        function showAlertForm()
        {
            if (isset($_GET['rejoindreEquipe'])) {
                echo '<script>blocAlert = document.getElementById("alertRejoindreEquipe"); blocAlert.style.display = "flex";</script>';
                echo '<script> document.getElementById("alertRejoindreEquipe").scrollIntoView({ behavior: "smooth", block: "start" });</script>';

            }
        }
        showAlertForm();
        ?>

        <section class="bottom-section">
            <?php
            if (!isset($_SESSION['PlayerId'])) {
                echo '<div class="bottom">';
                echo "<h2>Vous n'avez pas d'équipe ?</h2>";
                $onclickInscription = 'window.location.href="inscription.php"';
                echo '<button class="bottom-bouton" onclick=' . $onclickInscription . '>Inscrivez-vous</button>';
                echo '</div>';
            } else {
                require_once('connexionbdd.php');
                $req = $db->prepare('SELECT PlayerStatus FROM player WHERE PlayerId=?');
                $req->execute([$_SESSION['PlayerId']]);
                $status = $req->fetch()['PlayerStatus'];
                $req = $db->prepare("SELECT PlayerId FROM belongteam");
                $req->execute();
                $equipierId = $req->fetchAll();
                $dansequipe = false;
                foreach ($equipierId as $equipier) {
                    if (in_array($_SESSION['PlayerId'], $equipier)) {
                        $dansequipe = true;
                        break;
                    }
                }
                if ($status == "Participant" && !$dansequipe) {
                    echo '<div class="bottom">';
                    echo '<h2>Vous voulez créer votre équipe ?</h2>';
                    $onclickEquipe = 'window.location.href="creation_equipe.php"';
                    echo '<button class="bottom-bouton" onclick=' . $onclickEquipe . '>Créer une équipe</button>';
                    echo '</div>';
                }
            }
            ?>
        </section>

        <!--JQUERY pour survol de la galerie-->
        <script>
            $(document).ready(function () {
                $('.LOGO img').hover(
                    function () {
                        // Survol de l'image
                        var altText = $(this).attr('alt');
                        // Ajoutez le texte alternatif à l'intérieur de l'image
                        $(this).after('<div class="hover-text">' + altText + '</div>');
                    },
                    function () {
                        // Fin du survol de l'image
                        // Supprimez le texte alternatif lorsqu'il n'y a plus de survol
                        $(this).next('.hover-text').remove();
                    }
                );
            });
        </script>



    </main>

    <?php include 'footer.php'; ?>
</body>

</html>