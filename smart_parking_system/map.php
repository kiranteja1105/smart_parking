<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <title>Map - Smart Parking</title>
    <style>
        #map {
            height: 600px;
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
        }

        .location-list {
            margin-top: 20px;
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        .location-list h2 {
            font-size: 24px;
            color: #333;
        }

        .location-item {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .location-item b {
            color: #32CD32;
        }

        .location-item p {
            margin: 5px 0;
            color: #333;
        }

        .navigate-button, .details-button {
            display: inline-block;
            padding: 8px 12px;
            background-color: #32CD32;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
            margin-right: 10px;
        }

        .navigate-button:hover, .details-button:hover {
            background-color: #2a9c2a;
        }

        .details-content {
            display: none;
            background-color: #f0f0f0;
            padding: 10px;
            margin-top: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .location-item.active .details-content {
            display: block;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="content">
        <h1>Parking Map</h1>
        <div id="map"></div>

        <!-- Scrollable list of locations below the map -->
        <div class="location-list">
            <h2>Available Parking Locations</h2>
            <?php
            // Database connection
            include 'db.php';

            // Fetch locations and details from the database
            $query = "SELECT * FROM locations";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($location = mysqli_fetch_assoc($result)) {
                    // Display each location with details
                    echo '<div class="location-item">';
                    echo '<b>' . htmlspecialchars($location['name']) . '</b>';
                    echo '<p>Cost: ₹' . htmlspecialchars($location['cost_per_hour']) . '/hour</p>';
                    echo '<p>Available Spots: ' . htmlspecialchars($location['total_spots']) . '</p>';
                    echo '<p>Rating: ' . htmlspecialchars($location['rating']) . '/5</p>';
                    echo '<a href="https://www.google.com/maps/dir/?api=1&destination=' . htmlspecialchars($location['latitude']) . ',' . htmlspecialchars($location['longitude']) . '" target="_blank" class="navigate-button">Click to Navigate</a>';
                    echo '<button class="details-button" onclick="toggleDetails(this)">Details</button>';

                    // Additional details section
                    echo '<div class="details-content">';
                    echo '<p><strong>Types of Vehicles Allowed:</strong> ' . htmlspecialchars($location['vehicle_types']) . '</p>';
                    echo '<p><strong>Nearby Hotels:</strong> ' . htmlspecialchars($location['hotels_nearby']) . '</p>';
                    echo '<p><strong>EV Chargers:</strong> ' . ($location['ev_charger'] ? 'Yes' : 'No') . '</p>';
                    echo '<p><strong>Restrooms Available:</strong> ' . ($location['restrooms'] ? 'Yes' : 'No') . '</p>';
                    echo '<p><strong>Additional Facilities:</strong> ' . htmlspecialchars($location['facilities']) . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No locations available!</p>';
            }
            ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
    const map = L.map('map').setView([13.0827, 80.2707], 12); // Centered on Chennai

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    const locations = <?php
    // Fetch the same locations for the map markers
    $query = "SELECT name, latitude, longitude FROM locations";
    $result = mysqli_query($conn, $query);

    $location_data = [];
    while ($location = mysqli_fetch_assoc($result)) {
        $location_data[] = [
            'name' => $location['name'],
            'lat' => (float)$location['latitude'],
            'lng' => (float)$location['longitude']
        ];
    }
    echo json_encode($location_data);
    ?>;

    locations.forEach(location => {
        L.marker([location.lat, location.lng]).addTo(map)
            .bindPopup(`<b>${location.name}</b>`);
    });

    // Function to toggle visibility of details
    function toggleDetails(button) {
        const locationItem = button.closest('.location-item');
        locationItem.classList.toggle('active');
    }
    </script>

</body>
</html>
