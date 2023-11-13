<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/style/header.css">
    <title>Header</title>
    <link rel="shortcut icon" href="./assets/img/logo.png" type="image/x-icon">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <script>
        
        $(document).ready(function(){
            $(".steak").click(function(){
                // Inverser la visibilité du contenu burger
                $(".rubriques_burger").show();
                $(".croix_fermer").show();
                $(".steak").hide();
                $
            });

            // Ajoutez cette fonction pour gérer le clic sur la croix
            $(".croix_fermer").click(function(){
                // Masquer le contenu burger en le faisant glisser vers le haut
                $(".rubriques_burger").hide();
                $(".croix_fermer").hide();
                $(".steak").show();

            });
        });

    </script>

</head>
<body>

    <div class="main">
        <div id="div_logo">
            <a href=""><img src="./assets/img/logo.png" alt="logo mmilan" id="logo"></a>
        </div>
        <div class="rubriques">
            <div class="rubrique_content"><a href="" class="bouton_rubrique">Équipes</a></div>
            <div class="rubrique_content"><a href="" class="bouton_rubrique">Planning</a></div>
            <div class="rubrique_content"><a href="" class="bouton_rubrique">Covoiturage</a></div>
        </div>
        <div class="contact"><a href="" id="bouton_contact">Contact</a></div>
        <div class="participer"><a href="" id="bouton_participer">Participer à la lan</a></div>
        <div class="compte"><a href=""><img id="icon_compte" src="./assets/img/compte.png" alt="icone de compte"></a></div>
        <div id="burger">
            <div id="bouton_burger">
                <div class="steak"></div>
                <div class="steak"></div>
                <div class="steak"></div>
                <div id="fermer"><img id="croix_fermer" src="./assets/img/fermer.png" alt=""></div>
                <div class="rubriques_burger">
                    <div class="content_burger">Équipes</div>
                    <div class="content_burger">Planning</div>
                    <div class="content_burger">Covoiturage</div>
                    <div class="content_burger">Contact</div>
                    <div class="content_burger">Participer à la LAN</div>
                    <div class="content_burger">Se connecter</div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>