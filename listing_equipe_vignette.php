<?php 

function getEquipes() {
    $equipes = array();
    include("connexion.php"); //A MODIFIER
    if (isset($_GET['order']) && $_GET['order'] == 'desc') {
        $prep = "SELECT TeamId, TeamName, TeamLogo FROM Team ORDER BY TeamName DESC";
    } 
    elseif(isset($_GET['order']) && $_GET['order'] == 'ancien'){
        $prep = "SELECT TeamId, TeamName, TeamLogo FROM Team ORDER BY TeamId ASC";
    }
    elseif(isset($_GET['order']) && $_GET['order'] == 'recent'){
        $prep = "SELECT TeamId, TeamName, TeamLogo FROM Team ORDER BY TeamId DESC";
    }
    else {
        $prep = "SELECT TeamId, TeamName, TeamLogo FROM Team ORDER BY TeamName ASC";
    }
    
    $stmt2 = $bdd->prepare($prep);
    $stmt2->execute();
    $resultat = $stmt2->get_result();
    while ($ligne = $resultat->fetch_assoc()) {
        $equipes[] = $ligne;
    }
    $stmt2->close();
    return $equipes;
}

function getJoueursByEquipe($equipeId) {
    $joueurs = array();
    include("connexion.php"); //A MODIFIER
    $sqlp = "SELECT p.PlayerPseudo
        FROM Player p
        INNER JOIN BelongTeam b ON p.PlayerId = b.PlayerId
        WHERE b.TeamId = ?";

    $stmt = $bdd->prepare($sqlp);
    $stmt->bind_param("i", $equipeId); 
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $joueurs[] = $row;
    }

    $stmt->close();
    return $joueurs;
}

if (!isset($equipes)) {
    $equipes = getEquipes();
}

if (count($equipes) > 0) {
    foreach ($equipes as $equipe) {
        $nbr = 0;
        $joueurs = getJoueursByEquipe($equipe['TeamId']);

        foreach ($joueurs as $pseudo) {
            $nbr++;
        }

        if ($nbr == 3) {
            $image = $equipe['TeamLogo'];
            echo '<li class="vignette_pleine" id="' . $equipe['TeamId'] . '"> <a class="NomTeam" href="details_equipes.php?teamId=' . $equipe['TeamId'] . '">';
            echo '<img src="' . $image . '" alt="Logo de l\'équipe" />';
            echo $equipe['TeamName'];
            echo '<p>-</p>';

            foreach ($joueurs as $pseudo) {
                echo '<div class="Joueur">' . $pseudo['PlayerPseudo'] . '</div>';
            }

            echo '<button class="button_full">Equipe complète</button></a></li>';
        } else {
            $image = $equipe['TeamLogo'];
            echo '<li class="vignette" id="' . $equipe['TeamId'] . '"> <a class="NomTeam" href="details_equipes.php?teamId=' . $equipe['TeamId'] . '">';
            echo '<img src="' . $image . '" alt="Logo de l\'équipe" />';
            echo $equipe['TeamName'] ;
            echo '<p>-</p>';


            foreach ($joueurs as $pseudo) {
                echo '<div class="Joueur">' . $pseudo['PlayerPseudo'] . '</div></a>';
            }

            echo '<button class="button_full" onclick=\'window.location.href="listing_equipe.php?teamId='.$equipe['TeamId'].'&rejoindreEquipe=true&teamName='.$equipe['TeamName'].'"\'>Rejoindre l\'équipe</button></li>';
        }
    }
}
?>
