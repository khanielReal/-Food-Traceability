// Chart.js Configuration

// Production Analytics Chart
const ctx1 = document.getElementById('productionChart').getContext('2d');
new Chart(ctx1, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'Production (kg)',
            data: [50, 70, 100, 120, 90, 150],
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});

// Revenue Pie Chart
const ctx2 = document.getElementById('revenuePieChart').getContext('2d');
new Chart(ctx2, {
    type: 'pie',
    data: {
        labels: ['Direct Sales', 'Logistics', 'Suppliers'],
        datasets: [{
            label: 'Revenue',
            data: [3000, 2000, 1500],
            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
        }]
    },
    options: {
        responsive: true
    }
});

// Monthly Growth Bar Chart
const ctx3 = document.getElementById('growthBarChart').getContext('2d');
new Chart(ctx3, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'Growth (%)',
            data: [5, 10, 15, 20, 25, 30],
            backgroundColor: 'rgba(153, 102, 255, 0.2)',
            borderColor: 'rgba(153, 102, 255, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
