<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

session_start();

// Traitement du pseudo + état du score
if (isset($_SESSION['PlayerId'])) {
    require_once('./connexionbdd.php');
    $playerId = $_SESSION['PlayerId'];
    $sql = "SELECT PlayerPseudo FROM player WHERE PlayerId = $playerId";
    $stmt = $db->query($sql);
    $pseudo = $stmt->fetch(PDO::FETCH_ASSOC)['PlayerPseudo'];
    $state = true;
} else {
    $pseudo = random_int(1, 1000000); // Pseudo temporaire servant d'id
    $_SESSION['scoreId'] = $pseudo;
    $state = false;
}



// Traitement du timer + mise en forme
$data = round($_POST['data'], 3);

$minutes = floor($data / 60);
$secondes = floor($data % 60);
$centieme = round((($data - floor($data)) * 100));

if ($secondes < 10) $secondes = "0" . $secondes;
elseif ($secondes < 1) $secondes = "00";

if ($centieme < 10) $centieme = "0" . $centieme;
elseif ($centieme < 1) $centieme = "00";


// Récupération du classement
$jsonFilePath = 'assets/json/gameLeaderboard.json';
$content = json_decode(file_get_contents($jsonFilePath), true);

// Insertion du nouveau temps
$newdata = array(
    "pseudo" => $pseudo,
    "time" => array(
        "m" => $minutes,
        "s" => $secondes,
        "ms" => $centieme
    ),
    "state" => $state
);

$content[] = $newdata;

function sortContent($a, $b)
{
    if ($a["time"]["m"] == $b["time"]["m"]) {
        if ($a["time"]["s"] == $b["time"]["s"]) {
            return $a["time"]["ms"] - $b["time"]["ms"];
        } else {
            return $a["time"]["s"] - $b["time"]["s"];
        }
    } else {
        return $a["time"]["m"] - $b["time"]["m"];
    }
}

usort($content, "sortContent");

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

$bestPseudo = bestByPseudo($content);

$contentJSON = json_encode($bestPseudo, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
file_put_contents($jsonFilePath, $contentJSON);

// Envoie du nouveau classement à la page
$arrayJSON = json_encode(array("json" => $content, "state" => $state));
echo $arrayJSON;
