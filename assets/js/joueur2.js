$(document).ready(function() {
    var player_two = $('#player-two');
    var player_one = $('#player-one');

    player_two.hide();

    player_one.change(function(){
        player_two.show();
    });
});
