<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail équipe 
        <?php 
        $teamId = $_GET['teamId'];
        require_once("connexionbdd.php");
        $teamName = $db->prepare("SELECT TeamName FROM team WHERE TeamId=?");
        $teamName->execute([$teamId]);
        $nomequipe = $teamName->fetch()['TeamName'];
        echo $nomequipe;
        ?>
    </title>
</head>
<body>
    <?php 
        require_once("connexionbdd.php");
        //--- Partie où on affiche les infos de l'équipe en général ---
        $equipe = $db->prepare("SELECT TeamLogo, TeamDesc FROM team WHERE TeamId=?");
        $equipe->execute([$teamId]);
        $equipe = $equipe->fetch();
        $logoequipe = $equipe[0];
        $descequipe = $equipe[1];
        echo '<div id="equipe">';
        echo "<h1>".$nomequipe."</h1>";
        echo '<img src="data:image/png;base64,'.base64_encode($logoequipe).'"/>';
        echo '<p>'.$descequipe.'</p>';
        echo '</div>';

        //--- Partie où on affiche les infos de chaque membre de l'équipe ---
        $membres = $db->prepare("SELECT PlayerId FROM belong WHERE TeamId=?");
        $membres->execute([$teamId]);
        echo '<div id="membres" style="display : flex; gap : 2rem;">';
        $nbMembres = 0;
        while($donnees = $membres->fetch()){
            echo '<div class="membre">';
            $membre = $db->prepare("SELECT PlayerLastname, PlayerFirstname, PlayerPseudo, PlayerPicture, PlayerFavGame FROM player WHERE PlayerId=?");
            $membre->execute([$donnees['PlayerId']]);
            $membre = $membre->fetch();
            $nommembre = $membre[0];
            $prénommembre = $membre[1];
            $pseudomembre = $membre[2];
            $imagemembre = $membre[3];
            $jeufavmembre = $membre[4];
            echo '<img src="data:image/png;base64,'.base64_encode($imagemembre).'"/>';
            echo '<h2>'.$pseudomembre.'</h2>';
            echo '<p>'.$jeufavmembre.'</p>';
            echo '<p>'.$prénommembre." ".$nommembre." alias ".$pseudomembre.'</p>';
            echo '</div>';
            $nbMembres++;
        }

        //--- Partie où on affiche des cases vides en cas d'équipe incomplète ---
        while($nbMembres<3){
            echo '<div class="vide">';
            echo '<h2>Cette équipe est incomplète</h2>';
            echo "<button>Rejoindre l'équipe</button>";
            echo '</div>';
            $nbMembres++;
        }
        echo '</div>';

        //--- Partie pour naviguer entre les équipes ou pour revenir au listing des équipes ---
        echo '<div id="retour">';
        $nbEquipe =  $db->prepare("SELECT MAX(TeamId) FROM team");
        $nbEquipe->execute();
        $nbEquipe = $nbEquipe->fetch()[0];
        if($teamId > 1){
            echo '<a href="détailEquipe.php?teamId='.($teamId-1).'">⬅️</a>';
        }
        else{
            echo '<a href="détailEquipe.php?teamId='.$nbEquipe.'">⬅️</a>';
        }
        echo ' <a href="equipe[fichier_test].php">Retour au listing des équipes</a> ';
        if($teamId < $nbEquipe){
            echo '<a href="détailEquipe.php?teamId='.($teamId+1).'">➡️</a>';
        }
        else{
            echo '<a href="détailEquipe.php?teamId=1">➡️</a>';
        }
        echo '</div>';
    ?>
</body>
</html>