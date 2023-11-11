$(document).ready(function() {

    let select_jeu = $('#select_jeu');
    let participantRadio = $('#participant');
    let spectateurRadio = $('#spectateur');
    
    select_jeu.hide();

    participantRadio.change(function() {
        if (participantRadio.is(":checked")) {
            select_jeu.show();
        }
    });

    spectateurRadio.change(function() {
        if (spectateurRadio.is(":checked")) {
            select_jeu.hide();
        }
    });

});