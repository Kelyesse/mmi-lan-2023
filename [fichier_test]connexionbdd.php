<?php
function Connexion()
{
    $hostname = 'localhost';
    $username = 'root';
    $password = 'root';
    $db = 'mmi_lan';
    // Data Source Name
    $dsn = "mysql:host=$hostname;dbname=$db";
    try {
        $bdd = new PDO($dsn, $username, $password);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $bdd;
    } catch (PDOException $e) {
        echo "Erreur de connection ! </br>";
        echo $e->getMessage();
    }
}
$db = connexion();
