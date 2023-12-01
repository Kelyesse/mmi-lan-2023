const twitchPlayerDiv = document.querySelector(".twitch-embed")
// loading Twitch Player after DOM Content for better UX
// and quicker index.php loading
window.addEventListener("DOMContentLoaded", () => {
    const options = {
        width: "100%",
        height: "100%",
        channel: "mmi_lan",
    }
    const player = new Twitch.Player(twitchPlayerDiv, options)
})
