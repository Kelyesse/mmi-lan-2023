<?php
require 'listing_equipe_model.php';
class EquipeController {
    public function listEquipes() {
        $equipeModel = new team();
        $equipes = $equipeModel->getEquipes();
        
        foreach ($equipes as $equipe) {
            $joueurModel = new Joueur();
            $joueurs = $joueurModel->getJoueursByEquipe($equipe['TeamId']);
            $equipe['joueurs'] = $joueurs;
            $equipesAvecJoueurs[] = $equipe;
        }
        
        // Appeler la vue pour afficher les données
        require 'vue/listeEquipes.php';
    }
}

?>