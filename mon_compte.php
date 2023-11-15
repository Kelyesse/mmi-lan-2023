<?php
// Initialiser la session
session_start();

if (isset($_SESSION['PlayerId'])) {
    //Se connecter à la base de données et récupérer l'ensemble des comptes
    require_once('connexionbdd.php');
    try {
        $allAccounts = $db->query('SELECT * FROM player;')->fetchall(PDO::FETCH_ASSOC);
        $is_in = false;
        //Vérifier si le compte fait partie de la bdd
        foreach ($allAccounts as $account) {
            if ($account['PlayerId'] == $_SESSION['PlayerId']) {
                $is_in = true;
                break;
            }
        }
        //Si le compte fait partie de la bdd
        if ($is_in) {
            // vérifier le type de compte (conducteur/participant)
            if (empty($account['PlayerFavGame']) && empty($account['PlayerSetup'])) {
                //Si le compte est un conducteur
                $player = false;
            } else {
                //Si le compte est un participant
                $player = true;

                //Récupérer l'équipe du compte s'il fait partie d'une équipe
                $teamAccount = $db->query('SELECT * FROM belongteam WHERE PlayerId = ' . $_SESSION['PlayerId'] . ';')->fetch(PDO::FETCH_ASSOC);
                // Vérifier que la personne est acceptée dans l'équipe
                if (!is_null($teamAccount) && $teamAccount["BelongStatus"] == "validé") {
                    // si la personne est dans une équipe
                    $team = true;
                    //récupérer les informations de l'équipe
                    $infoTeamAccount = $db->query('SELECT * FROM team WHERE TeamId = ' . $teamAccount['TeamId'] . ';')->fetch(PDO::FETCH_ASSOC);
                    $teamMembers = $db->query('SELECT PlayerId FROM belongteam WHERE TeamId = ' . $teamAccount['TeamId'] . ';')->fetchall(PDO::FETCH_ASSOC);
                } else {
                    // si la personne n'est pas dans une équipe
                    $team = false;
                }
            }
        } else {
            //Si le compte ne fait pas partie de la base : grosse erreur
            header('Status: 301 Moved Permanently', false, 301);
            header('Location:./connexion.php');
            exit(0);
        }
    } catch (Exception $e) {
        $erroMessage = '';
    }
} else {
    //rediriger vers la page de connexion
    header('Status: 301 Moved Permanently', false, 301);
    header('Location:./connexion.php');
    exit(0);
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mon_compte</title>
    <link rel="stylesheet" href="./assets/style/mon_compte.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="icon" href="./assets/img/favicon.png" type="image/x-icon">
</head>

<body>
    <header>
    </header>
    <div class="count-down-timer">
    </div>
    <main>
        <section>
            <div id="div-title">
                <div class="title">
                    <h1>Mon compte</h1>
                    <h2>Bonjour Lorem Pheta !</h2>
                </div>
                <img src="./assets/img/pattern.svg" alt="">
            </div>
        </section>
        <section>
            <div id="player-info">
                <!--avatar du joueur à ajouter au back-->
                <img src="<?php echo $player['PlayerPicture'] ?>" alt="avatar du compte">
                <div>
                    <div>
                        <img src="./assets/img/profil.svg" alt="">
                        <!--pseudo du joueur à ajouter au back-->
                        <p>Pseudo</p>
                    </div>
                    <div>
                        <img src="./assets/img/mail.svg" alt="">
                        <!--@mail du joueur à ajouter au back-->
                        <p>Adresse mail</p>
                    </div>
                    <div>
                        <img src="./assets/img/nom.svg" alt="">
                        <!--Nom équipe du joueur à ajouter au back-->
                        <p>Nom de l'équipe</p>
                    </div>
                    <div>
                        <img src="./assets/img/cadena.svg" alt="">
                        <!--mdp du joueur à ajouter au back-->
                        <p>Mot de passe</p>
                    </div>
                </div>
            </div>
            <!--ne doit pas apparaitre si utilisateur est conducteur-->
            <?php
            if ($player) {
                echo '<div id="player-desc">';
                echo '    <div id="jeu">';
                echo '        <p>' . $account[$_SESSION['PlayerId']]['PlayerFavGame'] . '</p>';
                echo '    </div>';
                echo '</div>';
            }
            ?>
        </section>

        <!--section qui apparait si participant avec équipe-->
        <?php
        if ($team) {
            echo '<section id="team">';
            echo '    <div>';
            echo '        <div id="team-desc">';
            echo '            <div>';
            echo '                <h2>' . $infoTeamAccount['TeamName'] . '</h2>';
            echo '                <p>' . $infoTeamAccount['TeamDesc'] . '</p>';
            echo '                <button>Modifier</button>';
            echo '            </div>';
            echo '            <div id="li-mate">';
            echo '                <h3>Membres de l’équipe</h3>';
            echo '                <div>';

            foreach ($teamMembers as $teamMember) {
                echo '                    <div>';
                echo '                        <p class="mate">' . $allAccounts[$teamMember['PlayerId']] . '</p>';
                echo '                        <button class="remove-mate">supprimer';
                echo '                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="9" viewBox="0 0 10 9" fill="none">';
                echo '                                <path d="M1 0.5L9 8.5M9 0.5L1 8.5" stroke="#CD0C75" />';
                echo '                            </svg>';
                echo '                        </button>';
                echo '                    </div>';
            }
            echo '                </div>';
            echo '            </div>';
            echo '        </div>';
            echo '        <div>';
            echo '            <img src="" alt="" style="width: 400px; height: 400px;">';
            echo '        </div>';
            echo '    </div>';
            echo '    <div id="buttons">';
            echo '        <button id="remove-team">Supprimer mon équipe</button>';
            echo '        <button id="leave-team">Changer le logo</button>';
            echo '    </div>';
            echo '</section>';
        } else {
            echo '<section id="no-team">';
            echo '    <div>';
            echo '        <button><a href="#">Créer une équipe</a></button>';
            echo '        <button><a href="#">Rejoindre une équipe</a></button>';
            echo '    </div>';
            echo '</section>';
        }
        ?>


        <section id="account">
            <div>
                <a id="deco" href="">Me déconnecter</a>
                <button id="remove-account">Supprimer mon compte</button>
            </div>
        </section>

        <!--Pop-ups de confirmation-->

        <!--suppression membre de l'équipe-->
        <div id="confirmationPopup" class="popup">
            <div class="popup-content">
                <p>Etes-vous sûr de vouloir supprimer cette personne de l'équipe ?</p>
                <a href="#" class="confirmYes">Oui, supprimer cette personne</a>
                <button class="confirmNo">Non, j’ai changé d’avis</button>
            </div>
        </div>

        <!--suppression équipe-->
        <div id="popUpTeam" class="popup">
            <div class="popup-content">
                <p>Etes vous sur de vouloir supprimer votre équipe ?</p>
                <a href="" class="confirmYes">Oui, supprimer mon équipe</a>
                <button class="confirmNo">Non, j’ai changé d’avis</button>
            </div>
        </div>

        <!--suppression compte-->
        <div id="popUpAccount" class="popup">
            <div class="popup-content">
                <p>Etes vous sur de vouloir supprimer votre compte ?</p>
                <a href="" class="confirmYes">Oui, supprimer mon compte</a>
                <button class="confirmNo">Non, j’ai changé d’avis</button>
            </div>
        </div>

        <!--Quitter equipe-->
        <div id="popUpLeave" class="popup">
            <div class="popup-content">
                <p>Etes vous sur de vouloir quitter votre équipe ?</p>
                <a href="" class="confirmYes">Oui, quitter mon équipe</a>
                <button class="confirmNo">Non, j’ai changé d’avis</button>
            </div>
        </div>
    </main>

    <script src="./assets/js/countDown.js"></script>
    <script src="./assets/js/popup.js"></script>
</body>

</html>