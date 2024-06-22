function updateCountdown() {
    const countdownElement = document.getElementById('countdown');
    const targetDate = new Date('September 1, 2024 23:59:59').getTime();
    const now = new Date().getTime();
    const timeLeft = targetDate - now;

    const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
    const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

    countdownElement.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;

    if (timeLeft < 0) {
        clearInterval(countdownInterval);
        countdownElement.innerHTML = "Terminat";
    }
}

const countdownInterval = setInterval(updateCountdown, 1000);

function openPopup() {
    alert("Eligibilitatea: Termenul de voluntariat nu le este necunoscut (activează sau au activat într-un ONG în ultimii 5 ani). Au avut o activitate de minim 3 luni de voluntariat în domeniul vizat de categoria aleasă. Sunt disponibili pentru training și pentru jurizare în perioada oct. - noi. 2024. Jurizarea se desfășoară individual, online, printr-o platformă securizată a Asociației ONedu. Se angajează să asigure confidențialitatea aplicațiilor și a punctajelor acordate și vor semna acorduri de confidențialitate în acest sens.");
}
