<?php 
include ("connexion.php");

$requete = "SELECT TeamId, TeamLogo FROM Team WHERE TeamId <= 10";
$stmt3 = $bdd->prepare($requete);  
$stmt3->execute();
$result = $stmt3->get_result();

while ($donnees = $result->fetch_assoc())
{
    $image = $donnees['TeamLogo'];
    $base64Image = base64_encode($image);

    echo '<img id="img-logo-' . $donnees['TeamId'] . '" src="data:image;base64,' . $base64Image . '" alt="Logo de l\'équipe" />';
}

$stmt3->close();
?>
