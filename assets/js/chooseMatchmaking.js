btnMM = document.getElementById('voirMM');

if(screen.width > 700){
    btnMM.addEventListener("click", function(){
        window.location.href = "matchmaking_desktop.php";
    });
}
else{
    btnMM.addEventListener("click", function(){
        window.location.href = "matchmaking_mobile.php";
    });
}