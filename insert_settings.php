<?php
include "db_connection.php";

$conn = OpenCon();

$startTime = $endTime = "";
$timeout = $bathTimeout = 0;
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize the form inputs
    $startTime = mysqli_real_escape_string($conn, $_POST["startTime"]);
    $endTime = mysqli_real_escape_string($conn, $_POST["endTime"]);
    $bathTimeout = (int) $_POST["bathTimeout"];
    $timeout = (int) $_POST["Timeout"];

    // Check if the inputs are not empty
    if (!empty($startTime) && !empty($endTime) && $bathTimeout > 0 && $timeout > 0) {
        // Prepare and execute the SQL statement using prepared statements
        $stmt = $conn->prepare("REPLACE INTO settings (start, end, timeout_bath, timeout_default, ID) VALUES (?, ?, ?, ?, 1)");
        $stmt->bind_param("ssii", $startTime, $endTime, $bathTimeout, $timeout);

        if ($stmt->execute()) {
            $message = "Settings saved successfully!";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "Please fill in all fields with valid values.";
    }
}

$conn->close();

header("Location: settings.php?message=" . urlencode($message)); // Redirect with message in URL parameter
exit;