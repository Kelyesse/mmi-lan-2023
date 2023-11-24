<?php
// Initialiser la session
session_start();
try {
    if (isset($_SESSION['PlayerId'])) {
        // Se connecter à la base de données et récupérer l'ensemble des comptes
        require_once('connexionbdd.php');

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
                    $teamId = $teamAccount['TeamId'];

                    // Récupérer les informations de l'équipe
                    $infoTeamAccount = $db->query('SELECT * FROM team WHERE TeamId = ' . $teamAccount['TeamId'] . ';')->fetch(PDO::FETCH_ASSOC);

                    // Récupérer le pseudo des membres de l'équipe (même les membres pas acceptés)
                    $sql = 'SELECT player.PlayerId, player.PlayerPseudo, belongteam.BelongStatus, belongteam.BelongRole FROM player JOIN belongteam ON player.PlayerId = belongteam.PlayerId WHERE belongteam.TeamId = ' . $teamAccount['TeamId'] . ';';
                    $teamMembers = $db->query($sql)->fetchall(PDO::FETCH_ASSOC);

                    // Vérifier si le compte est le créateur de l'équipe
                    if ($teamAccount["BelongRole"] == 'Créateur') {
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
    } else {
        // Rediriger vers la page de connexion
        header('Status: 301 Moved Permanently', false, 301);
        header('Location:./connexion.php');
        exit(0);
    }
} catch (PDOException $e) {
    // Gestion des erreurs liées à la base de données
    echo 'Erreur de base de données : ' . $e->getMessage();
} catch (Exception $e) {
    // Gestion des autres erreurs
    echo 'Une erreur inattendue s\'est produite : ' . $e->getMessage();
}
$teamIdValue = isset($teamAccount['TeamId']) ? $teamAccount['TeamId'] : '';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte - MMI LAN</title>
    <link rel="stylesheet" href="./assets/style/mon_compte.css">
    <link rel="stylesheet" href="./assets/style/footer.css">
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
                    <h2>Bonjour
                        <?php echo $account['PlayerPseudo']; ?> !
                    </h2>
                </div>
                <img src="./assets/img/pattern.svg" alt="">
            </div>
        </section>
        <section>
            <div id="player-info">
                <img src="./assets/img/<?php echo $account['PlayerPicture'] ?>" alt="avatar du compte">
                <div>
                    <div class="info">
                        <div id="ps">
                            <img src="./assets/img/profil.svg" alt="">
                            <p>Pseudo:
                                <?php echo $account['PlayerPseudo'] ?>
                            </p>
                        </div>
                        <button id="editPseudo" onclick="openModal('editPseudo')">
                            <!-- Remplace le texte par un SVG -->
                            <img src="./assets/img/modif_icon.svg" alt="Modifier">
                        </button>
                    </div>
                    <div class="info">
                        <div id="mail">
                            <img src="./assets/img/mail.svg" alt="">
                            <p>Adresse mail:
                                <?php echo $account['PlayerEmail'] ?>
                            </p>
                        </div>
                        <button id="editEmail" onclick="openModal('editEmail')">
                            <!-- Remplace le texte par un SVG -->
                            <img src="./assets/img/modif_icon.svg" alt="Modifier">
                        </button>
                    </div>
                    <?php
                    if (isset($creator) && $creator) {
                        echo '<div>';
                        echo '  <img src="./assets/img/nom.svg" alt="">';
                        echo "  <p>Nom de l'équipe: " . $infoTeamAccount['TeamName'] . "</p>";
                        echo '  <button id="editTeamName" onclick="openModal(\'editTeamName\')">';
                        echo '      <!-- Remplace le texte par un SVG -->';
                        echo '      <img src="./assets/img/modif_icon.svg" alt="Modifier">';
                        echo '  </button>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
            <!-- Ne doit pas apparaître si l'utilisateur est conducteur -->
            <?php
            if ($player) {
                echo '<div id="player-desc">';
                echo '    <div id="jeu">';
                echo '        <p>Votre jeu favori : ' . $account['PlayerFavGame'] . '</p>';
                echo '    </div>';
                echo '</div>';
            }
            ?>
        </section>

        <!-- Section qui apparaît si participant avec équipe -->
        <?php
        if (isset($team) && $team) {
            echo '<section id="team">';
            echo '    <div>';
            echo '        <div id="team-desc">';
            echo '            <div>';
            echo '                <h2>Equipe : ' . $infoTeamAccount['TeamName'] . '</h2>';
            echo '                <p>Description : ' . $infoTeamAccount['TeamDesc'] . '</p>';
            // echo '                <button>Modifier la description</button>';
            echo '            </div>';
            echo '            <div id="li-mate">';
            echo '                <h3>Membres de l’équipe</h3>';
            echo '                <div>';
            if ($creator) {
                foreach ($teamMembers as $teamMember) {
                    echo '<div>';
                    echo '    <p class="mate">' . $teamMember['PlayerPseudo'] . '</p>';

                    // Si le membre est déjà accepté dans l'équipe
                    if ($teamMember['BelongStatus'] == 'validé' && $teamMember['BelongRole'] !== 'Créateur') {
                        echo '    <button class="remove-mate" data-userid="' . $teamMember['PlayerId'] . '"><span class="remove-mate-text">Supprimer</span>';
                        echo '        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="9" viewBox="0 0 10 9" fill="none">';
                        echo '            <path d="M1 0.5L9 8.5M9 0.5L1 8.5" stroke="#CD0C75" />';
                        echo '        </svg>';
                        echo '    </button>';
                    }
                    // Si le membre est en attente d'acceptation
                    elseif ($teamMember['BelongStatus'] == 'en attente') {
                        echo '    <button class="accept-mate" data-userid="' . $teamMember['PlayerId'] . '" data-teamid="' . $teamAccount['TeamId'] . '">Accepter</button>';
                        echo '    <button class="reject-mate" data-userid="' . $teamMember['PlayerId'] . '" data-teamid="' . $teamAccount['TeamId'] . '">Refuser</button>';
                    }

                    echo '</div>';
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
            echo '        <div class="team-logo">';
            echo '            <img src="./assets/img/' . $infoTeamAccount['TeamLogo'] . '" alt="logo de l\'équipe">';
            $req = $db->prepare('SELECT BelongRole FROM belongteam WHERE PlayerId=?');
            $req->execute([$_SESSION['PlayerId']]);
            $role = $req->fetch()['BelongRole'];
            if ($role == "Créateur") {
                echo '        <button id="change-logo">Changer le logo</button>';
            }
            echo '        </div>';
            echo '    </div>';
            if ($creator) {
                echo '    <div id="buttons">';
                echo '    <button id="remove-team">Supprimer mon équipe</button>';
                echo '    </div>';
            } else {
                echo '    <div id="buttons">';
                echo '    <button id="leave-team">Quitter mon équipe</button>';
                echo '    </div>';
            }
            echo '</section>';
        } else {
            $req = $db->prepare('SELECT PlayerStatus FROM player WHERE PlayerId=?');
            $req->execute([$_SESSION['PlayerId']]);
            $status = $req->fetch()['PlayerStatus'];
            if ($status == 'Participant') {
                echo '<section id="no-team">';
                echo '    <div>';
                echo '        <button><a href="./creation_equipe.php">Créer une équipe</a></button>';
                echo '        <button><a href="./listing_equipe.php">Rejoindre une équipe</a></button>';
                echo '    </div>';
                echo '</section>';
            }
        }
        ?>


        <section id="account">
            <div>
                <form action="./deconnection.php" method="post">
                    <input type="hidden" name="playerId" value="<?php echo $_SESSION['PlayerId']; ?>">
                    <input type="submit" value="Me déconnecter">
                </form>

                <button id="delete-account-button">Supprimer mon compte</button>

            </div>
        </section>

        <!-- Messages de confirmation de modification -->
        <div id='reponses_traitement'>
            <?php
            // Afficher les messages d'erreur ou de succès s'ils existent
            if (isset($_SESSION['error_message'])) {
                echo '<div class="error-message">' . $_SESSION['error_message'] . '</div>';
                unset($_SESSION['error_message']); // Effacer le message après l'avoir affiché
            }

            if (isset($_SESSION['success_message'])) {
                echo '<div class="success-message">' . $_SESSION['success_message'] . '</div>';
                unset($_SESSION['success_message']); // Effacer le message après l'avoir affiché
            }
            ?>
        </div>

        <!-- Pop-ups de confirmation -->

        <!-- Suppression membre de l'équipe -->
        <div id="confirmationPopup" class="popup">
            <div class="popup-content">
                <p>Etes-vous sûr de vouloir supprimer cette personne de l'équipe ?</p>
                <form action="./delete_member.php?teamId=<?php echo $teamId ?>" method="post">
                    <input type="hidden" id="userIdToDelete" name="userId" value="">
                    <input id="submit" type="submit" value="Oui, supprimer cette personne" class="confirmYes"
                        name='delete_member'>
                </form>
                <button class="confirmNo">Non, j’ai changé d’avis</button>
            </div>
        </div>

        <!-- Suppression équipe -->
        <div id="popUpTeam" class="popup">
            <div class="popup-content">
                <p>Etes-vous sûr de vouloir supprimer votre équipe ?</p>
                <span><i style="color: red">Supprimer votre équipe revient à priver votre équipiers d'une
                        équipe</i></span>
                <form action="delete_team.php?teamId=<?php echo $teamId ?>" method="post">
                    <input id="submit" type="submit" value="Oui, supprimer mon équipe" class="confirmYes">
                </form>
                <button class="confirmNo">Non, j’ai changé d’avis</button>
            </div>
        </div>

        <!-- Suppression compte -->
        <div id="popUpAccount" class="popup">
            <div class="popup-content">
                <p>Etes-vous sûr de vouloir supprimer votre compte ?</p>
                <span><i style="color: red">Supprimer votre compte revient à priver votre équipiers d'une équipe et vos
                        passagers d'un covoiturage</i></span>
                <form action="./delete_account.php" method="post">
                    <input id="submit" type="submit" value="Oui, supprimer mon compte" class="confirmYes">
                </form>
                <button class="confirmNo">Non, j’ai changé d’avis</button>
            </div>
        </div>

        <!--Quitter equipe-->
        <div id="popUpLeave" class="popup">
            <div class="popup-content">
                <p>Etes-vous sûr de vouloir quitter votre équipe ?</p>
                <form action="./quit_team.php?teamId=<?php echo $teamId ?>" method="post">
                    <input id="submit" type="submit" value="Oui, quitter mon équipe" class="confirmYes">
                </form>
                <button class="confirmNo">Non, j’ai changé d’avis</button>
            </div>
        </div>
    </main>
    <?php
    include('./footer.php');
    ?>
    <!-- Accepter membre de l'équipe -->
    <div id="acceptMemberPopup" class="popup">
        <div class="popup-content">
            <p>Voulez-vous accepter cette personne dans l'équipe ?</p>
            <form action="accept_member.php?teamId=<?php echo $teamId ?>" method="post">
                <input type="hidden" id="userIdToAccept" name="userId" value="">
                <input id="submit" type="submit" value="Oui, accepter" class="confirmYes" name='accept_member'>
            </form>
            <button class="confirmNo">Non, j’ai changé d’avis</button>
        </div>
    </div>

    <!-- Refuser membre de l'équipe -->
    <div id="rejectMemberPopup" class="popup">
        <div class="popup-content">
            <p>Voulez-vous refuser cette personne dans l'équipe ?</p>
            <form action="reject_member.php?teamId=<?php echo $teamId ?>" method="post">
                <input type="hidden" id="userIdToReject" name="userId" value="">
                <input id="submit" type="submit" value="Oui, refuser" class="confirmYes" name='reject_member'>
            </form>
            <button class="confirmNo">Non, j’ai changé d’avis</button>
        </div>
    </div>

    <!-- Modal pour changer le logo -->
    <div id="changeLogoPopup" class="popup">
        <div class="popup-content">
            <p>Changer le logo de l'équipe</p>
            <form action="./change_logo.php" method="post" enctype="multipart/form-data">
                <label for="logoFile">Sélectionner un fichier logo (png, jpg, jpeg)</label>
                <input type="file" name="logoFile" id="logoFile" accept=".png, .jpg, .jpeg" required>
                <input type="hidden" name="teamId" value="<?php echo $teamAccount['TeamId']; ?>">
                <input id="submit" type="submit" value="Changer le logo" class="confirmYes">
            </form>
            <button class="confirmNo">Annuler</button>
        </div>
    </div>

    <!-- Modale pour éditer le pseudo -->
    <div id="editPseudoPopup" class="popup">
        <div class="popup-content">
            <p>Modifier le pseudo</p>
            <form action="traitement_pseudo.php" method="post">
                <label for="newPseudo">Nouveau pseudo :</label>
                <input type="text" id="newPseudo" name="newPseudo" required>
                <input id="submit" type="submit" value="Enregistrer les modifications" class="confirmYes">
            </form>
            <button class="confirmNo">Annuler</button>
        </div>
    </div>

    <!-- Modale pour éditer l'email -->
    <div id="editEmailPopup" class="popup">
        <div class="popup-content">
            <p>Modifier l'email</p>
            <form action="traitement_email.php" method="post">
                <label for="newEmail">Nouvel email :</label>
                <input type="email" id="newEmail" name="newEmail" required>
                <input id="submit" type="submit" value="Enregistrer les modifications" class="confirmYes">
            </form>
            <button class="confirmNo">Annuler</button>
        </div>
    </div>

    <!-- Modale pour éditer le mot de passe
    <div id="editPasswordPopup" class="popup">
        <div class="popup-content">
            <p>Modifier le mot de passe</p>
            <form action="traitement_password.php" method="post">
                <label for="oldPassword">Ancien mot de passe :</label>
                <input type="password" id="oldPassword" name="oldPassword" required>
                <label for="newPassword">Nouveau mot de passe :</label>
                <input type="password" id="newPassword" name="newPassword" required>
                <label for="confirmPassword">Confirmer le mot de passe :</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
                <input type="submit" value="Enregistrer les modifications" class="confirmYes">
                <input type="hidden" name="userId" value='<? /*php echo $_SESSION['PlayerId']; */?>'>
            </form>
            <p id="config-psw">
                Le mot de passe doit contenir : <br>
                8 caractères, 1 caractère en minuscule, 1 caractère en majuscule, 1 chiffre
            </p>
            <button class="confirmNo">Annuler</button>
        </div>
    </div>-->

    <!-- Modale pour éditer le nom de l'équipe -->
    <div id="editTeamNamePopup" class="popup">
        <div class="popup-content">
            <p>Modifier le nom de l'équipe</p>
            <form action="traitement_teamname.php?teamId=<?php echo $teamId ?>" method="post">
                <label for="newTeamName">Nouveau nom d'équipe :</label>
                <input type="text" id="newTeamName" name="newTeamName"
                    value="<?php echo htmlspecialchars($infoTeamAccount['TeamName']); ?>" required>
                <label for="newDescTeam">Nouvel description de l'équipe :</label>
                <input type="textarea" id="newDescTeam" name="newTeamDesc"
                    value="<?php echo htmlspecialchars($infoTeamAccount['TeamDesc']); ?>" required>
                <input id="submit" type="submit" value="Enregistrer les modifications" class="confirmYes">
            </form>
            <button class="confirmNo">Annuler</button>
        </div>
    </div>

    <script src="./assets/js/countDown.js"></script>
    <script src="./assets/js/popup.js"></script>
</body>

</html>