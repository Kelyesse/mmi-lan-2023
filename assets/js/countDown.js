const countDownDate = new Date("Dec 14, 2023 08:00:00").getTime();
const countdownElements = document.querySelectorAll(".count-down-timer");

function updateCountdown() {
  const now = new Date().getTime();
  let distance = countDownDate - now;

  let displayText;
  if (distance < 0) {
    displayText = "L'événement est en cours !";
  } else {
    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    distance %= 1000 * 60 * 60 * 24;

    const hours = Math.floor(distance / (1000 * 60 * 60));
    distance %= 1000 * 60 * 60;

    const minutes = Math.floor(distance / (1000 * 60));
    distance %= 1000 * 60;

    const seconds = Math.floor(distance / 1000);

    displayText = `<span class="numbers">${days}</span><span class="letters">d</span> <span class="numbers">${hours}</span><span class="letters">h</span> <span class="numbers">${minutes}</span><span class="letters">m</span> <span class="numbers">${seconds}</span><span class="letters">s</span>`;
  }

  countdownElements.forEach((elem) => {
    elem.innerHTML = displayText;
  });
}

const countdownInterval = setInterval(updateCountdown, 1000);
updateCountdown();
