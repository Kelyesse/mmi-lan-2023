<?php 
   

function getEquipes() {
        $equipes= array();
        include("connexion.php");
        $prep =" SELECT TeamId, TeamName
                FROM Team";
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
        include("connexion.php");
        $sqlp = "SELECT p.PlayerPseudo
        FROM Player p
        INNER JOIN Belong b ON p.PlayerId = b.PlayerId
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
    if (!isset($equipes)){
        $equipes=getEquipes();
    }
    if (count($equipes)>0){
    $equipesAvecJoueurs= array();
    $joueurs='ee';
    foreach ($equipes as $equipe) {
        echo '<li class="vignette" id="'.$equipe['TeamId'].'"> <a class="NomTeam" href="#/'.$equipe['TeamId'].'">'.$equipe['TeamName'].'</a>';
        $joueurs=getJoueursByEquipe($equipe['TeamId']);
        $equipe['PlayerPseudo'] = $joueurs;
        $equipesAvecJoueurs[] = $equipe;

        foreach ($equipesAvecJoueurs as $joueur) {
            foreach ($joueur['PlayerPseudo'] as $pseudo) {
                echo '<div class="Joueur">' . $pseudo . '</div>';
            }
        }
        echo '</li>';
    }
    }
?>