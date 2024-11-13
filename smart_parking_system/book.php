<?php
include 'header.php'; 
include 'db.php'; // Database connection

$query = "SELECT * FROM parking_spots WHERE is_available = TRUE";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo "<div style='padding: 30px; background: #1e1e1e; margin: 20px auto; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3); max-width: 800px;'>";  // Add a container for styling
    echo "<h1 style='font-size: 24px; margin-bottom: 20px; color: #32CD32;'>Book Your Parking Spot</h1>";
    echo "<form id='bookingForm' method='POST' action='confirm_booking.php' style='max-width: 500px; margin: 20px auto; padding: 20px; background-color: #1e1e1e; border: 1px solid #32CD32; border-radius: 10px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);'>";

    // Add username input field
    echo "<label for='username' style='color: #d1d1d1;'>Username:</label>";
    echo "<input type='text' id='username' name='username' required style='margin-bottom: 15px; padding: 10px; border: 1px solid #32CD32; border-radius: 5px; background-color: #121212; color: #d1d1d1; width: 100%;'><br><br>";

    echo "<label for='location' style='color: #d1d1d1;'>Select Parking Location:</label>";
    echo "<select name='location' id='location' required style='margin-bottom: 15px; padding: 10px; border: 1px solid #32CD32; border-radius: 5px; background-color: #121212; color: #d1d1d1; width: 100%;'>";
    while ($spot = mysqli_fetch_assoc($result)) {
        echo "<option value='" . $spot['id'] . "' data-cost='" . $spot['cost_per_hour'] . "'>" . $spot['location'] . " - ₹" . $spot['cost_per_hour'] . "/hr</option>";
    }
    echo "</select><br><br>";

    // Add hour selection
    echo "<label for='hours' style='color: #d1d1d1;'>Select Hours:</label>";
    echo "<input type='number' id='hours' name='hours' value='1' min='1' max='24' required style='margin-bottom: 15px; padding: 10px; border: 1px solid #32CD32; border-radius: 5px; background-color: #121212; color: #d1d1d1; width: 100%;'><br><br>";

    // Display the total cost (calculated via JavaScript)
    echo "<label style='color: #d1d1d1;'>Total Price: ₹<span id='totalPrice'>0</span></label><br><br>";

    echo "<button type='submit' class='btn' style='padding: 10px; background-color: #32CD32; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; transition: background-color 0.3s ease;'>Book Now</button>";
    echo "</form>";
    echo "</div>";  // Close content div
} else {
    echo "<div style='padding: 30px; background: #1e1e1e; margin: 20px auto; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3); max-width: 800px;'><h1 style='font-size: 24px; color: #32CD32;'>No available parking spots!</h1></div>";
}

include 'footer.php';
?>

<script>
    // JavaScript to update price based on hours and location selection
    document.getElementById('location').addEventListener('change', calculatePrice);
    document.getElementById('hours').addEventListener('input', calculatePrice);

    function calculatePrice() {
        const selectedLocation = document.getElementById('location');
        const costPerHour = selectedLocation.options[selectedLocation.selectedIndex].getAttribute('data-cost');
        const hours = document.getElementById('hours').value;

        const totalPrice = costPerHour * hours;
        document.getElementById('totalPrice').innerText = totalPrice;
    }

    // Initial price calculation
    calculatePrice();
</script>
