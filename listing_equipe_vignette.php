<?php

function getEquipes($db)
{
    $equipes = array();

    if (isset($_GET['order']) && $_GET['order'] == 'desc') {
        $prep = "SELECT TeamId, TeamName, TeamLogo FROM team ORDER BY TeamName DESC";
    } elseif (isset($_GET['order']) && $_GET['order'] == 'ancien') {
        $prep = "SELECT TeamId, TeamName, TeamLogo FROM team ORDER BY TeamId ASC";
    } elseif (isset($_GET['order']) && $_GET['order'] == 'recent') {
        $prep = "SELECT TeamId, TeamName, TeamLogo FROM team ORDER BY TeamId DESC";
    } else {
        $prep = "SELECT TeamId, TeamName, TeamLogo FROM team ORDER BY TeamName ASC";
    }

    $stmt2 = $db->prepare($prep);
    $stmt2->execute();
    $equipes = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    $stmt2->closeCursor();

    return $equipes;
}

function getJoueursByEquipe($db, $equipeId)
{
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
            echo '<li class="vignette team-full" id="' . $equipe['TeamId'] . '">';
            echo '<a class="team-link" href="details_equipes.php?teamId=' . $equipe['TeamId'] . '"></a>';

            echo '<img src="assets/img/' . $image . '" alt="Logo de l\'équipe" />';
            echo '<div class="team-infos">';

            echo '<div class="team-name">' . $equipe['TeamName'] . "</div>";
            echo '<span class="team-separator"></span>';
            echo '<div class="joueurs">';
            foreach ($joueurs as $pseudo) {
                echo '<div class="Joueur">' . $pseudo['PlayerPseudo'] . '</div>';
            }
            echo '</div>';
            echo '</div>';

            echo '<button class="button_full">Equipe complète</button></li>';
        } else {
            $image = $equipe['TeamLogo'];
            echo '<li class="vignette team-incomplete" id="' . $equipe['TeamId'] . '">';
            echo '<a class="team-link" href="details_equipes.php?teamId=' . $equipe['TeamId'] . '"></a>';

            echo '<img src="assets/img/' . $image . '" alt="Logo de l\'équipe" />';
            echo '<div class="team-infos">';

            echo '<div class="team-name">' . $equipe['TeamName'] . "</div>";
            echo '<span class="team-separator"></span>';
            echo '<div class="joueurs">';
            foreach ($joueurs as $pseudo) {
                echo '<div class="Joueur">' . $pseudo['PlayerPseudo'] . '</div>';
            }
            echo '</div>';
            echo '</div>';
            if (isset($_SESSION['PlayerId'])) {
                $idj = $_SESSION['PlayerId'];
                $valeur = $db->prepare("SELECT TeamId FROM belongteam WHERE PlayerId=? AND BelongStatus=?");
                $valeur->execute([$idj, "validé"]);
                $resultat = $valeur->fetch();
                $req3 = $db->prepare("SELECT PlayerStatus FROM player WHERE PlayerId=?");
                $req3->execute([$idj]);
                $userrole = $req3->fetch()['PlayerStatus'];

                
                $req= $db->prepare('SELECT PlayerStatus FROM player WHERE PlayerId=?');
                $req->execute([$_SESSION['PlayerId']]);
                $roleadmin = $req->fetch()['PlayerStatus'];
                
                if($roleadmin == 'Admin'){
                    $req= $db->prepare('SELECT TeamScore FROM team WHERE TeamId=?');
                    $req->execute([$equipe['TeamId']]);
                    $teamscore = $req->fetch()['TeamScore'];
                    echo '<form id="teamScore" action="listing_equipe.php" method="post">';
                    echo '<p>Score :</p>';
                    echo '<input type="number" name="Tid" value="'.$equipe['TeamId'].'" hidden>';
                    echo '<input type="number" name="Tscore" value="'.$teamscore.'">';
                    echo '<input type="submit" value="Modifier score">';
                    echo '</form>';
                }
                
                else if (empty($resultat && $userrole == "Participant")) {
                    echo '<button class="button_full" onclick=\'window.location.href="listing_equipe.php?teamId=' . $equipe['TeamId'] . '&rejoindreEquipe=true&teamName=' . $equipe['TeamName'] . '"\'>Rejoindre l\'équipe</button></li>';

                }
            } else {
                echo '</li>';
            }

        }
    }
} else {
    echo '<div class="liste_vide">Il n\'y a pas encore d\'équipe ! </div>';
}
?>