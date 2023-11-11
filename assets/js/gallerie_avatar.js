$(document).ready(function() {
    let prem_img = $('.prem');
    let sec_img = $('.sec');
    let avatarOptions = $('.avatar-option');
    let avatarInput = $('#avatar');

    sec_img.hide();


    $('#next').click(function(){
        prem_img.hide();
        sec_img.show();
    });

    $('#pre').click(function(){
        sec_img.hide();
        prem_img.show();
    });


        avatarOptions.on('click', function() {
            avatarOptions.removeClass('active');
            $(this).addClass('active');

            var selectedAvatarSrc = $(this).find('img').attr('src');
            avatarInput.val(selectedAvatarSrc);

            console.log(avatarInput.val());
        });


});
