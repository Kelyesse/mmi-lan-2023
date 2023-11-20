<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (isset($_SESSION['PlayerId'])) {
    header('Status: 301 Moved Permanently', false, 301);
    header('Location: ./mon_compte.php');
    exit(0);
}

$errorMessage = '';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $requiredFields = ['nom', 'prenom', 'pseudo', 'email', 'mdp1', 'mdp2', 'role', 'avatar'];
        $missingFields = array_diff($requiredFields, array_keys($_POST));
        if (!empty($missingFields)) {
            $errorMessage = 'Veuillez remplir tous les champs obligatoires.';
        } else {
            $pseudo = $_POST["pseudo"];
            $prenom = $_POST["prenom"];
            $nom = $_POST["nom"];
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $mdp1 = $_POST["mdp1"];
            $mdp2 = $_POST["mdp2"];
            $role = $_POST["role"];
            $avatar = $_POST["avatar"];

            // Validation de favjeu et setup quand on est participant
            if ($role == 'Participant' && isset($_POST["setup"]) && isset($_POST["favjeu"])) {
                $selectedSetup = $_POST["setup"];
                $favjeu = $_POST["favjeu"];

                if (empty($favjeu) || empty($selectedSetup)) {
                    $errorMessage = 'Veuillez remplir les champs setup et favjeu.';
                } else {
                    // Vérification du jeu favori
                    $jeuxCorrespondance = [
                        "Track Mania: Nation Forever",
                        "Geo Guesseur",
                        "fortnite",
                        "Overwatch",
                        "Brawlhalla",
                        "CS GO",
                        "Rocket League",
                    ];

                    if (!in_array($favjeu, $jeuxCorrespondance)) {
                        $errorMessage = 'Le jeu favori sélectionné n\'est pas valide.';
                    } elseif ($selectedSetup !== 'PC portable' && $selectedSetup !== 'PC fixe') {
                        $errorMessage = 'Le type de setup sélectionné n\'est pas valide.';
                    }
                }
            }

            // Validation des autres champs
            if (empty($_POST['avatar'])) {
                $errorMessage = 'Veuillez choisir un avatar.';
            }
            if (!preg_match('/^[a-zA-ZÀ-ÖØ-öø-ÿ]+$/', $pseudo) && !preg_match('/^[a-zA-ZÀ-ÖØ-öø-ÿ]+$/', $prenom) && !preg_match('/^[a-zA-ZÀ-ÖØ-öø-ÿ]+$/', $nom)) {
                $errorMessage = 'Le nom, prénom et pseudo doivent contenir uniquement des lettres minuscules et majuscules.';
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errorMessage = 'L\'adresse email n\'est pas valide.';
            }

            if ($mdp1 != $mdp2) {
                $errorMessage = 'Les mots de passes inscrit sont différents.';
            }
            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[\w\d\S]{8,}$/', $mdp1)) {
                $errorMessage = 'Les mots de passe ne respectent pas les critères.';
            }

            if (empty($errorMessage)) {
                require_once('./connexionbdd.php');

                //Vérifier que le compte ne se trouve pas déjà dans la base (seulement les champs pseudo et mail)
                $testmailStmt = $db->prepare('SELECT * FROM player WHERE PlayerEmail = :email');
                $testpseudoStmt = $db->prepare('SELECT * FROM player WHERE PlayerPseudo = :pseudo');

                $testmailStmt->bindParam(':email', $email, PDO::PARAM_STR);
                $testpseudoStmt->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);

                $testmailStmt->execute();
                $testpseudoStmt->execute();

                $testmail = $testmailStmt->fetch(PDO::FETCH_ASSOC);
                $testpseudo = $testpseudoStmt->fetch(PDO::FETCH_ASSOC);

                if ($testmail) {
                    $errorMessage = 'Un compte a déjà été créé avec cette adresse électronique.';
                } elseif ($testpseudo) {
                    $errorMessage = 'Ce pseudo est déjà pris.';
                } else {
                    if (empty($testpseudo)) {
                        // Génération d'un ID unique
                        $PlayerId = generateId($db->query('SELECT PlayerId FROM player')->fetchAll(PDO::FETCH_ASSOC));

                        // Insertion des données dans la base de données en fonction du rôle
                        $sql = "INSERT INTO player (PlayerId, PlayerLastName, PlayerFirstName, PlayerPseudo, PlayerEmail, PlayerPassword, PlayerStatus, PlayerSetup, PlayerFavGame, PlayerPicture) VALUES (:id, :nom, :prenom, :pseudo, :email, :mdp, :role, :setup, :favgame, :avatar)";
                        $stmt = $db->prepare($sql);

                        $stmt->bindParam(':id', $PlayerId, PDO::PARAM_INT);
                        $stmt->bindParam(':nom', $pseudo, PDO::PARAM_STR);
                        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
                        $stmt->bindParam(':pseudo', $nom, PDO::PARAM_STR);
                        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                        $stmt->bindParam(':mdp',  hash('sha256', $mdp1), PDO::PARAM_STR);
                        $stmt->bindParam(':avatar',  $avatar, PDO::PARAM_STR);
                        $stmt->bindParam(':role',  $role, PDO::PARAM_STR);

                        if ($role === "Participant") {
                            $stmt->bindParam(':favgame', $favjeu, PDO::PARAM_STR);
                            $stmt->bindParam(':setup',  $selectedSetup, PDO::PARAM_STR);
                        } else {
                            $stmt->bindValue(':favgame', null, PDO::PARAM_NULL);
                            $stmt->bindValue(':setup',  null, PDO::PARAM_NULL);
                        }

                        if ($stmt->execute()) {
                            if (isset($_POST['remember_me']) && $_POST['remember_me'] == "on") {
                                setcookie('remember_user', $PlayerId, time() + 60 * 60 * 24 * 30); // Valide pendant 30 jours
                            }
                            $_SESSION['PlayerId'] = $PlayerId;
                            header('Status: 301 Moved Permanently', false, 301);
                            header('Location:./connexion.php');
                            exit(0);
                        }
                        $db = null;
                    }
                }
            }
        }
    }
} catch (PDOException $e) {
    // Gestion des erreurs liées à la base de données
    echo 'Erreur de base de données : ' . $e->getMessage();
} catch (Exception $e) {
    // Gestion des autres erreurs
    echo 'Une erreur inattendue s\'est produite : ' . $e->getMessage();
}


function generateId(array $excludeArray)
{
    // Générer un nombre aléatoire de 10000 à 99999
    $randomNumber = mt_rand(10000, 99999);

    // Vérifier si le nombre généré est dans le tableau exclu
    while (in_array($randomNumber, $excludeArray)) {
        // Si oui, générer un nouveau nombre
        $randomNumber = mt_rand(10000, 99999);
    }

    // Retourner le nombre unique généré
    return $randomNumber;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="./assets/style/inscription.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="icon" href="./assets/img/favicon.png" type="image/x-icon">
</head>

<body>
    <header>
        <?php
        include('navbar.php');
        ?>
    </header>
    <main>
        <div>
            <div id="title">
                <h1>Inscription</h1>
                <h2>Rejoignez-nous ici !</h2>
            </div>
            <div id="form">
                <form action="" method="post">
                    <div>
                        <div>
                            <div class="double-inp">
                                <div>
                                    <input type="text" placeholder="Entrer votre nom" name="nom" required>
                                </div>
                                <div>
                                    <input type="text" placeholder="Entrer votre prénom" name="prenom" required>
                                </div>
                            </div>
                            <div class="simple-inp">
                                <img src="./assets/img/profil.svg" alt="">
                                <input type="text" placeholder="Entrer votre pseudo" name="pseudo" id="pseudo" required>
                            </div>
                            <div class="simple-inp">
                                <img src="./assets/img/mail.svg" alt="">
                                <input type="email" placeholder="Entrer votre email" name="email" id="email" required>
                            </div>
                            <div class="double-inp">
                                <div>
                                    <img src="./assets/img/cadena.svg" alt="">
                                    <input type="password" placeholder="Entrer votre mot de passe" name="mdp1" class="mdp" required>
                                </div>
                                <div>
                                    <img src="./assets/img/cadena.svg" alt="">
                                    <input type="password" placeholder="Confirmer votre mot de passe" name="mdp2" class="mdp" required>
                                </div>
                            </div>
                            <p id="config-psw">
                                Le mot de passe doit contenir : <br>
                                8 caractères, 1 caractère en minuscule, 1 caractère en majuscule, 1 chiffre
                            </p>
                            <div class="radio">
                                <div>
                                    <input type="radio" name="role" class="role" value="Participant" id="participant" required>
                                    <label for="participant">Participant</label><br>
                                </div>
                                <div>
                                    <input type="radio" name="role" class="role" value="Conducteur" id="conducteur" required>
                                    <label for="conducteur">Conducteur</label>
                                </div>
                            </div>
                            <div class="radio setup">
                                <div>
                                    <input type="radio" name="setup" value="PC portable" id="portable">
                                    <label for="portable">PC portable</label><br>
                                </div>
                                <div>
                                    <input type="radio" name="setup" value="PC fixe" id="fixe">
                                    <label for="fixe">PC fixe</label><br>
                                </div>
                            </div>
                            <div class="simple-inp">
                                <select name="favjeu" id="select_jeu">
                                    <option value="">Choisissez votre jeu favori</option>
                                    <option value="Track Mania: Nation Forever">Track Mania: Nation Forever</option>
                                    <option value="Geo Guesseur">Geo Guesseur</option>
                                    <option value="Overwatch">Overwatch</option>
                                    <option value="Brawlhalla">Brawlhalla</option>
                                    <option value="CS GO">CS GO</option>
                                    <option value="Rocket League">Rocket League</option>
                                </select>
                            </div>
                            <div id="end-form">
                                <div>
                                    <input type="checkbox" name="remember_me" id="souvenir">
                                    <label for="souvenir">Se souvenir de moi</label>
                                </div>
                                <a href="./connexion.php">Se connecter ?</a>
                            </div>
                        </div>
                        <div id="choix_ava">
                            <div>
                                <h3>Choisissez votre avatar</h3>
                                <div id="liste_ava">
                                    <svg id="pre" xmlns="http://www.w3.org/2000/svg" width="13" height="25" viewBox="0 0 13 25" fill="none">
                                        <path d="M11.5 1L0 12.5L11.5 24" stroke="white" stroke-width="2" />
                                    </svg>
                                    <div class="avatar">
                                        <?php
                                        $categories = ['prem', 'sec'];

                                        foreach ($categories as $category) {
                                            for ($i = 1; $i <= 6; $i++) {
                                                $avatarNumber = ($category == 'prem') ? $i : $i + 6;
                                        ?>
                                                <div class="avatar-option <?= $category ?>">
                                                    <img src="./assets/img/avatar<?= $avatarNumber ?>.png" alt="">
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <svg id="next" xmlns="http://www.w3.org/2000/svg" width="13" height="25" viewBox="0 0 13 25" fill="none">
                                        <path d="M1 24L12.5 12.5L1 1" stroke="white" stroke-width="2" />
                                    </svg>
                                </div>
                                <!-- Input qui prend comme valeur la src de l'image sur laquelle l'utilisateur à cliquer -->
                                <input type="hidden" name="avatar" id="avatar" value="" required>
                            </div>
                        </div>
                    </div>
                    <div id="accept-rules">
                        <input type="checkbox" name="rules" id="rules" required>
                        <label for="rules">En vous inscrivant vous acceptez le règlement de la MMI LAN ainsi que le traitement de vos données.</label>
                    </div>
                    <input type="submit" id="submit" value="Inscription">
                    <div>
                        <?php
                        if ($errorMessage) {
                            echo $errorMessage;
                        }
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <?php
        include('footer.php');
    ?>
    <script src="./assets/js/countDown.js"></script>
    <script src="./assets/js/role_participant.js"></script>
    <script src="./assets/js/gallerie_avatar.js"></script>
    <script src="./assets/js/gestion_mdp.js"></script>
</body>

</html>