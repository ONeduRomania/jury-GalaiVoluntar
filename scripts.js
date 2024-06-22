function updateCountdown() {
    const countdownElement = document.getElementById('countdown');
    const targetDate = new Date('September 1, 2024 23:59:59').getTime();
    const now = new Date().getTime();
    const timeLeft = targetDate - now;

    const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
    const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

    countdownElement.innerHTML = `${days} zile  ${hours} ore  ${minutes} minute   ${seconds} secunde`;

    if (timeLeft < 0) {
        clearInterval(countdownInterval);
        countdownElement.innerHTML = "Terminat";
    }
}

const countdownInterval = setInterval(updateCountdown, 1000);
