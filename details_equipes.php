<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
<<<<<<< HEAD
  <link rel="stylesheet" href="./assets/style/details_equipes.css">
  <title>Details équipe
    <?php
    session_start();
    require_once("MLB-8_functions.php"); //A MODIFIER
    require_once("[fichier_test]connexionbdd.php"); //A MODIFIER
    $teamId = $_GET['teamId'];
    echo getTeamName($teamId, $db);
    ?>
  </title>

  <!-- <script src="./assets/js/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      $(".rejoindre").click(function() {
        $("body").css("opacity", "0.50");
      });
    });
  </script> -->
=======
  <link rel="stylesheet" href="details_equipes.css">
  <title>Details équipe 
    <?php
      session_start();
      require_once("MLB-8_functions.php"); //A MODIFIER
      require_once("[fichier_test]connexionbdd.php"); //A MODIFIER
      $teamId = $_GET['teamId'];
      echo getTeamName($teamId, $db);
    ?>
  </title>
>>>>>>> e6353573c3af57e068983feca26d792f84c59bf1
</head>

<body>
  <header></header>

  <main>
    <div id="equipe">
<<<<<<< HEAD
      <h1><?php echo getTeamName($teamId, $db); ?></h1>
      <div class="photo_equipe">
        <img class="illu_1" src="./assets/img/icon1.svg" alt="Illustration">
        <img src="./assets/img/<?php echo getTeamLogo($teamId, $db); ?>" alt="Logo equipe" /> <!-- A MODIFIER -->
        <img class="illu_2" src="./assets/img/icon2.svg" alt="Illustration">
      </div>
      <p><?php echo getTeamDesc($teamId, $db); ?></p>
    </div>

    <div id="membres">
      <?php echo getTeamMembers($teamId, $db); ?>
=======
      <h1><?php echo getTeamName($teamId, $db);?></h1>
      <div class="photo_equipe">
        <img src="images/icon1.svg" alt="Icon" class="illu_1">
        <img src="images/<?php echo getTeamLogo($teamId, $db);?>" alt="Logo equipe"/> <!-- A MODIFIER -->
        <img src="images/icon2.svg" alt="Icon" class="illu_2">
      </div>
      <p><?php echo getTeamDesc($teamId, $db);?></p>
    </div>

    <div id="membres">
      <?php echo getTeamMembers($teamId, $db);?>
>>>>>>> e6353573c3af57e068983feca26d792f84c59bf1
    </div>

    <!--A COMPLETER UNE FOIS LE SHOOTING FAIT ! -->
    <div id="photo" hidden></div>

    <div id="retour">
<<<<<<< HEAD
      <?php echo showReturnButtons($teamId, $db); ?>
    </div>
  </main>
  <div id="alertRejoindreEquipe" hidden>
    <h2>Vous allez rejoindre l'équipe <?php echo getTeamName($teamId, $db); ?></h2>
    <form action="rejoindreEquipe.php" method="post">
      <textarea name="playerDesc" id="" cols="30" rows="10" placeholder="Ecrire une description de vous"></textarea>
      <div>
        <input type="button" onclick='window.location.href="details_equipes.php?teamId=<?php echo $teamId ?>"' value="J'ai changé d'avis">
        <input type="submit" value="Rejoindre">
      </div>

    </form>
=======
      <?php echo showReturnButtons($teamId, $db);?>
    </div>
  </main>
  <div id="alertRejoindreEquipe" hidden>
      <h2>Vous allez rejoindre l'équipe <?php  echo getTeamName($teamId, $db); ?></h2>
      <form action="rejoindreEquipe.php?teamId=<?php echo $teamId?>" method="post">
          <textarea name="playerDesc" id="" cols="30" rows="10" placeholder="Ecrire une description de vous"></textarea>
          <input type="submit" value="Rejoindre">
          <input type="button" onclick='window.location.href="details_equipes.php?teamId=<?php echo $teamId?>"' value="J'ai changé d'avis">
      </form>
>>>>>>> e6353573c3af57e068983feca26d792f84c59bf1
  </div>
  <?php showAlertForm(); ?>
  <footer></footer>
</body>

</html>