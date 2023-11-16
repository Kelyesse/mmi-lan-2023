const isRadioChecked = () => {
    return $("#participant").is(":checked")
}
$(document).ready(function () {
    let select_jeu = $("#select_jeu")
    let participantRadio = $("#participant")
    let spectateurRadio = $("#conducteur")
    let setupRadioGroup = $(".radio.setup")
    let submitButton = $("#submit")
    select_jeu.hide()
    setupRadioGroup.hide()

    participantRadio.change(function () {
        if (participantRadio.is(":checked")) {
            select_jeu.show()
            setupRadioGroup.show()
            submitButton.css("background-color", "#febc11")
        }
    })
    // Nécessaire si en arrivant sur la page (ex: reload car erreur dans le form)
    // Le bouton était check auparavant
    if (isRadioChecked()) {
        $("#participant").trigger("change")
    }

    spectateurRadio.change(function () {
        if (spectateurRadio.is(":checked")) {
            select_jeu.hide()
            setupRadioGroup.hide()
            submitButton.css("background-color", "#2F1D62")
        }
    })
})
