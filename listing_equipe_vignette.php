<?php

function getEquipes($db) {
    $equipes = array();
    
    if (isset($_GET['order']) && $_GET['order'] == 'desc') {
        $prep = "SELECT TeamId, TeamName, TeamLogo FROM team ORDER BY TeamName DESC";
    } 
    elseif(isset($_GET['order']) && $_GET['order'] == 'ancien'){
        $prep = "SELECT TeamId, TeamName, TeamLogo FROM team ORDER BY TeamId ASC";
    }
    elseif(isset($_GET['order']) && $_GET['order'] == 'recent'){
        $prep = "SELECT TeamId, TeamName, TeamLogo FROM team ORDER BY TeamId DESC";
    }
    else {
        $prep = "SELECT TeamId, TeamName, TeamLogo FROM team ORDER BY TeamName ASC";
    }
    
    $stmt2 = $db->prepare($prep);
    $stmt2->execute();
    $equipes = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    $stmt2->closeCursor();
    
    return $equipes;
}

function getJoueursByEquipe($db, $equipeId) {
    $joueurs = array();
    
    $sqlp = "SELECT p.PlayerPseudo
        FROM player p
        INNER JOIN belongteam b ON p.PlayerId = b.PlayerId
        WHERE b.TeamId = ? AND b.BelongStatus <> 'en attente'";

    $stmt = $db->prepare($sqlp);
    $stmt->execute([$equipeId]);
    $joueurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    
    return $joueurs;
}



if (!isset($equipes)) {
    require_once('connexionbdd.php');
    $equipes = getEquipes($db);
}

if (count($equipes) > 0) {
    foreach ($equipes as $equipe) {
        $nbr = 0;
        $joueurs = getJoueursByEquipe($db, $equipe['TeamId']);

        foreach ($joueurs as $pseudo) {
            $nbr++;
        }

        if ($nbr == 3) {
            $image = $equipe['TeamLogo'];
            echo '<li class="vignette_pleine" id="' . $equipe['TeamId'] . '"> <a class="NomTeam" href="details_equipes.php?teamId=' . $equipe['TeamId'] . '">';
            echo '<img src="assets/img/' . $image . '" alt="Logo de l\'équipe" />';
            echo $equipe['TeamName'];
            echo '<p>-</p>';

            foreach ($joueurs as $pseudo) {
                echo '<div class="Joueur">' . $pseudo['PlayerPseudo'] . '</div>';
            }

            echo '<button class="button_full">Equipe complète</button></a></li>';
        } else {
            $image = $equipe['TeamLogo'];
            echo '<li class="vignette" id="' . $equipe['TeamId'] . '"> <a class="NomTeam" href="details_equipes.php?teamId=' . $equipe['TeamId'] . '">';
            echo '<img src="assets/img/' . $image . '" alt="Logo de l\'équipe" />';
            echo $equipe['TeamName'] ;
            echo '<p>-</p>';


            foreach ($joueurs as $pseudo) {
                echo '<div class="Joueur">' . $pseudo['PlayerPseudo'] . '</div></a>';
            }
            if (!isset($_SESSION['PlayerId'])) {
                echo '<button class="button_full" onclick=\'window.location.href="listing_equipe.php?teamId='.$equipe['TeamId'].'&rejoindreEquipe=true&teamName='.$equipe['TeamName'].'"\'>Rejoindre l\'équipe</button></li>';
            }

        }
    }
}
else{
    echo'<div class="liste_vide">Il n\'y a pas encore d\'équipe ! </div>';
}
?>
