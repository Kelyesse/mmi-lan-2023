<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des trajets</title>
</head>
<body>
    <h1>Passager Covoiturage</h1>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut et massa mi. Aliquam in hendrerit urna. Pellentesque sit amet sapien fringilla, mattis ligula consectetur, ultrices mauris. Maecenas vitae mattis tellus. Nullam quis imperdiet augue. Vestibulum auctor ornare leo, non suscipit magna interdum eu. </p>
    <div id="listeCovoits">
        <?php
            session_start();
            require_once("[fichier_test]connexionbdd.php");
            $req = $db->prepare("SELECT * FROM covoit");
            $req->execute();
            echo '<div class="trajets">';
            while($donnees = $req->fetch()){
                //On récupère d'abord les informations du covoiturage (Lieu départ, nb de place, description)
                $idCovoit = $donnees['CovoitId'];
                $lieuDépart = $donnees['CovoitDépart'];
                $desc = $donnees['CovoitDesc'];
                $nbPlaces = $donnees['CovoitPassengers'];

                //On récupère ensuite le nom et prénom du conducteur du covoit
                $req2 = $db->prepare("SELECT PlayerId FROM belongcovoit WHERE CovoitId=? AND belongcovoitRole=?");
                $req2->execute([$idCovoit, "Conducteur"]);
                $conducteurId = $req2->fetch()['PlayerId'];
                $req2 = $db->prepare("SELECT PlayerLastName, PlayerFirstName FROM player WHERE PlayerId=?");
                $req2->execute([$conducteurId]);
                $nomConducteur = $req2->fetch();

                //On affiche les premières informations du covoit
                echo '<h2>'.$nomConducteur['PlayerFirstName'].' '.$nomConducteur['PlayerLastName'].'</h2>';
                echo '<h2>'.$lieuDépart.'</h2>';

                //On compte le nombre de places restantes en fonction du nombre de place initial et du nombre de passagers
                $req2 = $db->prepare("SELECT COUNT(PlayerId) FROM belongcovoit WHERE CovoitId=? AND belongcovoitRole=?");
                $req2->execute([$idCovoit, "Passager"]);
                $nbPassagers = $req2->fetch()[0];
                echo '<h4>'.$nbPlaces-$nbPassagers.' places disponibles</h4>';
                echo '<p>'.$desc.'</p>';

                //On récupère ensuite les id des passagers
                $req2 = $db->prepare("SELECT PlayerId FROM belongcovoit WHERE CovoitId=? AND belongCovoitRole=?");
                $req2->execute([$idCovoit, "Passager"]);
                $passagersId = $req2->fetchAll();
                $estPassager = false;
                foreach ($passagersId as $player) {
                    if (in_array($_SESSION['playerId'], $player)) {
                        $estPassager = true;
                        break;
                    }
                }

                //On vérifie ensuite si l'utilisateur est déjà dans un covoiturage
                $req2 = $db->prepare("SELECT PlayerId FROM belongcovoit");
                $req2->execute();
                $dansUnTrajet = $req2->fetchAll();
                $estDansVoiture = false;
                foreach ($dansUnTrajet as $voiture) {
                    if (in_array($_SESSION['playerId'], $voiture)) {
                        $estDansVoiture = true;
                        break;
                    }
                }

                //On affiche ensuite un bouton ou un message indiquant l'état du covoiturage ou l'action que l'utilisateur peut faire dessus
                if($conducteurId == $_SESSION['playerId']){
                    $onclick='window.location.href="afficheCovoits.php?supprimerCovoitId='.$idCovoit.'"';
                    echo '<button id="supprTrajet" onclick='.$onclick.'>Supprimer mon trajet</button>';
                }
                else if($estPassager){
                    $onclick='window.location.href="afficheCovoits.php?retirerCovoitId='.$idCovoit.'"';
                    echo '<button id="retirerTrajet" onclick='.$onclick.'>Me retirer du trajet</button>';
                }
                else if($estDansVoiture){
                    echo '<div id="autreTrajet">Vous êtes déjà sur un autre trajet</div>';
                }
                else if($nbPlaces-$nbPassagers==0){
                    echo '<div id="trajetComplet">Trajet Complet</div>';
                }
                else{
                    echo '<button id="joindreTrajet">Me joindre au trajet</button>';
                }
            }
            echo '</div>';  
        ?>
    </div>
    <div id="alertRetirerTrajet" hidden>
        <p>Êtes vous sur de vouloir vous retirer du trajet ?</p>
        <?php 
            $onclickValiderRetirer = 'window.location.href="retirerPassager.php?retirerCovoitId='.$_GET['retirerCovoitId'].'"';
            echo '<button id="validerRetirer" onclick='.$onclickValiderRetirer.'>Oui, me retirer de ce trajet</button>';
            $onclickAnnulerRetirer = 'window.location.href="afficheCovoits.php"';
            echo '<button id="annulerRetirer" onclick='.$onclickAnnulerRetirer.'>Non, j’ai changé d’avis</button>';
        ?>
    </div>
    <div id="alertSupprimerTrajet" hidden>
        <p>Êtes vous sur de vouloir supprimer votre trajet ?</p>
        <?php
            $onclickValiderSupprimer = 'window.location.href="supprimerTrajet.php?supprimerCovoitId='.$_GET['supprimerCovoitId'].'"';
            echo '<button id="validerSupprimer" onclick='.$onclickValiderSupprimer.'>Oui, supprimer mon trajet</button>';
            $onclickAnnulerSupprimer = 'window.location.href="afficheCovoits.php"';
            echo '<button id="annulerSupprimer" onclick='.$onclickAnnulerSupprimer.'>Non, j’ai changé d’avis</button>';
        ?>
    </div>

    <?php
        if(isset($_GET['retirerCovoitId'])){
            echo '<script>blocAlertRetirer = document.getElementById("alertRetirerTrajet"); blocAlertRetirer.style.display = "block";</script>';
        }
        if(isset($_GET['supprimerCovoitId'])){
            echo '<script>blocAlertSupprimer = document.getElementById("alertSupprimerTrajet"); blocAlertSupprimer.style.display = "block";</script>';
        }
    ?>
</body>
</html>