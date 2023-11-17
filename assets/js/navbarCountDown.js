const navbarCountDownDate = new Date("Dec 14, 2023 08:00:00").getTime()
const navbarCountdownElements = document.querySelectorAll(".count-down-timer")
const HOMEPAGE = "https://mmilan-toulon.fr/"
let currentUrl = window.location.href
// If we're on homepage, no countdown
if (
    currentUrl.endsWith(HOMEPAGE) ||
    currentUrl.endsWith(`${HOMEPAGE}#`) ||
    currentUrl.endsWith(`${HOMEPAGE}index.php`)
) {
    navbarCountdownElements.forEach((countDown) => countDown.remove())
}
function updateCountdown() {
    const now = new Date().getTime()
    let distance = navbarCountDownDate - now

    let displayText
    if (distance < 0) {
        displayText = "L'événement est en cours !"
    } else {
        const days = Math.floor(distance / (1000 * 60 * 60 * 24))
        distance %= 1000 * 60 * 60 * 24

        const hours = Math.floor(distance / (1000 * 60 * 60))
        distance %= 1000 * 60 * 60

        const minutes = Math.floor(distance / (1000 * 60))
        distance %= 1000 * 60

        const seconds = Math.floor(distance / 1000)

        displayText = `<span class="numbers">${days}</span><span class="letters">j</span> <span class="numbers">${hours}</span><span class="letters">h</span> <span class="numbers">${minutes}</span><span class="letters">m</span> <span class="numbers">${seconds}</span><span class="letters">s</span>`
    }

    navbarCountdownElements.forEach((elem) => {
        elem.innerHTML = displayText
    })
}

const navbarCountdownInterval = setInterval(updateCountdown, 1000)
updateCountdown()
