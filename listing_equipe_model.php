<?php 
   
class Team {
    public function getEquipes() {
        $equipes= array();
        require_once("connexion.php");
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
    }
        
class Joueur {
    public function getJoueursByEquipe($equipeId) {
        $joueurs = array();
        require_once("connexion.php");
                    
        $sql = "SELECT p.PlayerPseudo
        FROM Player p
        INNER JOIN Belong b ON p.PlayerId = b.PlayerId
        WHERE b.TeamId = ?";
                            
        $stmt = $bdd->prepare($sql);
        $stmt->bind_param("i", $equipeId); 
        $stmt->execute();
        $result = $stmt->get_result();
            
        while ($row = $result->fetch_assoc()) {
            $joueurs[] = $row;
            }
                    
        $stmt->close();
        return $joueurs;
        }
    }
?>