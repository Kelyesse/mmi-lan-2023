<?php
// Initialiser la session
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Traitement du formulaire lorsque le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification si tous les champs requis sont présents
    $requiredFields = ['nom', 'prenom', 'pseudo', 'email', 'mdp1', 'mdp2', 'role', 'avatar'];
    $missingFields = array_diff($requiredFields, array_keys($_POST));

    if (!empty($missingFields)) {
        $errorMessage = 'Veuillez remplir tous les champs obligatoires.';
    } else {
        // Validation des champs et attribution des valeurs aux variables
        $pseudo = $_POST["pseudo"];
        $prenom = $_POST["prenom"];
        $nom = $_POST["nom"];
        $email = $_POST["email"];
        $mdp1 = hash('sha256', $_POST["mdp1"]);
        $mdp2 = hash('sha256', $_POST["mdp2"]);
        $role = $_POST["role"];
        $avatar = $_POST["avatar"];
        $favjeu = $_POST["favjeu"];
        $selectedSetup = $_POST["setup"];

        // Validation du rôle de participant
        if ($role == 'Participant') {
            if (empty($favjeu) || empty($selectedSetup)) {
                $errorMessage = 'Veuillez remplir les champs setup et favjeu.';
            }
        }

        // Validation des autres champs
        if (!preg_match("/^[a-zA-Z]+$/", $pseudo) || !preg_match("/^[a-zA-Z]+$/", $prenom) || !preg_match("/^[a-zA-Z]+$/", $nom)) {
            $errorMessage = 'Le nom, prénom et pseudo doivent contenir uniquement des lettres minuscules et majuscules.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = 'L\'adresse email n\'est pas valide.';
        }

        if ($mdp1 != $mdp2) {
            $errorMessage = 'Les mots de passes inscrit sont différents.';
        }
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\d\s])[\w\d\S]{8,}$/', $mdp1)) {
            $errorMessage = 'Les mots de passe ne respectent pas les critères.';
        }

        if ($selectedSetup !== 'PC portable' && $selectedSetup !== 'PC fixe') {
            $errorMessage = 'Le type de setup sélectionné n\'est pas valide.';
        }

        // Vérification du jeu favori
        $jeuxCorrespondance = array(
            "Track Mania: Nation Forever" => 0,
            "Geo Guesseur" => 1,
            "fortnite" => 2,
            "Overwatch" => 3,
            "Brawlhalla" => 4,
            "CS GO" => 5,
            "Rocket League" => 6,
        );

        if (!array_key_exists($favjeu, $jeuxCorrespondance)) {
            $errorMessage = 'Le jeu favori sélectionné n\'est pas valide.';
        }

        // Si aucune erreur dans l'inscription des champs
        if (empty($errorMessage)) {
            //Intégrer le code pour se connecter à la bdd
            try {
                //connection à la bdd
                require_once('connexionbdd.php');

                //Vérifier que le compte ne se trouve pas déjà dans la base
                $testmail = $db->prepare('SELECT * FROM player WHERE PlayerEmail = :email')->fetch(PDO::FETCH_ASSOC);
                $testpseudo = $db->prepare('SELECT * FROM player WHERE PlayerPseudo = :pseudo')->fetch(PDO::FETCH_ASSOC);

                $testmail->bindParam(':email', $email, PDO::PARAM_STR);
                $testpseudo->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);

                $testmail->execute();
                $testpseudo->execute();

                //Si l'email n'est pas déjà dans la base
                if (!empty($testmail)) {
                    //Si le pseudo n'est pas déjà dans la base
                    if (!empty($testpseudo)) {
                        // Génération d'un ID unique
                        $id = generateId($db->query('SELECT PlayerId FROM player')->fetchAll(PDO::FETCH_ASSOC));

                        // Insertion des données dans la base de données en fonction du rôle
                        $sql = "INSERT INTO player (PlayerId, PlayerLastName, PlayerFirstName, PlayerPseudo, PlayerEmail, PlayerPassword, PlayerStatus, PlayerSetup, PlayerFavGame, PlayerPicture) VALUES (:id, :nom, :prenom, :pseudo, :email, :mdp, :statut, :setup, :favgame, :avatar)";
                        $stmt = $db->prepare($sql);

                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                        $stmt->bindParam(':nom', $pseudo, PDO::PARAM_STR);
                        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
                        $stmt->bindParam(':pseudo', $nom, PDO::PARAM_STR);
                        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                        $stmt->bindParam(':mdp',  $mdp1, PDO::PARAM_STR);
                        $stmt->bindParam(':avatar',  $avatar, PDO::PARAM_STR);

                        if ($role === "Participant") {
                            $stmt->bindParam(':setup',  $selectedSetup, PDO::PARAM_STR);
                            $stmt->bindParam(':favgame',  $jeuxCorrespondance[$favjeu], PDO::PARAM_INT);
                        } else {
                            $stmt->bindValue(':setup',  null, PDO::PARAM_NULL);
                            $stmt->bindValue(':favgame', null, PDO::PARAM_NULL);
                        }

                        if ($stmt->execute()) {
                            $_SESSION['PlayerId'] = $id;
                            // Rediriger vers les leçons
                            header('Status: 301 Moved Permanently', false, 301);
                            header('Location:./connexion.php'); // Rediriger vers la bonne page ?
                            exit(0);
                        }
                    } else {
                        //Si le pseudo existe déjà dans la base
                        $errorMessage = 'Ce pseudo est déjà pris.';
                    }
                } else {
                    //Si l'email existe déjà dans la base
                    $errorMessage = 'Un compte a déjà été créé avec cette adresse électronique.';
                }
            } catch (PDOException $e) {
                $errorMessage = "Erreur lors de l'inscription : " . $e->getMessage();
            } finally {
                $db = null;
            }
        }
    }
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

                <!--je me questionne sur quoi mettre en action du form-->

                <form action="" method="post">
                    <div>
                        <div>
                            <div class="double-inp">
                                <input type="text" placeholder="Entrer votre nom" name="nom" required>
                                <input type="text" placeholder="Entrer votre prénom" name="prenom" required>
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
                                    <input type="radio" name="role" class="role" value="Spectateur" id="spectateur" required>
                                    <label for="spectateur">Conducteur</label>
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
                                    <option value="">Choississez votre jeu favoris</option>
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
                                    <input type="checkbox" name="souvenir" id="souvenir">
                                    <label for="souvenir">Se souvenir de moi</label>
                                </div>
                                <a href="./connection.php">Se connecter ?</a>
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
                                        <div class="avatar-option prem">
                                            <img src="./assets/img/avatar1.png" alt="">
                                        </div>
                                        <div class="avatar-option prem">
                                            <img src="./assets/img/avatar2.png" alt="">
                                        </div>
                                        <div class="avatar-option prem">
                                            <img src="./assets/img/avatar3.png" alt="">
                                        </div>
                                        <div class="avatar-option prem">
                                            <img src="./assets/img/avatar4.png" alt="">
                                        </div>
                                        <div class="avatar-option prem">
                                            <img src="./assets/img/avatar5.png" alt="">
                                        </div>
                                        <div class="avatar-option prem">
                                            <img src="./assets/img/avatar6.png" alt="">
                                        </div>
                                        <div class="avatar-option sec">
                                            <img src="./assets/img/avatar7.png" alt="">
                                        </div>
                                        <div class="avatar-option sec">
                                            <img src="./assets/img/avatar8.png" alt="">
                                        </div>
                                        <div class="avatar-option sec">
                                            <img src="./assets/img/avatar9.png" alt="">
                                        </div>
                                        <div class="avatar-option sec">
                                            <img src="./assets/img/avatar10.png" alt="">
                                        </div>
                                        <div class="avatar-option sec">
                                            <img src="./assets/img/avatar11.png" alt="">
                                        </div>
                                        <div class="avatar-option sec">
                                            <img src="./assets/img/avatar12.png" alt="">
                                        </div>
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
    <script src="./assets/js/countDown.js"></script>
    <script src="./assets/js/role_participant.js"></script>
    <script src="./assets/js/gallerie_avatar.js"></script>
    <script src="./assets/js/gestion_mdp.js"></script>
</body>

</html>