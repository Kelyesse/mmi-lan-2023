<?php
require_once("connexionbdd.php"); 

function getTeamsData($db) {
    try {
        $db->beginTransaction();

        $stmt1 = $db->prepare("SET @row_number = 0;");
        $stmt1->execute();
        $stmt1->closeCursor();

        $stmt2 = $db->prepare("SELECT (@row_number:=@row_number + 1) AS num, TeamName, TeamLogo FROM team LIMIT 11");
        $stmt2->execute();

        $no = 0;

        while ($donnees = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            $no++;
            $image = $donnees['TeamLogo'];
            
            echo '<img id="img-logo-'.$no.'" src="assets/img/'.$image.'" alt="' . $donnees['TeamName'] . '" />';
        }

        $stmt2->closeCursor();
        
        $db->commit();
    } catch (PDOException $e) {
        $db->rollBack();
        echo "Error: " . $e->getMessage();
    }
}

$db = Connexion();
getTeamsData($db);
?>
