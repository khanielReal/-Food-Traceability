document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById('productionChart').getContext('2d');
    
    var productionData = <?php echo json_encode($analytics_data); ?>; // PHP data injected here
    
    var productionChart = new Chart(ctx, {
        type: 'bar',  // Change chart type as needed (pie, line, etc.)
        data: {
            labels: ['Farm 1', 'Farm 2', 'Farm 3', 'Farm 4'], // Example labels, modify as needed
            datasets: [{
                label: 'Production Progress',
                data: productionData, // Data from PHP
                backgroundColor: '#4CAF50',
                borderColor: '#4CAF50',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        });
});
