import { displayMessage } from "./displayMessages.js";

const btn = document.getElementById('getAllTicketsForCustomerButton');
const form = document.getElementById('form');

// Haupt-Button für Ticketabfrage
btn.addEventListener('click', () => {
    const input = document.getElementById('f-email');

    if (!input.value.trim()) {
        console.log("Input-Feld leer");
        return;
    }

    if (btn.classList.contains('inactive')) {
        console.log("Button gesperrt!");
        return;
    }

    fetchAndRender(input.value.trim());
});

// Zum Aktivieren von Buttons
export function setBtnAsActive(btn) {
    btn.classList.remove('inactive');
    btn.classList.add('active');
}

// --------------------------------------------------
// Hauptfunktion zum Abrufen und Rendern der Tabellen
// --------------------------------------------------
function fetchAndRender(email) {
    fetch('../server/php/getAllTickets.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Serverantwort:', data);
        renderTables(data, email);
    })
    .catch(error => {
        console.error('Fehler beim Senden:', error);
    });
}

// --------------------------------------------------
// Tabellen rendern + Finanzierungsteil einfügen
// --------------------------------------------------
function renderTables(data, email) {
    form.reset();

    const container = document.getElementById('displayAllTicketsContainer');
    container.style.display = 'block';
    container.innerHTML = ''; // Vorherigen Inhalt löschen

    const buyer = data.kaeufer[0];

    const buyerTable = `
        <div class="table_component_käufer table_component" role="region" tabindex="0">
            <table>
                <caption>Käufer</caption>
                <thead>
                    <tr>
                        <th>Person-ID</th>
                        <th>Vorname</th>
                        <th>Nachname</th>
                        <th>Tickets</th>
                        <th>Zu Bezahlen</th>
                        <th>Gezahlt</th>
                        <th>Offen</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>${buyer.id}</td>
                        <td>${buyer.vorname}</td>
                        <td>${buyer.nachname}</td>
                        <td>${buyer.tickets}</td>
                        <td>${parseFloat(buyer.charges).toFixed(2)}</td>
                        <td>${parseFloat(buyer.paid_charges).toFixed(2)}</td>
                        <td>${parseFloat(buyer.open_charges).toFixed(2)}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    `;

    const personRows = data.persons.map(p => `
        <tr>
            <td>${p.id}</td>
            <td>${p.vorname}</td>
            <td>${p.nachname}</td>
            <td>${p.email}</td>
            <td>${p.age}</td>
            <td>${p.school}</td>
            <td>${parseFloat(p.sum).toFixed(2)}</td>
        </tr>
    `).join('');

    const personsTable = `
        <div class="table_component_tickets table_component" role="region" tabindex="0">
            <table>
                <caption>Tickets</caption>
                <thead>
                    <tr>
                        <th>Person-ID</th>
                        <th>Vorname</th>
                        <th>Nachname</th>
                        <th>Email</th>
                        <th>Alter</th>
                        <th>Schule</th>
                        <th>Kosten</th>
                    </tr>
                </thead>
                <tbody>
                    ${personRows}
                </tbody>
            </table>
        </div>
    `;

    const financingForm = `
        <div id="setFinancing">
            <form id="financing" method="POST">
                <div id="money-form-left">
                    <div class="input-field money">
                        <input type="number" min="0" step="0.01" id="receivedMoney" name="money" required>
                        <label for="receivedMoney">Empfangenes Geld in €:</label>
                    </div>
                    <select name="method" id="pay-method">
                        <option value="-" disabled selected>Bitte auswählen</option>
                        <option value="PayPal">PayPal</option>
                        <option value="Überweisung">Überweisung</option>
                        <option value="Bar">Bar</option>
                        <option value="Abendkasse" disabled>Abendkasse</option>
                    </select>
                </div>
                <div id="money-form-right">
                    <input type="button" value="Eintragen" id="set-money-btn">
                </div>
            </form>
        </div>
    `;

    container.innerHTML = buyerTable + personsTable + financingForm;

    // Finanzierung Button aktivieren
    document.getElementById('set-money-btn').addEventListener('click', () => {
        handleFinancing(data.kaeufer[0].id, email);
    });
}

// --------------------------------------------------
// Finanzierung prüfen & senden
// --------------------------------------------------
function handleFinancing(personID, email) {
    const moneyInput = document.getElementById('receivedMoney');
    const methodSelect = document.getElementById('pay-method');

    let rawValue = moneyInput.value.trim().replace(',', '.');
    const money = parseFloat(rawValue);

    if (isNaN(money) || money <= 0) {
        alert("Bitte gültigen Betrag eingeben.");
        return;
    }

    const method = methodSelect.value;
    if (method === '-') {
        alert("Bitte Zahlungsmethode auswählen.");
        return;
    }

    const payload = {
        ID: personID,
        Methode: method,
        Geld: money.toFixed(2)
    };

    fetch('../server/php/sendMoneyIntoDatabase.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            clearForm(document.getElementById('financing'));
            displayMessage('financing_success');
            fetchAndRender(email); // Tabelle aktualisieren
        } else {
            alert("Eintrag fehlgeschlagen.");
        }
    })
    .catch(error => {
        console.error("Fehler beim Eintrag:", error);
    });
}

// --------------------------------------------------
// Formular zurücksetzen
// --------------------------------------------------
function clearForm(formElement) {
    formElement.reset();
}