const ctx = document.getElementById('todaySold_canvas');
ctx.width = 250;
ctx.height = 150;

const ticketsToday = await howManyTicketsToday(); // dynamisch setzen – z. B. aus PHP übergeben
const targetTickets = 3;

new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [''],
      datasets: [{
        label: 'Verkäufe heute',
        data: [ticketsToday],
        backgroundColor: ticketsToday >= targetTickets ? '#22e36f' : '#e3224f'
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
          suggestedMax: Math.max(5, targetTickets + 2),
          ticks: {
            stepSize: 1
          }
        }
      },
      layout: {
        padding: 16
      },
      plugins: {
        legend: {
          display: false
        },
        annotation: {
          annotations: {
            targetLine: {
              type: 'line',
              yMin: targetTickets,
              yMax: targetTickets,
              borderColor: 'blue',
              borderWidth: 2,
              label: {
                enabled: true,
                content: 'Ziel: 3 Tickets',
                position: 'end',
                backgroundColor: 'blue',
                color: 'white'
              }
            }
          }
        }
      }
    }
});

async function howManyTicketsToday() {
  try {
    const response = await fetch('dashboard/php/howManyTicketsToday.php');
    
    if (!response.ok) {
      throw new Error(`HTTP-Fehler: ${response.status}`);
    }

    const data = await response.json();

    // Wenn dein PHP-Code z. B. so etwas zurückgibt: echo json_encode(['count' => $count]);
    return data.count;

  } catch (error) {
    console.error('Fehler beim Abrufen der Anzahl:', error);
    return null;
  }
}