<?php
// Initialiser la session
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (isset($_SESSION['PlayerId'])) {
    //Se connecter à la base de données et récupérer l'ensemble des comptes
    require_once('connexionbdd.php');
    try {
        $playerDb = $db->query('SELECT * FROM player WHERE PlayerId = ' . $_SESSION['PlayerId'] . ';')->fetch(PDO::FETCH_ASSOC);
        //Si le compte fait partie de la bdd
        if (!is_null($playerDb)) {
            // vérifier le type de compte (conducteur/participant)
            if (empty($playerDb['PlayerFavGame']) && empty($playerDb['PlayerSetup'])) {
                //Si le compte est un conducteur
                $player = false;
            } else {
                //Si le compte est un participant
                $player = true;
                //Récupérer l'équipe du compte s'il fait partie d'une équipe
                $teamDb = $db->query('SELECT * FROM belongteam WHERE PlayerId = ' . $_SESSION['PlayerId'] . ';')->fetch(PDO::FETCH_ASSOC);
                // Vérifier que la personne est acceptée dans l'équipe
                if (!is_null($teamDb) && $teamDb["BelongStatus"] == "IL est dedans ??") {
                    // si la personne est dans une équipe
                    $team = true;
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
            <div id="player-desc">
                <div id="jeu">
                    <!--à ajouter en back-->
                    <p>Jeu favoris</p>
                </div>
                <div id="desc">
                    <!--à ajouter en back-->
                    <p>Texte de presentation Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>
            </div>
        </section>

        <!--section qui apparait si participant avec équipe-->
        <section id="team">
            <div>
                <div id="team-desc">
                    <div>
                        <!--à ajouter en back nom équipe-->
                        <h2>NOM ÉQUIPE 1</h2>

                        <!--description à ajouter en back-->
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Ut et massa mi. Aliquam in hendrerit urna. Pellentesque sit
                            amet sapien fringilla, mattis ligula consectetur, ultrices mauris.
                            Maecenas vitae mattis tellus.
                        </p>
                        <button>Modifier</button>
                    </div>
                    <div id="li-mate">
                        <h3>Membres de l’équipe</h3>
                        <div>
                            <div>
                                <!--nom du premier membre à ajouter en back-->
                                <p class="mate">Lorem Pheta</p>
                                <button class="remove-mate">supprimer
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="9" viewBox="0 0 10 9" fill="none">
                                        <path d="M1 0.5L9 8.5M9 0.5L1 8.5" stroke="#CD0C75" />
                                    </svg>
                                </button>
                            </div>
                            <div>
                                <!--nom du deuxieme membre à ajouter en back-->
                                <p class="mate">Lorem Pheta</p>
                                <button class="remove-mate">supprimer
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="9" viewBox="0 0 10 9" fill="none">
                                        <path d="M1 0.5L9 8.5M9 0.5L1 8.5" stroke="#CD0C75" />
                                    </svg>
                                </button>
                            </div>
                            <div>
                                <!--nom du troisieme membre à ajouter en back-->
                                <p class="mate">Lorem Pheta</p>
                                <button class="remove-mate">supprimer
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="9" viewBox="0 0 10 9" fill="none">
                                        <path d="M1 0.5L9 8.5M9 0.5L1 8.5" stroke="#CD0C75" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <img src="" alt="" style="width: 400px; height: 400px;">
                </div>
            </div>
            <div id="buttons">
                <button id="remove-team">Supprimer mon équipe</button>
                <button id="leave-team">Changer le logo</button>
            </div>
        </section>

        <!--Section qui apparait si participant sans équipe-->
        <section id="no-team">
            <div>
                <button><a href="#">Creer une équipe</a></button>
                <button><a href="#">Rejoindre une équipe</a></button>
            </div>
        </section>


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