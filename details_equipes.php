<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="./assets/img/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="./assets/style/details_equipes.css">
  <link rel="stylesheet" href="./assets/style/footer.css">
  <link rel="stylesheet" href="./assets/style/header.css">
  <title>Détails équipe -
    <?php
    session_start();
    require_once("MLB-8_functions.php");
    require_once("connexionbdd.php");
    $teamId = $_GET['teamId'];
    echo getTeamName($teamId, $db);
    ?> - MMI LAN
  </title>
</head>

<body>
  <header>
    <?php include('navbar.php'); ?>
  </header>

  <main>
    <div id="equipe">
      <h1>
        <?php echo getTeamName($teamId, $db); ?>
      </h1>
      <div class="photo_equipe">
        <img src="./assets/img/icon1.svg" alt="Icon" class="illu_1">
        <img src="./assets/img/<?php echo getTeamLogo($teamId, $db); ?>" alt="Logo equipe" /> <!-- A MODIFIER -->
        <img src="./assets/img/icon2.svg" alt="Icon" class="illu_2">
      </div>
      <p>
        <?php echo getTeamDesc($teamId, $db); ?>
      </p>
    </div>

    <div id="membres">
      <?php echo getTeamMembers($teamId, $db); ?>
    </div>
    
    <div id="photo">
      <?php
        for($i=1; $i<5; $i++){
            echo '<img class="img'.$i.'" src="./assets/img/photos_equipes/'.$teamId.'_'.$i.'.jpeg" alt="images prise de l’équipe" />';
        }
      ?>
    </div>

    <div id="retour">
      <?php echo showReturnButtons($teamId, $db); ?>
    </div>
  </main>
  <div id="alertRejoindreEquipe" hidden>
    <h2>Vous allez rejoindre l'équipe
      <?php echo getTeamName($teamId, $db); ?>
    </h2>
    <form action="rejoindreEquipe.php?teamId=<?php echo $teamId ?>" method="post">
      <textarea name="playerDesc" id="" cols="30" rows="10" placeholder="Ecrire une description de vous"
        required></textarea>
      <div>
        <input type="button" onclick='window.location.href="details_equipes.php?teamId=<?php echo $teamId ?>"'
          value="J'ai changé d'avis">
        <input type="submit" value="Rejoindre">
      </div>
    </form>
  </div>
  <?php showAlertForm(); ?>

  <?php include('footer.php'); ?>
</body>

</html>