const countDownDate = new Date("Dec 14, 2023 08:00:00").getTime();
const countdownElement = document.getElementById("count-down-timer");

function updateCountdown() {
  const now = new Date().getTime();
  let distance = countDownDate - now;

  if (distance < 0) {
    clearInterval(countdownInterval);
    countdownElement.innerHTML = "EXPIRED";
  } else {
    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    distance %= 1000 * 60 * 60 * 24;

    const hours = Math.floor(distance / (1000 * 60 * 60));
    distance %= 1000 * 60 * 60;

    const minutes = Math.floor(distance / (1000 * 60));
    distance %= 1000 * 60;

    const seconds = Math.floor(distance / 1000);

    countdownElement.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
  }
}

const countdownInterval = setInterval(updateCountdown, 1000);
updateCountdown();
