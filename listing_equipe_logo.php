<?php
require_once("connexion.php"); 

function getTeamsData($bdd) {
    try {
        $bdd->beginTransaction();

        $stmt1 = $bdd->prepare("SET @row_number = 0;");
        $stmt1->execute();
        $stmt1->closeCursor();

        $stmt2 = $bdd->prepare("SELECT (@row_number:=@row_number + 1) AS num, TeamName, TeamLogo FROM team LIMIT 11");
        $stmt2->execute();

        $no = 0;

        while ($donnees = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            $no++;
            $image = $donnees['TeamLogo'];
            
            echo '<img id="img-logo-'.$no.'" src="'.$image.'" alt="' . $donnees['TeamName'] . '" />';
        }

        $stmt2->closeCursor();
        
        $bdd->commit();
    } catch (PDOException $e) {
        $bdd->rollBack();
        echo "Error: " . $e->getMessage();
    }
}

$bdd = Connexion();
getTeamsData($bdd);
?>
