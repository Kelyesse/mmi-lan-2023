<?php

class EquipeController {
    public function listEquipes() {
        require 'listing_equipe_model.php';
        $equipeModel = new team();
        $equipes = $equipeModel->getEquipes();
        
        foreach ($equipes as $equipe) {
            $joueurModel = new Joueur();
            $joueurs = $joueurModel->getJoueursByEquipe($equipe['TeamId']);
            $equipe['joueurs'] = $joueurs;
            $equipesAvecJoueurs[] = $equipe;
        }
        
        require 'listing_equipe_vue.php';
    }
}

?>