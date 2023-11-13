<?php
include("connexion.php"); //A MODIFIER

$requete1 = "SET @row_number = 0;";
$stmt1 = $bdd->prepare($requete1);

$stmt1->execute();
$stmt1->close();

$requete2 = "SELECT (@row_number:=@row_number + 1) AS num, TeamName, TeamLogo FROM Team LIMIT 11";
$stmt2 = $bdd->prepare($requete2);

$stmt2->execute();
$result = $stmt2->get_result();
$no = 0;

while ($donnees = $result->fetch_assoc()) {
    $no++;
    $image = $donnees['TeamLogo'];
    
    echo '<img id="img-logo-'.$no.'" src="'.$image.'" alt="' . $donnees['TeamName'] . '" />';
}

$stmt2->close();
?>
