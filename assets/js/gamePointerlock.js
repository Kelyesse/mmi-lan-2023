// Récupérer la référence de l'élément canvas WebGL
var canvas = document.getElementById("unity-container");

const zoneInputPseudo = document.getElementById("pseudo-zone");

// Gérer l'événement clic pour demander le verrouillage du curseur
canvas.addEventListener("click", function() {
    if(zoneInputPseudo.style.display === 'none' || zoneInputPseudo.style.display === ''){
        canvas.requestPointerLock = canvas.requestPointerLock || canvas.mozRequestPointerLock || canvas.webkitRequestPointerLock;
        canvas.requestPointerLock();
    }
    console.log(zoneInputPseudo.style.display)
}, false);

var observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation){
        if(mutation.attributeName === 'style') {
            var displayValue = zoneInputPseudo.style.display;
            if(displayValue === 'flex'){
                document.exitPointerLock();
            }
        }
    });
});

var config = { attributes: true, attributeFilter: ['style'] };

observer.observe(zoneInputPseudo, config);