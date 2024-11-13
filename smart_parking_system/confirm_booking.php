<?php
include 'db.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $location_id = $_POST['location'];
    $hours = $_POST['hours'];

    // Validate the username (check if it exists in the users table)
    $user_query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($user_query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the cost per hour for the selected location
        $query = "SELECT cost_per_hour FROM parking_spots WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $location_id);
        $stmt->execute();
        $stmt->bind_result($cost_per_hour);
        $stmt->fetch();
        $stmt->close();

        // Calculate the total cost
        $total_price = $cost_per_hour * $hours;

        // Book the parking (Insert booking record into the `bookings` table)
        $insert_query = "INSERT INTO bookings (username, parking_spot_id, hours_booked, total_price) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("siid", $username, $location_id, $hours, $total_price);
        if ($stmt->execute()) {
            echo "Parking spot booked successfully for $username! Total price: ₹" . $total_price;
        } else {
            echo "Error booking parking spot!";
        }
        $stmt->close();
    } else {
        echo "Invalid username. Please try again.";
    }
}
?>

