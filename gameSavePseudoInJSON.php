<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

session_start();

if (!isset($_SESSION['scoreId'])) {
    header('index.html');
    exit;
}

$data = $_POST['data'];

$scoreId = $_SESSION['scoreId'];

$jsonFilePath = 'assets/json/gameLeaderboard.json';
$content = json_decode(file_get_contents($jsonFilePath), true);

$updatedContent = [];

foreach ($content as $score) {
    if ($score['pseudo'] == $scoreId) {
        $score['pseudo'] = $data;
        $score['state'] = true;
    }
    $updatedContent[] = $score;
}

function bestByPseudo($array)
{
    $bestByPseudo = array();

    $pseudoArray = array();

    foreach ($array as $row) {
        $rowPseudo = $row["pseudo"];
        if (!in_array($rowPseudo, $pseudoArray)) {
            $pseudoArray[] = $rowPseudo;
        } else {
            $row["state"] = false;
        }
        $bestByPseudo[] = $row;
    }
    return $bestByPseudo;
}

$bestPseudo = bestByPseudo($updatedContent);

$contentJSON = json_encode($bestPseudo, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
file_put_contents($jsonFilePath, $contentJSON);

// Envoie du nouveau classement à la page
echo $contentJSON;
