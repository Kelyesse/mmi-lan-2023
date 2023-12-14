<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="./assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="./assets/style/matchmaking_desktop.css">
    <link rel="stylesheet" href="./assets/style/footer.css">
    <link rel="stylesheet" href="./assets/style/header.css">
    <title>Matchmaking</title>
</head>

<body>
    <header>
        <?php include('navbar.php'); ?>
    </header>

    <main>
        <img class="fond" src="./assets/img/fond_matchmaking.svg" alt="fond_matchmaking">
        <?php
        session_start();
        require_once("connexionbdd.php");

        $req = $db->prepare("SELECT PlayerStatus FROM player WHERE PlayerId=?");
        $req->execute([$_SESSION['PlayerId']]);
        $UserStatus = $req->fetch()['PlayerStatus'];

        if (isset($_POST['submitQuart'])) {
            setQuartMatch($db);
        }

        if (isset($_POST['submitDemi'])) {
            setDemiMatch($db);
        }

        if (isset($_POST['submitFinale'])) {
            setFinaleMatch($db);
        }

        if (isset($_POST['winnerQuart'])) {
            setWinner('Quart', $_POST['winnerQuart'], $db);
        }

        if (isset($_POST['winnerDemi'])) {
            setWinner('Demi', $_POST['winnerDemi'], $db);
        }

        if (isset($_POST['winnerFinale'])) {
            setWinner('Finale', $_POST['winnerFinale'], $db);
        }

        function setWinner($phase, $winner, $db)
        {
            $req = $db->prepare('UPDATE matchmaking SET Winner=? WHERE (TeamId1=? OR TeamId2=?) AND Phase = ?');
            $req->execute([$winner, $winner, $winner, $phase]);
        }

        function setQuartMatch($db)
        {
            $req = $db->prepare('DELETE FROM matchmaking');
            $req->execute();
            for ($i = 0; $i < 4; $i++) {
                $team1 = getTeamForQuart($i, $db)[1];
                $team2 = getTeamForQuart((7 - $i), $db)[1];
                $req = $db->prepare('INSERT INTO matchmaking(TeamId1, TeamId2, Phase, MatchNumber) VALUES(?,?,?,?)');
                $req->execute([$team1, $team2, 'Quart', ($i + 1)]);
            }
        }

        function setDemiMatch($db)
        {
            for ($i = 0; $i < 2; $i++) {
                $team1 = getTeamForDemi((2 * $i + 1), $db)[1];
                $team2 = getTeamForDemi((2 * $i + 2), $db)[1];
                $req = $db->prepare('INSERT INTO matchmaking(TeamId1, TeamId2, Phase, MatchNumber) VALUES(?,?,?,?)');
                $req->execute([$team1, $team2, 'Demi', ($i + 1)]);
            }
        }

        function setFinaleMatch($db)
        {
            $team1 = getTeamForFinale(1, $db)[1];
            $team2 = getTeamForFinale(2, $db)[1];
            $req = $db->prepare('INSERT INTO matchmaking(TeamId1, TeamId2, Phase, MatchNumber) VALUES(?,?,?,?)');
            $req->execute([$team1, $team2, 'Finale', 1]);
        }

        function getTeamForQuart($classement, $db)
        {
            $req = $db->prepare('SELECT TeamName,TeamId FROM team ORDER BY TeamScore DESC LIMIT 8');
            $req->execute();
            $teams = $req->fetchAll();
            $teamName = $teams[$classement][0];
            $teamId = $teams[$classement][1];
            return [$teamName, $teamId];
        }

        function getTeamForDemi($match, $db)
        {
            $req = $db->prepare('SELECT Winner FROM matchmaking WHERE MatchNumber = ? AND Phase = ?');
            $req->execute([$match, 'Quart']);
            $teamId = $req->fetch()['Winner'];
            $req = $db->prepare('SELECT TeamName FROM team WHERE TeamId = ?');
            $req->execute([$teamId]);
            $teamName = $req->fetch()['TeamName'];
            return [$teamName, $teamId];
        }

        function getTeamForFinale($match, $db)
        {
            $req = $db->prepare('SELECT Winner FROM matchmaking WHERE MatchNumber = ? AND Phase = ?');
            $req->execute([$match, 'Demi']);
            $teamId = $req->fetch()['Winner'];
            $req = $db->prepare('SELECT TeamName FROM team WHERE TeamId = ?');
            $req->execute([$teamId]);
            $teamName = $req->fetch()['TeamName'];
            return [$teamName, $teamId];
        }

        function getLANWinner($db)
        {
            $req = $db->prepare('SELECT Winner FROM matchmaking WHERE Phase = ?');
            $req->execute(['Finale']);
            $teamId = $req->fetch()['Winner'];
            $req = $db->prepare('SELECT TeamName FROM team WHERE TeamId = ?');
            $req->execute([$teamId]);
            $teamName = $req->fetch()['TeamName'];
            return $teamName;
        }
        ?>
        <h1>MATCHMAKING</h1>
        <?php
        if ($UserStatus ==  "Admin") {
            echo '<div id="btnAdmin">';
            echo '<form action="matchmaking_desktop.php" method="post">';
            echo '<input type="submit" name="submitQuart" value="Définir les quarts">';
            echo '</form>';

            echo '<form action="matchmaking_desktop.php" method="post">';
            echo '<input type="submit" name="submitDemi" value="Définir les demis">';
            echo '</form>';

            echo '<form action="matchmaking_desktop.php" method="post">';
            echo '<input type="submit" name="submitFinale" value="Définir la finale">';
            echo '</form>';

            echo '</div>';
        }
        ?>

        <section id="tabMM">
            <div class=" equipe equipe1">
                <div class="rectangle">
                    <?php
                    if ($UserStatus ==  "Admin") {
                        echo '<form action="matchmaking_desktop.php" method="post">';
                        echo '<input type="number" name="winnerQuart" value="' . getTeamForQuart(0, $db)[1] . '" hidden>';
                        echo '<input type="submit" value="✅">';
                        echo '</form>';
                    }
                    ?>
                </div>
                <div class="nom">
                    <p><?php echo getTeamForQuart(0, $db)[0] ?></p>
                </div>
            </div>
            <div class=" equipe equipe2">
                <div class="rectangle">
                    <?php
                    if ($UserStatus ==  "Admin") {
                        echo '<form action="matchmaking_desktop.php" method="post">';
                        echo '<input type="number" name="winnerQuart" value="' . getTeamForQuart(7, $db)[1] . '" hidden>';
                        echo '<input type="submit" value="✅">';
                        echo '</form>';
                    }
                    ?>
                </div>
                <div class="nom">
                    <p><?php echo getTeamForQuart(7, $db)[0] ?></p>
                </div>
            </div>
            <div class=" equipe equipe3">
                <div class="rectangle">
                    <?php
                    if ($UserStatus ==  "Admin") {
                        echo '<form action="matchmaking_desktop.php" method="post">';
                        echo '<input type="number" name="winnerQuart" value="' . getTeamForQuart(1, $db)[1] . '" hidden>';
                        echo '<input type="submit" value="✅">';
                        echo '</form>';
                    }
                    ?>
                </div>
                <div class="nom">
                    <p><?php echo getTeamForQuart(1, $db)[0] ?></p>
                </div>
            </div>
            <div class=" equipe equipe4">
                <div class="rectangle">
                    <?php
                    if ($UserStatus ==  "Admin") {
                        echo '<form action="matchmaking_desktop.php" method="post">';
                        echo '<input type="number" name="winnerQuart" value="' . getTeamForQuart(6, $db)[1] . '" hidden>';
                        echo '<input type="submit" value="✅">';
                        echo '</form>';
                    }
                    ?>
                </div>
                <div class="nom">
                    <p><?php echo getTeamForQuart(6, $db)[0] ?></p>
                </div>
            </div>
            <div class=" equipe equipe5">
                <div class="rectangle">
                    <?php
                    if ($UserStatus ==  "Admin") {
                        echo '<form action="matchmaking_desktop.php" method="post">';
                        echo '<input type="number" name="winnerDemi" value="' . getTeamForDemi(1, $db)[1] . '" hidden>';
                        echo '<input type="submit" value="✅">';
                        echo '</form>';
                    }
                    ?>
                </div>
                <div class="nom">
                    <p><?php echo getTeamForDemi(1, $db)[0] ?></p>
                </div>
            </div>
            <div class=" equipe equipe6">
                <div class="rectangle">
                    <?php
                    if ($UserStatus ==  "Admin") {
                        echo '<form action="matchmaking_desktop.php" method="post">';
                        echo '<input type="number" name="winnerDemi" value="' . getTeamForDemi(2, $db)[1] . '" hidden>';
                        echo '<input type="submit" value="✅">';
                        echo '</form>';
                    }
                    ?>
                </div>
                <div class="nom">
                    <p><?php echo getTeamForDemi(2, $db)[0] ?></p>
                </div>
            </div>
            <div class=" equipe equipe7">
                <div class="rectangle">
                    <?php
                    if ($UserStatus ==  "Admin") {
                        echo '<form action="matchmaking_desktop.php" method="post">';
                        echo '<input type="number" name="winnerFinale" value="' . getTeamForFinale(1, $db)[1] . '" hidden>';
                        echo '<input type="submit" value="✅">';
                        echo '</form>';
                    }
                    ?>
                </div>
                <div class="nom">
                    <p><?php echo getTeamForFinale(1, $db)[0] ?></p>
                </div>
            </div>
            <div class=" equipe equipe8">
                <div class="rectangle">
                    <?php
                    if ($UserStatus ==  "Admin") {
                        echo '<form action="matchmaking_desktop.php" method="post">';
                        echo '<input type="number" name="winnerFinale" value="' . getTeamForFinale(2, $db)[1] . '" hidden>';
                        echo '<input type="submit" value="✅">';
                        echo '</form>';
                    }
                    ?>
                </div>
                <div class="nom">
                    <p><?php echo getTeamForFinale(2, $db)[0] ?></p>
                </div>
            </div>
            <div class=" equipe equipe9">
                <div class="rectangle">
                    <?php
                    if ($UserStatus ==  "Admin") {
                        echo '<form action="matchmaking_desktop.php" method="post">';
                        echo '<input type="number" name="winnerDemi" value="' . getTeamForDemi(3, $db)[1] . '" hidden>';
                        echo '<input type="submit" value="✅">';
                        echo '</form>';
                    }
                    ?>
                </div>
                <div class="nom">
                    <p><?php echo getTeamForDemi(3, $db)[0] ?></p>
                </div>
            </div>
            <div class=" equipe equipe10">
                <div class="rectangle">
                    <?php
                    if ($UserStatus ==  "Admin") {
                        echo '<form action="matchmaking_desktop.php" method="post">';
                        echo '<input type="number" name="winnerDemi" value="' . getTeamForDemi(4, $db)[1] . '" hidden>';
                        echo '<input type="submit" value="✅">';
                        echo '</form>';
                    }
                    ?>
                </div>
                <div class="nom">
                    <p><?php echo getTeamForDemi(4, $db)[0] ?></p>
                </div>
            </div>
            <div class=" equipe equipe11">
                <div class="rectangle">
                    <?php
                    if ($UserStatus ==  "Admin") {
                        echo '<form action="matchmaking_desktop.php" method="post">';
                        echo '<input type="number" name="winnerQuart" value="' . getTeamForQuart(2, $db)[1] . '" hidden>';
                        echo '<input type="submit" value="✅">';
                        echo '</form>';
                    }
                    ?>
                </div>
                <div class="nom">
                    <p><?php echo getTeamForQuart(2, $db)[0] ?></p>
                </div>
            </div>
            <div class=" equipe equipe12">
                <div class="rectangle">
                    <?php
                    if ($UserStatus ==  "Admin") {
                        echo '<form action="matchmaking_desktop.php" method="post">';
                        echo '<input type="number" name="winnerQuart" value="' . getTeamForQuart(5, $db)[1] . '" hidden>';
                        echo '<input type="submit" value="✅">';
                        echo '</form>';
                    }
                    ?>
                </div>
                <div class="nom">
                    <p><?php echo getTeamForQuart(5, $db)[0] ?></p>
                </div>
            </div>
            <div class=" equipe equipe13">
                <div class="rectangle">
                    <?php
                    if ($UserStatus ==  "Admin") {
                        echo '<form action="matchmaking_desktop.php" method="post">';
                        echo '<input type="number" name="winnerQuart" value="' . getTeamForQuart(3, $db)[1] . '" hidden>';
                        echo '<input type="submit" value="✅">';
                        echo '</form>';
                    }
                    ?>
                </div>
                <div class="nom">
                    <p><?php echo getTeamForQuart(3, $db)[0] ?></p>
                </div>
            </div>
            <div class=" equipe equipe14">
                <div class="rectangle">
                    <?php
                    if ($UserStatus ==  "Admin") {
                        echo '<form action="matchmaking_desktop.php" method="post">';
                        echo '<input type="number" name="winnerQuart" value="' . getTeamForQuart(4, $db)[1] . '" hidden>';
                        echo '<input type="submit" value="✅">';
                        echo '</form>';
                    }
                    ?>
                </div>
                <div class="nom">
                    <p><?php echo getTeamForQuart(4, $db)[0] ?></p>
                </div>
            </div>
            <div class=" equipe equipe15">
                <div class="rectangle"></div>
                <div class="nom">
                    <p><?php echo getLANWinner($db) ?></p>
                </div>
            </div>

            <div class=" equipedemie equipedemie1">
                <img class="img_tableau" src="./assets/img/logo_matchmaking_tableau.svg" alt="logo MMI LAN">
                <div class="demie">
                    <p>DEMIE</p>
                </div>
            </div>

            <div class=" equipedemie equipedemie2">
                <img class="img_tableau" src="./assets/img/logo_matchmaking_tableau.svg" alt="logo MMI LAN">
                <div class="demie">
                    <p>DEMIE</p>
                </div>
            </div>

            <div class=" equipedemie equipedemie3">
                <img class="img_tableau" src="./assets/img/logo_matchmaking_tableau.svg" alt="logo MMI LAN">
                <div class="demie">
                    <p>DEMIE</p>
                </div>
            </div>

            <div class=" equipedemie equipedemie4">
                <img class="img_tableau" src="./assets/img/logo_matchmaking_tableau.svg" alt="logo MMI LAN">
                <div class="demie">
                    <p>DEMIE</p>
                </div>
            </div>

            <div class=" equipedemie equipefinale1">
                <img class="img_tableau" src="./assets/img/logo_matchmaking_tableau.svg" alt="logo MMI LAN">
                <div class="finale">
                    <p>FINALE</p>
                </div>
            </div>

            <div class=" equipedemie equipefinale2">
                <img class="img_tableau" src="./assets/img/logo_matchmaking_tableau.svg" alt="logo MMI LAN">
                <div class="finale">
                    <p>FINALE</p>
                </div>
            </div>



            <img id="logoVainqueur" src="assets/img/logo.svg" alt="logo mmi lan 2023">

            <div class="lien lien1"></div>
            <div class="lien lien2"></div>
            <div class="lien lien3"></div>
            <div class="lien lien4"></div>
            <div class="lien lien5"></div>
            <div class="lien lien6"></div>
            <div class="lien lien7"></div>
            <div class="lien lien8"></div>
            <div class="lien lien9"></div>
            <div class="lien lien10"></div>
            <div class="lien lien11"></div>
            <div class="lien lien12"></div>
        </section>
    </main>

    <?php include('footer.php'); ?>
</body>

</html>
