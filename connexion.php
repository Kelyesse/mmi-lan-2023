<?php
$serveur = "localhost"; 
$utilisateur = "root"; 
$mot_de_passe = "root"; 
$base_de_donnees = "mydb"; 

$bdd = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

if ($bdd->connect_error) {
    die("La connexion à la base de données a échoué : " . $bdd->connect_error);
}

?>
