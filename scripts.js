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

function openPopup(message) {
    var popup = document.createElement('div');
    popup.classList.add('popup');
    popup.innerHTML = `
        <p>${message}</p>
        <button onclick="closePopup()">Închide</button>
    `;

    document.body.appendChild(popup);

    var overlay = document.createElement('div');
    overlay.classList.add('overlay');
    overlay.addEventListener('click', closePopup);
    document.body.appendChild(overlay);
}

function closePopup() {
    var popup = document.querySelector('.popup');
    var overlay = document.querySelector('.overlay');

    if (popup && overlay) {
        popup.remove();
        overlay.remove();
    }
}
function submitForm(event) {
    event.preventDefault();
    openPopup('Am primit înscrierea ta. Vom reveni cu un răspuns către tine între 1-10 sept. 2024');
}


