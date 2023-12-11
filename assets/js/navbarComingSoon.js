const planningButtons = document.querySelectorAll("#planning-button")

planningButtons.forEach((planningButton) => {
    planningButton.addEventListener("click", () => {
        planningButton.innerHTML = "Bientôt..."
        setTimeout(() => {
            planningButton.innerHTML = "Planning"
        }, 2000)
    })
})
