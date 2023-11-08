<?php

class EquipeController {
    public function listEquipes() {
        require 'listing_equipe_model.php';
        $equipeModel = new Team();
        $equipes = $equipeModel->getEquipes();
        
        foreach ($equipes as $equipe) {
            $joueurModel = new Joueur();
            $joueurs = $joueurModel->getJoueursByEquipe($equipe['TeamId']);
            $equipe['PlayerPseudo'] = $joueurs;
            $equipesAvecJoueurs[] = $equipe;
        }
        
        require 'listing_equipe_vue.php';
    }
}

?>