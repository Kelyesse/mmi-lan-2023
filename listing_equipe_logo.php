<?php 
include ("connexion.php");

$requette = "SELECT TeamId TeamLogo FROM `Team` WHERE `TeamId` <= 10";
$stmt3 = $bdd->prepare($requette);  
$stmt3->execute();
$donnees = $stmt3->get_result();
while ( $donnees = $stmt3->fetch() )
{

        $image = $donnees['TeamLogo'];

        $extension = image_type_to_mime_type(exif_imagetype($image));

        echo '<img id="img-logo-'.$donnees['TeamId'].'" src="data:' . $extension . ';base64,' . base64_encode($image) . '" alt="Logo de l\'équipe" />';

}
$stmt3->close();

?>