<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/style/header.css">
    <title>Header</title>
    <link rel="shortcut icon" href="./assets/img/logo.png" type="image/x-icon">
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
            <a href=""><img src="./assets/img/logo.png" alt="logo mmilan" id="logo"></a>
        </div>

        <div id="nav">
            <div class="rubriques">
                <div class="rubrique_content"><a href="" class="bouton_rubrique">Équipes</a></div>
                <div class="rubrique_content"><a href="" class="bouton_rubrique">Planning</a></div>
                <div class="rubrique_content"><a href="" class="bouton_rubrique">Covoiturage</a></div>
            </div>
            <div class="contact"><a href="" id="bouton_contact">Contact</a></div>
            <div class="participer"><a href="" id="bouton_participer">Participer à la lan</a></div>
            <div class="compte">
                <a href="">
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
                    <div><a href="" class="content_burger">Équipes</a></div>
                    <div><a href="" class="content_burger">Planning</a></div>
                    <div><a href="" class="content_burger">Covoiturage</a></div>
                    <div><a href="" class="content_burger" id="burger_contact">Contact</a></div>
                    <div><a href="" class="content_burger" id="burger_play">Participer à la LAN</a></div>
                </div>
            </div>
        </div>
    </div>

    <div id="navbar-countdown" class="count-down-timer"></div>
    <script src="./assets/js/navbarCountDown.js"></script>


</body>

</html>