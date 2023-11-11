$(document).ready(function() {
    var joueur_deux = $('#joueur_deux');
    var joueur_un = $('#joueur_un');

    joueur_deux.hide();

    joueur_un.change(function(){
        joueur_deux.show();
    });
});
