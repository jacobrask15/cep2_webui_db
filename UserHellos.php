
<?php
    include 'db_connection.php';
    $conn = OpenCon();
    $sql = "SELECT * FROM helloworld";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "The user " . $row["whoSaidHello"]. " - said: " .
            $row["whatDidTheySay"]. "<br>";
        }
        } else {
        echo "0 results";
        }
    CloseCon($conn);
?>