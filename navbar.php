<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
include_once("connexionbdd.php");
$playLink = './inscription.php';
$accountLink = './connexion.php';
if (isset($_SESSION['PlayerId'])) {
    $playLink = './listing_equipe.php';
    $accountLink = './mon_compte.php';
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/style/header.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>

        $(document).ready(() => {
            $(".bouton_burger").click(() => {
                $(".bouton_burger").hide();
                $(".rubriques_burger").show();
                $("#burger-close").show();
                $("#croix_fermer").show();
            });

            $("#burger-close").click(() => {
                $("#burger-close").hide();
                $(".rubriques_burger").hide();
                $(".bouton_burger").show();


            });
        });


    </script>

</head>

<body>
    <div id="navbar-main">
        <div id="div_logo">
            <a href="./"><img src="./assets/img/logo.png" alt="logo mmilan" id="logo"></a>
        </div>

        <div id="nav">
            <div class="rubriques">
                <div class="rubrique_content"><a href="./listing_equipe.php" class="bouton_rubrique">Équipes</a></div>
                <div class="rubrique_content"><a href="#" class="bouton_rubrique" id="planning-button">Planning</a>
                </div>
                <div class="rubrique_content">
                    <a href="#" class="bouton_rubrique" id="covoit-button">Covoiturage</a>
                </div>
            </div>
            <div class="contact"><a href="./contact.php" id="bouton_contact">Contact</a></div>
            <div class="participer"><a href="<?php echo $playLink; ?>" id="bouton_participer">Participer à la lan</a>
            </div>
            <div class="compte">
                <a href="<?php echo $accountLink; ?>">
                    <img id="icon_compte" src="./assets/img/compte.png" alt="icone de compte">
                </a>
            </div>
            <div id="burger">
                <div class="bouton_burger">
                    <div class="steak"></div>
                    <div class="steak"></div>
                    <div class="steak" id="steak3"></div>
                </div>
                <div id="burger-close"><img id="croix_fermer" src="./assets/img/fermer.png" alt="">
                </div>
                <div class="rubriques_burger">
                    <div><a href="./listing_equipe.php" class="content_burger">Équipes</a></div>
                    <div><a href="#" class="content_burger" id="planning-button">Planning</a></div>
                    <div><a href="#" class="content_burger" id="covoit-button">Covoiturage</a></div>
                    <div><a href="./contact.php" class="content_burger" id="burger_contact">Contact</a></div>
                    <div><a href="<?php echo $playLink; ?>" class="content_burger" id="burger_play">
                            Participer à la LAN
                        </a>
                    </div>
                    <div><a href="<?php echo $accountLink; ?>" class="content_burger" id="burger_contact">Compte</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="navbar-countdown" class="count-down-timer"></div>
    <script src="./assets/js/navbarCountDown.js"></script>
    <script src="./assets/js/navbarComingSoon.js"></script>
</body>

</html>