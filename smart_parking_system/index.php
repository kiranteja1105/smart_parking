
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Smart Parking System - Home</title>
    <style>
        /* Content container */
        .content {
            text-align: center;
            margin-top: 100px;
        }

        /* Headings */
        h1 {
            font-size: 36px;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            color: #555;
            margin-bottom: 40px;
        }

        /* Button styles */
        .btn {
            display: inline-block;
            padding: 12px 25px;
            margin: 10px;
            background-color: #32CD32; /* Green button color */
            color: white;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn:hover {
            background-color: #28a428; /* Darker green on hover */
            transform: translateY(-3px); /* Lift the button on hover */
        }

        /* Chart container */
        .chart-container {
            width: 80%; /* Responsive width */
            max-width: 800px; /* Max width for larger screens */
            margin: 40px auto; /* Center the chart */
        }

        canvas {
            width: 100% !important; /* Ensure canvas takes full width */
            height: 400px !important; /* Fixed height for the chart */
        }

        /* Extra responsiveness */
        @media (max-width: 768px) {
            h1 {
                font-size: 28px;
            }

            p {
                font-size: 16px;
            }

            .btn {
                padding: 10px 20px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="content">
        <h1>Welcome to the Smart Parking System</h1>
        <p>Your one-stop solution for finding and reserving parking spots!</p>
        <p>Explore the map to find available parking spots.</p>
        <a href="map.php" class="btn">View Parking Map</a>
        <a href="book.php" class="btn">Book a Parking Spot</a>

        <!-- Chart Container -->
        <div class="chart-container">
            <canvas id="trafficChart"></canvas>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        const ctx = document.getElementById('trafficChart').getContext('2d');
        const trafficChart = new Chart(ctx, {
            type: 'line', // Using a line chart for clearer trends
            data: {
                labels: ['0 Vehicles', '1 Vehicle', '2 Vehicles', '3 Vehicles', '4 Vehicles'],
                datasets: [
                    {
                        label: 'Cars',
                        data: [0, 5, 10, 15, 20],
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2
                    },
                    {
                        label: 'Trucks',
                        data: [0, 10, 20, 30, 40],
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2
                    },
                    {
                        label: 'Motorcycles',
                        data: [0, 3, 5, 7, 10],
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2
                    },
                    {
                        label: 'Buses',
                        data: [0, 15, 25, 35, 50],
                        borderColor: 'rgba(153, 102, 255, 1)',
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Traffic Congestion Index (Lower is Better)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Number of Roadside Parked Vehicles'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.dataset.label + ': ' + tooltipItem.raw + ' (Higher is Worse)';
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
