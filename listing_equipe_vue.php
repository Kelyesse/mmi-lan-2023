<?php 
 foreach ($equipesAvecJoueurs as $equipe) : ?>
    <a href="#/<?= $equipe['TeamId'] ?>"><?= $equipe['TeamName'] ?></a>
    <ul>
        <?php foreach ($equipe['PlayerPseudo'] as $joueur) : ?>
            <li><?= $joueur['PlayerPseudo'] ?></li>
        <?php endforeach; ?>
    </ul>
<?php endforeach; ?>

