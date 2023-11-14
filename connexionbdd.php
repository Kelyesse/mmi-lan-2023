<?php 
    function Connexion(){
        $hostname = 'localhost';  
        $username = 'root'; 
        $password = 'root';
        $db = 'mmi-lan';
        // Data Source Name
        $dsn = "mysql:host=$hostname;dbname=$db";
        try {
            $db = new PDO($dsn, $username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return $db;
        }
        catch(PDOException $e){
            echo "Erreur de connection ! </br>";
            echo $e->getMessage();
        }
    }
    $db = connexion();
?>