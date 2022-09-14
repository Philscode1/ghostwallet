    // Linechart show.blade
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartTimes,
            datasets: [{
                label: assetName,
                data:  chartPrices,
                backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                
                ],
                borderColor: [
                'rgba(255, 99, 132, 1)',
                
                ],
                borderWidth: 2
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    grid: {
                        display: true,
                        color: "#232323"
                    },
                    beginAtZero: false,
                    ticks: {
                        precision: 2,
                        callback: function(value, index, ticks) {
                            return '$' + value;
                        },
                    }
                },
                x: {
                    grid: {
                        display: true,
                        color: "#232323"
                    },
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 10
                    },
                },
            },
            elements: {
                point:{
                    radius: 0
                }
            }
        }
    });