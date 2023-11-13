<?php
function getTeamName($teamId, $db)
{
    $teamName = $db->prepare("SELECT TeamName FROM team WHERE TeamId=?");
    $teamName->execute([$teamId]);
    $nomequipe = $teamName->fetch()['TeamName'];
    return $nomequipe;
}

function getTeamLogo($teamId, $db)
{
    $equipe = $db->prepare("SELECT TeamLogo FROM team WHERE TeamId=?");
    $equipe->execute([$teamId]);
    $logoequipe = $equipe->fetch()['TeamLogo'];
    return $logoequipe;
}

function getTeamDesc($teamId, $db)
{
    $equipe = $db->prepare("SELECT TeamDesc FROM team WHERE TeamId=?");
    $equipe->execute([$teamId]);
    $descequipe = $equipe->fetch()['TeamDesc'];
    return $descequipe;
}

function getTeamMembers($teamId, $db)
{
    $membres = $db->prepare("SELECT PlayerId FROM belongteam WHERE TeamId=? AND BelongStatus=?");
    $membres->execute([$teamId, "validé"]);
    $nbMembres = 0;
    while ($donnees = $membres->fetch()) {
        echo '<div class="membre">';
        $membre = $db->prepare("SELECT PlayerLastname, PlayerFirstname, PlayerPseudo, PlayerPicture, PlayerFavGame FROM player WHERE PlayerId=?");
        $membre->execute([$donnees['PlayerId']]);
        $membre = $membre->fetch();
        $nommembre = $membre[0];
        $prénommembre = $membre[1];
        $pseudomembre = $membre[2];
        $imagemembre = $membre[3];
        $jeufavmembre = $membre[4];
        echo '<img src="./assets/img/' . $imagemembre . '"/>';
        echo '<h2>' . $pseudomembre . '</h2>';
        echo '<p class="jeu">' . $jeufavmembre . '</p>';
        echo '<p class="texte_presentation">' . $prénommembre . " " . $nommembre . " alias " . $pseudomembre . '</p>';
        echo '</div>';
        $nbMembres++;
    }

    //--- Partie où on affiche des cases vides en cas d'équipe incomplète ---
    while ($nbMembres < 3) {
        echo '<div class="equipe_incomplete">';
        echo '<h2>Cette équipe est incomplète</h2>';
        $req = $db->prepare("SELECT PlayerId FROM belongteam");
        $req->execute();
        $equipierId = $req->fetchAll();
        $dansequipe = false;
        foreach ($equipierId as $equipier) {
            if (in_array($_SESSION['playerId'], $equipier)) {
                $dansequipe = true;
                break;
            }
        }
        if (!$dansequipe) {
            $message = "Rejoindre l'équipe";
            echo '<a class="rejoindre" href="details_equipes.php?teamId=' . $teamId . '&rejoindreEquipe=' . true . '">' . $message . '</a>';
        }
        echo '</div>';
        $nbMembres++;
    }
}

function showReturnButtons($teamId, $db)
{
    $nbEquipe = $db->prepare("SELECT MAX(TeamId) FROM team");
    $nbEquipe->execute();
    $nbEquipe = $nbEquipe->fetch()[0];
    if ($teamId > 1) {
        echo '<a href="details_equipes.php?teamId=' . ($teamId - 1) . '"><img src="./assets/img/fleche_gauche.svg" alt="flèche gauche"></a>';
    } else {
        echo '<a href="details_equipes.php?teamId=' . $nbEquipe . '"><img src="./assets/img/fleche_gauche.svg" alt="flèche gauche"></a>';
    }
    echo ' <a class="retour" href="[fichier_test]equipes.php">Retour au listing des équipes</a> '; //A MODIFIER
    if ($teamId < $nbEquipe) {
        echo '<a href="details_equipes.php?teamId=' . ($teamId + 1) . '"><img src="./assets/img/fleche_droite.svg" alt="flèche gauche"></a>';
    } else {
        echo '<a href="details_equipes.php?teamId=1"><img src="./assets/img/fleche_droite.svg" alt="flèche gauche"></a>';
    }
}

function showAlertForm()
{
    if (isset($_GET['rejoindreEquipe'])) {
        echo '<script>blocAlert = document.getElementById("alertRejoindreEquipe"); blocAlert.style.display = "block";</script>';
    }
}
