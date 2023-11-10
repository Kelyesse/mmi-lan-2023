<?php 


function getEquipes() {
    $equipes = array();
    include("connexion.php");
    $prep = "SELECT TeamId, TeamName, TeamLogo FROM Team";
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
        if (!isset($equipes)) {
            $equipes = getEquipes();
        }
        if (count($equipes) > 0) {
            $equipesAvecJoueurs = array();
            $joueurs = 'ee';
            foreach ($equipes as $equipe) {
                $nbr=0;
                $joueurs = getJoueursByEquipe($equipe['TeamId']);
                foreach ($joueurs as $pseudo) {
                    $nbr++;
                    } 
                
                if ($nbr==3){
                $image = $equipe['TeamLogo'];
                $base64Image = base64_encode($image);
                echo '<li class="vignette_pleine" id="' . $equipe['TeamId'] . '"> <a class="NomTeam" href="#/' . $equipe['TeamId'] . '">';
                echo '<img src="data:image;base64,' . $base64Image . '" alt="Logo de l\'équipe" />';
                echo $equipe['TeamName'] . '</a>';
                foreach ($joueurs as $pseudo) {
                    $nbr++; 
                    echo '<div class="Joueur">' . $pseudo['PlayerPseudo'] . '</div>';
                }
                echo '<button class="button_full">Equipe complète</button></li>';
                echo '</li>';
            }
            else{
                    $image = $equipe['TeamLogo'];
                    $base64Image = base64_encode($image);
                    echo '<li class="vignette" id="' . $equipe['TeamId'] . '"> <a class="NomTeam" href="#/' . $equipe['TeamId'] . '">';
                    echo '<img src="data:image;base64,' . $base64Image . '" alt="Logo de l\'équipe" />';
                    echo $equipe['TeamName'] . '</a>';
                    foreach ($joueurs as $pseudo) {
                        $nbr++; 
                        echo '<div class="Joueur">' . $pseudo['PlayerPseudo'] . '</div>';
                    }
                    
                    echo '<button class="button_join">Rejoindre l\'équipe</button></li>';
            }}
        }