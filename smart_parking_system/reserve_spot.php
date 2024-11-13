<?php
include 'db.php'; // Include your database connection file
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Please log in to book a parking spot!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $spot_id = $_POST['spot_id'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Calculate hours and cost
    $start = strtotime($start_time);
    $end = strtotime($end_time);
    $hours = ($end - $start) / 3600;

    // Fetch the cost per hour
    $query = "SELECT cost_per_hour FROM parking_spots WHERE id = $spot_id";
    $result = mysqli_query($conn, $query);
    $spot = mysqli_fetch_assoc($result);
    $cost_per_hour = $spot['cost_per_hour'];
    $total_cost = $hours * $cost_per_hour;

    // Insert reservation into the reservations table
    $query = "INSERT INTO reservations (user_id, spot_id, reservation_start, reservation_end, total_cost)
              VALUES ($user_id, $spot_id, '$start_time', '$end_time', $total_cost)";
    
    if (mysqli_query($conn, $query)) {
        // Mark the spot as no longer available
        $update_query = "UPDATE parking_spots SET is_available = FALSE WHERE id = $spot_id";
        mysqli_query($conn, $update_query);

        echo "Reservation successful! Total cost: $" . $total_cost;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
