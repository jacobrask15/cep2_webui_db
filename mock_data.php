<?php
header('Content-Type: application/json');

include "db_connection.php";

$conn = OpenCon();

for ($x = 0; $x <= 10; $x++) {
    $rand = rand();
    $room = $rand % 5 + 1;
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
    $m = $rand % 50 + 50;
    $sqlquery = "INSERT INTO `event` (`timestamp_`, `loglevel`, `type_`, `device_id`, `device_type`, `measurement`) VALUES
('2024-$month-$day $hour:$minute:$second', 'Informational', 'movement', 'ROOM $room', 'PIR', '$m')";


    mysqli_query($conn, $sqlquery);
}

mysqli_close($conn);