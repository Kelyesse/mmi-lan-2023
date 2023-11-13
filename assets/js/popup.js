$(document).ready(function() {

    $('.remove-mate').on('click', function() {
        $('#confirmationPopup').css('display', 'flex');

        $('.confirmYes').on('click', function() {
            $('#confirmationPopup').css('display', 'none');
        });

        $('.confirmNo').on('click', function() {
            $('#confirmationPopup').css('display', 'none');
        });
    });

    $('#remove-team').on('click', function() {
        $('#popUpTeam').css('display', 'flex');

        $('.confirmYes').on('click', function() {
            $('#popUpTeam').css('display', 'none');
        });

        $('.confirmNo').on('click', function() {
            $('#popUpTeam').css('display', 'none');
        });
    });

    $('#remove-account').on('click', function() {
        $('#popUpAccount').css('display', 'flex');

        $('.confirmYes').on('click', function() {
            $('#popUpAccount').css('display', 'none');
        });

        $('.confirmNo').on('click', function() {
            $('#popUpAccount').css('display', 'none');
        });
    });

    $('#leave-team').on('click', function() {
        $('#popUpAccount').css('display', 'flex');

        $('.confirmYes').on('click', function() {
            $('#popUpAccount').css('display', 'none');
        });

        $('.confirmNo').on('click', function() {
            $('#popUpAccount').css('display', 'none');
        });
    });

});
