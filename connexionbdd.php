<?php 
function Connexion(){
    $hostname = 'localhost';  
    $username = 'root'; 
    $password = 'root';
    $db = 'mmi-lan';
    $dsn = "mysql:host=$hostname;dbname=$db;charset=utf8mb4";

    try {
        $db = new PDO($dsn, $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $db;
    }
    catch(PDOException $e){
        echo "Erreur de connexion : </br>";
        echo $e->getMessage();
    }
}
$db = Connexion();
?>