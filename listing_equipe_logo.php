<?php 
include ("connexion.php");

$requete = "SELECT TeamId, TeamLogo FROM Team WHERE TeamId <= 11";
$stmt3 = $bdd->prepare($requete);  
$stmt3->execute();
$result = $stmt3->get_result();

while ($donnees = $result->fetch_assoc())
{
    $image = $donnees['TeamLogo'];

    echo '<img id="img-logo-' . $donnees['TeamId'] . '" src="'.$image.'" alt="Logo de l\'équipe" />';
}

$stmt3->close();
?>