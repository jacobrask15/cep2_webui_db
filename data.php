<?php
header('Content-Type: application/json');

include "db_connection.php";

$conn = OpenCon();

$sqlQuery = "SELECT * FROM events ORDER BY timestamp_ DESC";

$result = mysqli_query($conn, $sqlQuery);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);

?>