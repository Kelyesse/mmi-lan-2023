const planningButtons = document.querySelectorAll("#planning-button")
const playButtons = document.querySelectorAll("#play_button")

planningButtons.forEach((planningButton) => {
    planningButton.addEventListener("click", () => {
        planningButton.innerHTML = "Bientôt..."
        setTimeout(() => {
            planningButton.innerHTML = "Planning"
        }, 2000)
    })
})

playButtons.forEach((playButtons) => {
    playButtons.addEventListener("click", () => {
        playButtons.innerHTML = "Bientôt..."
        setTimeout(() => {
            playButtons.innerHTML = "Jouer à Shard'Venture"
        }, 2000)
    })
})
