const covoitButtons = document.querySelectorAll("#covoit-button")
const planningButtons = document.querySelectorAll("#planning-button")

covoitButtons.forEach((covoitButton) => {
    covoitButton.addEventListener("click", () => {
        covoitButton.innerHTML = "Bientôt..."
        setTimeout(() => {
            covoitButton.innerHTML = "Covoiturage"
        }, 2000)
    })
})

planningButtons.forEach((planningButton) => {
    planningButton.addEventListener("click", () => {
        planningButton.innerHTML = "Bientôt..."
        setTimeout(() => {
            planningButton.innerHTML = "Covoiturage"
        }, 2000)
    })
})
