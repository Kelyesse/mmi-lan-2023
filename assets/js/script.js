$(document).ready(function() {
    var prem_img = $('.prem');
    var sec_img = $('.sec');
    var select_jeu = $('#select_jeu');
    var participantRadio = $('#participant');
    var spectateurRadio = $('#spectateur');
    var avatarOptions = $('.avatar-option');
    var avatarInput = $('#avatar');

    sec_img.hide();
    select_jeu.hide();

//action en fonction du role

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

//gallerie fais rapidement, j'y reviendrais

    $('#next').click(function(){
        prem_img.hide();
        sec_img.show();
    });

    $('#pre').click(function(){
        sec_img.hide();
        prem_img.show();
    });

//choix avatar

        avatarOptions.on('click', function() {
            avatarOptions.removeClass('active');
            $(this).addClass('active');

            var selectedAvatarSrc = $(this).find('img').attr('src');
            avatarInput.val(selectedAvatarSrc);

            console.log(avatarInput.val());
        });


});
