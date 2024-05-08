<?php

#enusre user has access to this page
session_start();

if ($_SESSION['type'] != '1') {
    header("Location: home.php");
    exit();
}


#get current settings from database
include "db_connection.php";

$conn = OpenCon();

$sqlQuery = "SELECT * FROM settings WHERE ID='1'";

$result = mysqli_query($conn, $sqlQuery);
$data = $result->fetch_all(MYSQLI_ASSOC);
mysqli_close($conn);

$message = isset($_GET['message']) ? $_GET['message'] : ''; // Get message from URL parameter
?>

<!DOCTYPE html>

<html>

<head>
    <title>SETTINGS</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h3>SETTINGS</h3>
    <?php if (!empty($message))
        echo "<p>$message</p>"; ?>

    <form method="POST" action="insert_settings.php">
        <label for="startTime">Start time: </label>
        <input type="time" name="startTime" value="<?php echo $data[0]['start'] ?>" /> <br>
        <label for="endTime">End time: </label>
        <input type="time" name="endTime" value="<?php echo $data[0]['end'] ?>" /> <br>
        <label for="bathTimeout">Bathroom timeout: </label>
        <input type="number" name="bathTimeout" value="<?php echo $data[0]['timeout_bath'] ?>" min="0" max="9999" />
        <br>
        <label for="notInBedTimeout">Citizen not in bed timeout: </label>
        <input type="number" name="notInBedTimeout" value="<?php echo $data[0]['timeout_not_in_bed'] ?>" min="0"
            max="9999" /> <br>
        <label for="Timeout">Other timeout: </label>
        <input type="number" name="Timeout" value="<?php echo $data[0]['timeout_default'] ?>" min="0" max="9999" /> <br>

        <input type="submit" value="Save" />
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($message)) {
        echo "<p>$message</p>";
    } ?>

</body>

</html>