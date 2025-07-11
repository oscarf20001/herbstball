// displayMessages.js
let displayElementText = document.getElementById('display_textNode');
let displayContainer = document.getElementById('display');

document.addEventListener("DOMContentLoaded", (event) => {
  // gsap code here!
});

export function displayMessage(msg){
    switch (msg) {
        case 'email':
            displayElementText.textContent = 'Registrierung fehlgeschlagen: Ungültige Email';
            displayContainer.style.transform = 'translate(-50%, 0%)';
            setTimeout(() => {
                displayContainer.style.transform = 'translate(-50%, -200%)';
            },5000);
            break;

        case 'duplicate':
            displayElementText.textContent = 'Registrierung fehlgeschlagen: Doppeltes Ticket erkannt';
            displayContainer.style.transform = 'translate(-50%, 0%)';
            displayContainer.style.backgroundColor = 'var(--pureRed)';
            setTimeout(() => {
                displayContainer.style.transform = 'translate(-50%, -200%)';
            },5000);
            break;

        case 'empty':
            displayElementText.textContent = 'Registrierung fehlgeschlagen: Leeres Feld erkannt';
            displayContainer.style.transform = 'translate(-50%, 0%)';
            displayContainer.style.backgroundColor = 'var(--pureRed)';
            setTimeout(() => {
                displayContainer.style.transform = 'translate(-50%, -200%)';
            },5000);
            break;

        case 'denied':
            displayElementText.textContent = 'Weiterleitung verweigert: Seite gesperrt';
            displayContainer.style.transform = 'translate(-50%, 0%)';
            displayContainer.style.backgroundColor = 'var(--pureRed)';
            setTimeout(() => {
                displayContainer.style.transform = 'translate(-50%, -200%)';
            },5000);
            break;

        case 'success':
            displayElementText.textContent = 'Reservierung erfolgreich: Bestätige deine Tickets per E-Mail – sonst verfallen sie nach 24h.';
            displayContainer.style.backgroundColor = 'var(--successGreen)';
            displayContainer.style.transform = 'translate(-50%, 0%)';
            setTimeout(() => {
                displayContainer.style.transform = 'translate(-50%, -200%)';
            },5000);
            break;

        case 'financing_success':
            displayElementText.textContent = 'Eintragung erfolgreich!';
            displayContainer.style.backgroundColor = 'var(--successGreen)';
            displayContainer.style.transform = 'translate(-50%, 0%)';
            setTimeout(() => {
                displayContainer.style.transform = 'translate(-50%, -200%)';
            },5000);
            break;

        default:
            break;
    }
}

export function makeFaltyTicketVisible(ticketElement) {
    // Entferne vorherige Markierungen
    document.querySelectorAll('.ticket').forEach(element => {
        element.classList.remove('duplicate');
    });

    // Neue Markierung setzen
    ticketElement.classList.add('duplicate');
}