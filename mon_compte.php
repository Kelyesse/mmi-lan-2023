<?php
// Initialiser la session
session_start();

if (isset($_SESSION['PlayerId'])) {
    // Se connecter à la base de données et récupérer l'ensemble des comptes
    require_once('connexionbdd.php');
    try {
        $allAccounts = $db->query('SELECT * FROM player;')->fetchall(PDO::FETCH_ASSOC);
        $is_in = false;

        // Vérifier si le compte fait partie de la bdd
        foreach ($allAccounts as $account) {
            if ($account['PlayerId'] == $_SESSION['PlayerId']) {
                $is_in = true;
                break;
            }
        }

        // Si le compte fait partie de la bdd
        if ($is_in) {
            // Vérifier le type de compte (conducteur/participant)
            if (empty($account['PlayerFavGame']) && empty($account['PlayerSetup'])) {
                // Si le compte est un conducteur
                $player = false;
            } else {
                // Si le compte est un participant
                $player = true;

                // Récupérer l'équipe du compte s'il fait partie d'une équipe
                $teamAccount = $db->query('SELECT * FROM belongteam WHERE PlayerId = ' . $_SESSION['PlayerId'] . ';')->fetch(PDO::FETCH_ASSOC);

                // Vérifier que la personne est acceptée dans l'équipe
                if (!is_null($teamAccount) && $teamAccount["BelongStatus"] == "validé") {
                    // Si la personne est dans une équipe
                    $team = true;

                    // Récupérer les informations de l'équipe
                    $infoTeamAccount = $db->query('SELECT * FROM team WHERE TeamId = ' . $teamAccount['TeamId'] . ';')->fetch(PDO::FETCH_ASSOC);

                    // Récupérer le pseudo des membres de l'équipe (même les membres pas acceptés)
                    $sql = 'SELECT player.PlayerId, player.PlayerPseudo, belongteam.BelongStatus, belongteam.BelongRole FROM player JOIN belongteam ON player.PlayerId = belongteam.PlayerId WHERE belongteam.TeamId = ' . $teamAccount['TeamId'] . ';';
                    $teamMembers = $db->query($sql)->fetchall(PDO::FETCH_ASSOC);

                    // Vérifier si le compte est le créateur de l'équipe
                    if ($teamAccount["BelongStatus"] == 'créateur') {
                        $creator = true;
                    } else {
                        $creator = false;
                    }
                } else {
                    // Si la personne n'est pas dans une équipe
                    $team = false;
                }
            }
        } else {
            // Si l'id ne fait pas partie de la base : grosse erreur
            header('Status: 301 Moved Permanently', false, 301);
            header('Location:./connexion.php');
            exit(0);
        }
    } catch (Exception $e) {
        $erroMessage = '';
    }
} else {
    // Rediriger vers la page de connexion
    header('Status: 301 Moved Permanently', false, 301);
    header('Location:./connexion.php');
    exit(0);
}
$teamIdValue = isset($teamAccount['TeamId']) ? $teamAccount['TeamId'] : '';
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
    <?php
    // Intégrer le bloc de script PHP juste avant l'inclusion de popup.js
    echo '<script>';
    echo 'var teamIdValue = ' . json_encode($teamIdValue) . ';';
    echo '</script>';
    ?>
    <header>
        <?php
        include('navbar.php');
        ?>
    </header>
    <main>
        <section>
            <div id="div-title">
                <div class="title">
                    <h1>Mon compte</h1>
                    <h2>Bonjour <?php echo $account['PlayerName'] ?> !</h2>
                </div>
                <img src="./assets/img/pattern.svg" alt="">
            </div>
        </section>
        <section>
            <!-- Donner un moyen de modifier ses informations personnelles -->
            <div id="player-info">
                <!-- Avatar du joueur à ajouter au back -->
                <img src="<?php echo $account['PlayerPicture'] ?>" alt="avatar du compte">
                <div>
                    <div>
                        <img src="./assets/img/profil.svg" alt="">
                        <!-- Pseudo du joueur à ajouter au back -->
                        <p>Pseudo</p>
                    </div>
                    <div>
                        <img src="./assets/img/mail.svg" alt="">
                        <!-- @mail du joueur à ajouter au back -->
                        <p>Adresse mail</p>
                    </div>
                    <div>
                        <img src="./assets/img/nom.svg" alt="">
                        <!-- Nom équipe du joueur à ajouter au back -->
                        <p>Nom de l'équipe</p>
                    </div>
                    <div>
                        <img src="./assets/img/cadena.svg" alt="">
                        <!-- Mdp du joueur à ajouter au back -->
                        <p>Mot de passe</p>
                    </div>
                </div>
            </div>
            <!-- Ne doit pas apparaître si l'utilisateur est conducteur -->
            <?php
            if ($player) {
                echo '<div id="player-desc">';
                echo '    <div id="jeu">';
                echo '        <p>' . $account['PlayerFavGame'] . '</p>';
                echo '    </div>';
                echo '</div>';
            }
            ?>
        </section>

        <!-- Section qui apparaît si participant avec équipe -->
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
            // Si tu es le créateur de l'équipe, il faut afficher ça
            if ($creator) {
                foreach ($teamMembers as $teamMember) {
                    // Vérifier si le membre est l'owner, un membre accepté ou un membre en attente
                    if ($teamMember['BelongRole'] == 'créateur') {
                        echo '                    <div>';
                        echo '                        <p class="mate">' . $teamMember['PlayerPseudo'] . '</p>';
                        echo '                    </div>';
                    } else {
                        if ($teamMember['BelongStatus'] == 'validé') {
                            echo '                    <div>';
                            echo '                        <p class="mate">' . $teamMember['PlayerPseudo'] . '</p>';
                            echo '                          <button class="remove-mate" data-userid="' . $teamMember['PlayerId'] . '">Supprimer';
                            echo '                              <svg xmlns="http://www.w3.org/2000/svg" width="10" height="9" viewBox="0 0 10 9" fill="none">';
                            echo '                                  <path d="M1 0.5L9 8.5M9 0.5L1 8.5" stroke="#CD0C75" />';
                            echo '                              </svg>';
                            echo '                          </button>';
                            echo '                    </div>';
                        } elseif ($teamMember['BelongStatus'] == 'en attente') {
                            echo '                    <div>';
                            echo '                        <p class="mate">' . $teamMember['PlayerPseudo'] . '</p>';
                            echo '                          <button class="accept-mate" data-userid="' . $teamMember['PlayerId'] . '">Accepter</button>';
                            echo '                          <button class="reject-mate" data-userid="' . $teamMember['PlayerId'] . '">Refuser</button>';
                            echo '                    </div>';
                        }
                    }
                }
            } else {
                foreach ($teamMembers as $teamMember) {
                    echo '                    <div>';
                    echo '                        <p class="mate">' . $teamMember['PlayerPseudo'] . '</p>';
                    echo '                    </div>';
                }
            }

            echo '                </div>';
            echo '            </div>';
            echo '        </div>';
            echo '        <div>';
            echo '            <img src="' . $infoTeamAccount['TeamLogo'] . '" alt="logo de l\'équipe" style="width: 400px; height: 400px;">';
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
                <!-- setcookie('remember_user', '', time() - 3600); -->
                <a id="deco" href="">Me déconnecter</a>
                <button id="remove-account">Supprimer mon compte</button>
            </div>
        </section>

        <!-- Pop-ups de confirmation -->

        <!-- Suppression membre de l'équipe -->
        <div id="confirmationPopup" class="popup">
            <div class="popup-content">
                <p>Etes-vous sûr de vouloir supprimer cette personne de l'équipe ?</p>
                <form action="./delete_member.php" method="post">
                    <input type="hidden" name="teamId" value="<?php echo $teamAccount['TeamId']; ?>">
                    <input type="hidden" id="userIdToDelete" name="userId" value="">
                    <input type="submit" value="Oui, supprimer cette personne" class="confirmYes" name='delete_member'>
                </form>
                <button class="confirmNo">Non, j’ai changé d’avis</button>
            </div>
        </div>

        <!-- Suppression équipe -->
        <div id="popUpTeam" class="popup">
            <div class="popup-content">
                <p>Etes-vous sûr de vouloir supprimer votre équipe ?</p>
                <form action="./delete_team.php" method="post">
                    <input type="submit" value="Oui, supprimer mon équipe" class="confirmYes">
                </form>
                <button class="confirmNo">Non, j’ai changé d’avis</button>
            </div>
        </div>

        <!-- Suppression compte -->
        <div id="popUpAccount" class="popup">
            <div class="popup-content">
                <p>Etes-vous sûr de vouloir supprimer votre compte ?</p>
                <form action="./delete_account.php" method="post">
                    <input type="submit" value="Oui, supprimer mon compte" class="confirmYes">
                </form>
                <button class="confirmNo">Non, j’ai changé d’avis</button>
            </div>
        </div>

        <!--Quitter equipe-->
        <div id="popUpLeave" class="popup">
            <div class="popup-content">
                <p>Etes-vous sûr de vouloir quitter votre équipe ?</p>
                <form action="./quit_team.php" method="post">
                    <!-- Ajoutez un champ caché pour stocker l'ID de l'équipe -->
                    <input type="hidden" name="teamId" value="<?php echo isset($teamAccount['TeamId']) ? $teamAccount['TeamId'] : ''; ?>">
                    <input type="submit" value="Oui, quitter mon équipe" class="confirmYes">
                </form>
                <button class="confirmNo">Non, j’ai changé d’avis</button>
            </div>
        </div>
    </main>

    <!-- Accepter membre de l'équipe -->
    <div id="acceptMemberPopup" class="popup">
        <div class="popup-content">
            <p>Voulez-vous accepter cette personne dans l'équipe ?</p>
            <form action="./accept_member.php" method="post">
                <input type="hidden" id="userIdToAccept" name="userId" value="">
                <input type="submit" value="Oui, accepter" class="confirmYes" name='accept_member'>
            </form>
            <button class="confirmNo">Non, j’ai changé d’avis</button>
        </div>
    </div>

    <!-- Refuser membre de l'équipe -->
    <div id="rejectMemberPopup" class="popup">
        <div class="popup-content">
            <p>Voulez-vous refuser cette personne dans l'équipe ?</p>
            <form action="./reject_member.php" method="post">
                <input type="hidden" id="userIdToReject" name="userId" value="">
                <input type="submit" value="Oui, refuser" class="confirmYes" name='reject_member'>
            </form>
            <button class="confirmNo">Non, j’ai changé d’avis</button>
        </div>
    </div>


    <script src="./assets/js/countDown.js"></script>
    <script src="./assets/js/popup.js"></script>
</body>

</html>