document.addEventListener("DOMContentLoaded", function() {
    // Total Production Chart
    var ctx1 = document.getElementById('productionChart').getContext('2d');
    var productionData = <?php echo json_encode($production); ?>;
    
    var productionChart = new Chart(ctx1, {
        type: 'line',  // Change chart type as needed (pie, line, etc.)
        data: {
            labels: <?php echo json_encode($years); ?>,
            datasets: [{
                label: 'Total Production',
                data: productionData, 
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Year'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Production (kg)'
                    }
                }
            }
        }
    });

    // Revenue Chart
    var ctx2 = document.getElementById('revenueChart').getContext('2d');
    var revenueData = <?php echo json_encode($revenue); ?>;

    var revenueChart = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($years); ?>,
            datasets: [{
                label: 'Revenue',
                data: revenueData,
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Year'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Revenue ($)'
                    }
                }
            }
        }
    });

    // Pie Chart (Example, adjust as necessary)
    var ctx3 = document.getElementById('pieChart').getContext('2d');
    var pieData = [300, 50, 100, 150];
    
    var pieChart = new Chart(ctx3, {
        type: 'pie',
        data: {
            labels: ['Farm 1', 'Farm 2', 'Farm 3', 'Farm 4'],
            datasets: [{
                data: pieData,
                backgroundColor: ['#FF5733', '#33FF57', '#3357FF', '#FF33A6'],
                borderColor: '#fff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });
});
