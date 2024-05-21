<?php
header('Content-Type: application/json');

include "db_connection.php";

$conn = OpenCon();
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$rooms = array("BEDROOM", "LIVINGROOM", "KITCHEN", "GUESTROOM", "BATHROOM");

for ($x = 0; $x <= 100; $x++) {
    $rand = rand();
    $room = $rooms[$rand % count($rooms)];
    $day = $rand % 30 + 1;
    if ($day < 10) {
        $day = "0" . $day;
    }
    $month = $rand % 12 + 1;
    if ($month < 10) {
        $month = "0" . $month;
    }
    $hour = $rand % 24;
    $minute = $rand % 60;
    $second = $rand % 60;
    $m = ($rand % 56) + 5;  // Measurement between 5 and 60 seconds

    // Select "ToiletDuration" if the room is "BATHROOM", otherwise select "movement"
    if ($room == "BATHROOM") {
        $type = "ToiletDuration";
    } else {
        $type = "movement";
    }

    $sqlquery = "INSERT INTO `event` (`timestamp_`, `loglevel`, `type_`, `device_id`, `device_type`, `measurement`) VALUES
    ('2024-$month-$day $hour:$minute:$second', 'Informational', '$type', '$room', 'PIR', '$m')";

    if (!mysqli_query($conn, $sqlquery)) {
        echo "Error: " . $sqlquery . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
