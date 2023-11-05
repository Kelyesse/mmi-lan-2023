<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposer un covoiturage</title>
</head>
<body>
    <h1>Conducteur Covoiturage</h1>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut et massa mi. Aliquam in hendrerit urna. Pellentesque sit amet sapien fringilla, mattis ligula consectetur, ultrices mauris. Maecenas vitae mattis tellus. Nullam quis imperdiet augue. Vestibulum auctor ornare leo, non suscipit magna interdum eu. </p>
    <form action="propCovoit.php" method="post">
        <h2>Proposer un trajet</h2>
        <input type="number" name="nbPlaces" id="" min="1" max="6" placeholder="Nombre de places disponibles" required>
        <input type="text" name="lieuDépart" placeholder="Lieu de départ" required>
        <textarea name="infos" id="" cols="30" rows="10" placeholder="Laisser un message ou des informations sur la zone de prise en  charge" required></textarea>
        <p>En conduisant vos camarades à la LAN, vous vous engagez à veiller à le ramener ou à vous arranger qu’il soit ramené ! </p>
        <input type="submit" value="Partager mon trajet">
    </form>
    <div id="alertCovoit" hidden>
        <p>Votre trajet a été ajouté avec succès !</p>
        <button id="retourIndex" onclick='window.location.href="[fichier_test]index.php"'>Revenir à l'accueil</button>
        <button id="voirTrajets" onclick='window.location.href="afficheCovoits.php"'>Voir les trajets</button>
    </div>

    <?php
        if(isset($_POST['nbPlaces'])){
            try{
                session_start();
                require_once("[fichier_test]connexionbdd.php");
                //On ajoute d'abord le nouveau covoiturage dans la table "covoit"
                $req = $db->prepare("INSERT INTO covoit(CovoitDépart, CovoitPassengers, CovoitDesc) VALUE(:var1, :var2, :var3)");
                $req->bindParam('var1', $_POST['lieuDépart'], PDO::PARAM_STR);
                $req->bindParam('var2', $_POST['nbPlaces'], PDO::PARAM_INT);
                $req->bindParam('var3', $_POST['infos'], PDO::PARAM_STR);
                $req->execute();

                //On récupère ensuite l'Id du covoit nouvellement créé
                $req = $db->prepare("SELECT CovoitId FROM covoit WHERE CovoitDépart=? AND CovoitPassengers=? AND CovoitDesc=?");
                $req->execute([$_POST['lieuDépart'], $_POST['nbPlaces'], $_POST['infos']]);
                $covoitId = $req->fetch()['CovoitId'];

                //On lie ensuite le conducteur avec son covoiturage dans la table "belongCovoit"
                $req = $db->prepare("INSERT INTO belongCovoit(PlayerId, CovoitId, BelongCovoitRole) VALUE(:var1, :var2, 'Conducteur')");
                $req->bindParam('var1', $_SESSION['playerId'], PDO::PARAM_INT);
                $req->bindParam('var2', $covoitId, PDO::PARAM_INT);
                $req->execute();

                echo '<script>blocAlert = document.getElementById("alertCovoit"); blocAlert.style.display = "block";</script>';
            }
            catch(Exception $e){
                echo 'Exception reçue : ',  $e->getMessage(), "\n";
            }
        }
    ?>
</body>
</html>