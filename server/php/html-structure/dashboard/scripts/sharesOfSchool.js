const ctx = document.getElementById('sharesOfSchool_canvas');

const dataFromBackend = await getSharesOfSchools();

const data = {
    labels: [dataFromBackend[0].school, dataFromBackend[1].school, dataFromBackend[2].school],
    datasets: [{
        label: 'Schule',
        data: [dataFromBackend[0].anzahl,dataFromBackend[1].anzahl,dataFromBackend[2].anzahl],
        backgroundColor: [
            'rgb(54, 99, 235)',
            'rgb(235, 154, 54)',
            'rgba(102, 54, 235, 0.29)'
        ],
        hoverOffset: 4
    }]
};

const ticketbestand = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: {
        responsive: true,
        maintainAspectRatio: false, // wichtig um Verzerrung zu verhindern,
        layout: {
            padding: 16
        },
        plugins: {
            legend: {
                display: true,
                position: 'left',
                align: 'center'
            },
            tooltip: {
                enabled: true
            }
        }
    }
});

async function getSharesOfSchools(){
    const basePath = window.location.hostname.includes('localhost') ? '/Metis/herbstball_25' : '';

    try {
        const response = await fetch('../server/php/html-structure/dashboard/php/getSharesOfSchool.php');
        
        if (!response.ok) {
            throw new Error(`HTTP-Fehler: ${response.status}`);
        }

        const data = await response.json();

        return data;

    } catch (error) {
        console.error('Fehler beim Abrufen der Wochenstatistik:', error);
        return null;
    }
}