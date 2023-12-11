<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Covoiturage</title>
  <link rel="stylesheet" href="./assets/style/Covoiturage_conducteur.css" />
  <link rel="stylesheet" href="./assets/style/Covoiturage.css" />
  <link rel="icon" href="./assets/img/favicon.png" type="image/x-icon" />
</head>
<header>
  <?php include('navbar.php'); ?>
</header>

<body>
  <div id="main">
    <div class="titre">
      <h1>CONDUCTEUR COVOITURAGE</h1>
    </div>
    <form action="" method="POST">
      <h1>Proposer un trajet</h1>
      <div class="formulaire">
        <input type="number" name="nbPlaces" placeholder="Nombre de places disponible" required />
        <input type="text" name="lieuDépart" placeholder="Lieu de départ" required />
        <textarea name="infos" placeholder="Laisser un message ou des informations sur la zone de prise en charge"
          required></textarea>
        <p><i>En conduisant vos camarades à la LAN, vous vous engagez à veiller à le ramener ou à vous arranger qu’il
            soit ramené !</i></p>
        <?php
        session_start();
        require_once("connexionbdd.php");
        $req = $db->prepare("SELECT PlayerId FROM belongcovoit");
        $req->execute();
        $passagerId = $req->fetchAll();
        $dansvoiture = false;
        foreach ($passagerId as $passager) {
          if (in_array($_SESSION['PlayerId'], $passager)) {
            $dansvoiture = true;
            break;
          }
        }
        if ($dansvoiture) {
          echo '<div>';
          echo '<input type="submit" value="Partager mon trajet" disabled/>';
          echo '</div>';
          echo '<span><i style="color: red">Vous êtes déjà dans une voiture (Conducteur ou Passager), vous ne pouvez pas proposer de trajet sans quitter le trajet dans lequel vous êtes actuellement !</i></span>';
        } else {
          echo '<div>';
          echo '<input type="submit" value="Partager mon trajet" />';
          echo '</div>';
        }
        ?>
      </div>
    </form>
  </div>
  <?php
  if (isset($_POST['nbPlaces'])) {
    try {
      //On ajoute d'abord le nouveau covoiturage dans la table "covoit"
      $req = $db->prepare("INSERT INTO covoit(CovoitDépart, CovoitPassengers, CovoitDesc) VALUE(:var1, :var2, :var3)");
      $req->bindParam('var1', $_POST['lieuDépart'], PDO::PARAM_STR);
      $req->bindParam('var2', $_POST['nbPlaces'], PDO::PARAM_INT);
      $req->bindParam('var3', $_POST['infos'], PDO::PARAM_STR);
      $req->execute();

      //On récupère ensuite l'Id du covoit nouvellement créé
      $req = $db->prepare("SELECT MAX(CovoitId) FROM covoit");
      $req->execute();
      $covoitId = $req->fetch()[0];
      echo '<script>console.log(' . $covoitId . ', ' . $_SESSION['PlayerId'] . ');</script>';

      //On lie ensuite le conducteur avec son covoiturage dans la table "belongCovoit"
      $req = $db->prepare("INSERT INTO belongcovoit(PlayerId, CovoitId, BelongCovoitRole, BelongCovoitStatus) VALUE(:var1, :var2, 'Conducteur', 'validé')");
      $req->bindParam('var1', $_SESSION['PlayerId'], PDO::PARAM_INT);
      $req->bindParam('var2', $covoitId, PDO::PARAM_INT);
      $req->execute();
    } catch (Exception $e) {
      echo 'Exception reçue : ', $e->getMessage(), "\n";
    }
  }
  ?>
  <div id="alertCovoit" hidden>
    <div>
      <h3>Votre trajet a été ajouté avec succès !</h3>
      <div>
        <button id="retourIndex" onclick='window.location.href="index.php"'>Revenir à l'accueil</button>
        <button id="voirTrajets" onclick='window.location.href="covoiturage_passager.php"'>Voir les trajets</button>
      </div>
    </div>
  </div>
  <?php
  if (isset($_POST['nbPlaces'])) {
    echo '<script>blocAlert = document.getElementById("alertCovoit"); blocAlert.style.display = "block";</script>';
  }
  ?>
</body>
<?php include('footer.php'); ?>

</html>