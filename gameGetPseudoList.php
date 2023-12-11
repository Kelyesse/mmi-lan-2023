<?php
header('Content-Type: application/json');

require_once('./connexionbdd.php');

$sql = "SELECT PlayerPseudo FROM player";
$stmt = $db->query($sql);
$pseudos = $stmt->fetchAll(PDO::FETCH_COLUMN);

$jsonPseudos = json_encode($pseudos);

echo $jsonPseudos;
