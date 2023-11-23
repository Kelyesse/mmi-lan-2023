<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Covoiturage</title>
    <link rel="stylesheet" href="./assets/style/Covoiturage_passager.css" />
    <link rel="stylesheet" href="./assets/style/Covoiturage.css" />
    <link rel="icon" href="./assets/img/favicon.png" type="image/x-icon" />
  </head>
  <header>
    <?php include('navbar.php'); ?>
  </header>
  <body>
    <div id="main">
      <div class="titre">
        <h1>PASSAGER COVOITURAGE</h1>
      </div>
      <?php
          session_start();
          require_once("connexionbdd.php");
          $req = $db->prepare("SELECT * FROM covoit");
          $req->execute();
          echo '<div id="trajets">';
          while($donnees = $req->fetch()){
              //On récupère d'abord les informations du covoiturage (Lieu départ, nb de place, description)
              $idCovoit = $donnees['CovoitId'];
              $lieuDépart = $donnees['CovoitDépart'];
              $desc = $donnees['CovoitDesc'];
              $nbPlaces = $donnees['CovoitPassengers'];
              $class = "trajet-a-prendre";
              //On récupère ensuite les id des passagers
              $req2 = $db->prepare("SELECT PlayerId FROM belongcovoit WHERE CovoitId=? AND BelongCovoitRole=? AND BelongCovoitStatus=?");
              $req2->execute([$idCovoit, "Passager", "validé"]);
              $passagersId = $req2->fetchAll();
              $estPassager = false;
              foreach ($passagersId as $player) {
                  if (in_array($_SESSION['PlayerId'], $player)) {
                      $estPassager = true;
                      $class= "trajet-pris";
                      break;
                  }
              }
    
              //On vérifie ensuite si l'utilisateur est déjà dans un covoiturage
              $req2 = $db->prepare("SELECT PlayerId FROM belongcovoit");
              $req2->execute();
              $dansUnTrajet = $req2->fetchAll();
              $estDansVoiture = false;
              foreach ($dansUnTrajet as $voiture) {
                  if (in_array($_SESSION['PlayerId'], $voiture)) {
                      $estDansVoiture = true;
                      if($class != "trajet-pris"){
                        $class= "trajet-complet";
                      }
                      break;
                  }
              }
              //On récupère ensuite le nom et prénom du conducteur du covoit
              $req2 = $db->prepare("SELECT PlayerId FROM belongcovoit WHERE CovoitId=? AND BelongCovoitRole=?");
              $req2->execute([$idCovoit, "Conducteur"]);
              $conducteurId = $req2->fetch()['PlayerId'];
              $req2 = $db->prepare("SELECT PlayerLastName, PlayerFirstName FROM player WHERE PlayerId=?");
              $req2->execute([$conducteurId]);
              $nomConducteur = $req2->fetch();
              if($conducteurId == $_SESSION['PlayerId']){
                $class= "trajet-pris";
              }
              $req2 = $db->prepare("SELECT COUNT(PlayerId) FROM belongcovoit WHERE CovoitId=? AND BelongCovoitRole=? AND BelongCovoitStatus=?");
              $req2->execute([$idCovoit, "Passager", "validé"]);
              $nbPassagers = $req2->fetch()[0];
              if($nbPlaces-$nbPassagers==0){
                if($class != "trajet-pris"){
                    $class= "trajet-complet";
                  }
              }
              echo '<div class="'.$class.' trajet">';
              //On affiche les premières informations du covoit
              echo '<h3>'.$nomConducteur['PlayerFirstName'].' '.$nomConducteur['PlayerLastName'].'</h3>';
              echo '<h3>'.$lieuDépart.'</h3>';

              //On compte le nombre de places restantes en fonction du nombre de place initial et du nombre de passagers
              
              echo '<h4>'.$nbPlaces-$nbPassagers.' places disponibles</h4>';
              if($passagersId){
                  $passagers = "Passagers : ";
                  $i = 0;
                  foreach ($passagersId as $passager) {
                      $req3= $db->prepare('SELECT PlayerPseudo FROM player WHERE PlayerId=?');
                      $req3->execute([$passager[0]]);
                      $passagerpseudo = $req3->fetch()['PlayerPseudo'];
                      if($i == 0){
                          $passagers .= $passagerpseudo;
                      }
                      else{
                          $passagers .= " - ".$passagerpseudo;
                      }
                      $i++;
                  }
                  echo '<p style="color: white">'.$passagers.'</p>';
              }
              echo '<p>'.$desc.'</p>';
              $req2 = $db->prepare("SELECT PlayerId FROM belongcovoit WHERE CovoitId=? AND BelongCovoitRole=? AND BelongCovoitStatus=?");
              $req2->execute([$idCovoit, "Passager", "en attente"]);
              while($passagersAttente = $req2->fetch()){
                  $req3 = $db->prepare('SELECT PlayerPseudo FROM player WHERE PlayerId=?');
                  $req3->execute([$passagersAttente[0]]);
                  $passagerAttentePseudo = $req3->fetch()['PlayerPseudo'];
                  echo '<p class="passagerAttente">';
                  echo '<span>'.$passagerAttentePseudo.'</span>';
                  echo '<a class="modération" href="accept_passenger.php?playerId='.$passagersAttente[0].'&covoitId='.$idCovoit.'"><button>Accepter</button></a>';
                  echo '<a class="modération" href="reject_passenger.php?playerId='.$passagersAttente[0].'&covoitId='.$idCovoit.'"><button>Refuser</button></a>';
                  echo '</p>';
              }

              //On affiche ensuite un bouton ou un message indiquant l'état du covoiturage ou l'action que l'utilisateur peut faire dessus
              if($conducteurId == $_SESSION['PlayerId']){
                  $onclick='covoiturage_passager.php?supprimerCovoitId='.$idCovoit;
                  echo '<a href="'.$onclick.'"><button>Supprimer mon trajet</button></a>';
              }
              else if($estPassager){
                  $onclick='covoiturage_passager.php?retirerCovoitId='.$idCovoit;
                  echo '<a href="'.$onclick.'"><button>Me retirer du trajet</button></a>';
              }
              else if($estDansVoiture){
                  echo '<a href=""><button>Vous êtes déjà sur un autre trajet</button></a>';
              }
              else if($nbPlaces-$nbPassagers==0){
                  echo '<a href=""><button>Trajet Complet</button></a>';
              }
              else if(isset($_SESSION['PlayerId'])){
                  $onclick='covoiturage_passager.php?rejoindreCovoitId='.$idCovoit;
                  echo '<a href="'.$onclick.'"><button>Me joindre au trajet</button></a>';
              }
              echo '</div>';
            }
          echo '</div>';  
        ?>
    </div>
    <div id="alertRetirerTrajet" hidden>
        <p>Êtes vous sur de vouloir vous retirer du trajet ?</p>
        <?php 
            $onclickValiderRetirer = 'window.location.href="retirerPassager.php?retirerCovoitId='.$_GET['retirerCovoitId'].'"';
            echo '<button id="validerRetirer" onclick='.$onclickValiderRetirer.'>Oui, me retirer de ce trajet</button>';
            $onclickAnnulerRetirer = 'window.location.href="covoiturage_passager.php"';
            echo '<button id="annulerRetirer" onclick='.$onclickAnnulerRetirer.'>Non, j’ai changé d’avis</button>';
        ?>
    </div>
    <div id="alertSupprimerTrajet" hidden>
        <p>Êtes vous sur de vouloir supprimer votre trajet ?</p>
        <?php
            $onclickValiderSupprimer = 'window.location.href="supprimerTrajet.php?supprimerCovoitId='.$_GET['supprimerCovoitId'].'"';
            echo '<button id="validerSupprimer" onclick='.$onclickValiderSupprimer.'>Oui, supprimer mon trajet</button>';
            $onclickAnnulerSupprimer = 'window.location.href="covoiturage_passager.php"';
            echo '<button id="annulerSupprimer" onclick='.$onclickAnnulerSupprimer.'>Non, j’ai changé d’avis</button>';
        ?>
    </div>
    <div id="alertRejoindreTrajet" hidden>
        <h2>REJOIDNRE LE TRAJET</h2>
        <p>Êtes vous sur de vouloir supprimer votre trajet ?</p>
        <form action="rejoindreCovoit.php?covoitId=<?php echo $_GET['rejoindreCovoitId']?>" method="post">
            <input type="text" name="lieuRécup" placeholder="Lieu de prise en charge souhaité" required/>
            <input type="text" name="matos" placeholder="Matériel encombrant que je voudrais amener (ordinateur fixe ou autre)"/>
            <input type="text" name="nomDiscord" placeholder="Pseudo Discord pour que le conducteur vous contacte en cas de besoin (optionnel)" />
            <input type="submit" value="Rejoindre le trajet"/>
        </form>
    </div>
    <?php
        if(isset($_GET['retirerCovoitId'])){
            echo '<script>blocAlertRetirer = document.getElementById("alertRetirerTrajet"); blocAlertRetirer.style.display = "block";</script>';
        }
        if(isset($_GET['supprimerCovoitId'])){
            echo '<script>blocAlertSupprimer = document.getElementById("alertSupprimerTrajet"); blocAlertSupprimer.style.display = "block";</script>';
        }
        if(isset($_GET['rejoindreCovoitId'])){
            echo '<script>blocAlertRejoindre = document.getElementById("alertRejoindreTrajet"); blocAlertRejoindre.style.display = "block";</script>';
        }
    ?>
  </body>
  <?php include('footer.php'); ?>
</html>
