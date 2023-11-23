<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Covoitutrage</title>
    <link rel="stylesheet" href="./assets/style/Covoiturage.css" />
    <link rel="icon" href="./assets/img/favicon.png" type="image/x-icon" />
  </head>

  <header>
    <?php include('navbar.php'); ?>
  </header>
  <body>
    <div id="main">
      <div>
        <div class="titre">
          <h1>COVOITURAGE</h1>
          <p>
            Un système de covoiturage est mis en place pour permettre au plus
            grand nombre d'étudiants de participer à la MMI LAN !
          </p>
        </div>
        <div id="choix">
          <h2>Je veux :</h2>
          <?php 
            if(isset($_SESSION['PlayerId'])){
              $href="covoiturage_conducteur.php";
            }
            else{
              $href="";
            }
          ?>
          <a href=<?php echo $href?>>
            <div id="propTrajet">
              <p>Proposer un covoiturage</p>
              <img src="./assets/img/fleche_droite.svg" alt="icon flèche" />
            </div>
          </a>
          <a href="covoiturage_passager.php">
            <div id="voirTrajet">
              <p>Trouver un covoiturage</p>
              <img src="./assets/img/fleche_droite.svg" alt="icon flèche" />
            </div>
          </a>
        </div>
      </div>

      <p class="message">
        Ensemble, rendons nos trajets vers la MMI LAN aussi pratique et
        écologique que possible !
      </p>
    </div>
  </body>
  <?php include('footer.php'); ?>
</html>
