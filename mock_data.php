<?php
header('Content-Type: application/json');

include "db_connection.php";

$conn = OpenCon();

# YYYY-MM-DD hh:mm:ss

for ($x = 0; $x <= 365; $x++) {
$r = $x % 5;
$day = $x % 30;
$month = $x % 12;
$m = $x % 100;
$sqlquery = "INSERT INTO `event` (`timestamp_`, `loglevel`, `type_`, `device_id`, `device_type`, `measurement`) VALUES
('2024-$month-$day 00:23:25', 'Informational', 'toilet', 'ROOM $r', 'PIR', '$m')";


mysqli_query($conn, $sqlquery);
}

mysqli_close($conn);


?>