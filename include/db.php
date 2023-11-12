<?php

$serveur = "localhost";
$usernamedb = "root";
$passworddb = "";
$dbname = "mmi-lan";


$db2 = new PDO("mysql:dbname=" . $dbname . ";host=" . $serveur, $usernamedb, $passworddb);
$db2->exec("set names utf8");