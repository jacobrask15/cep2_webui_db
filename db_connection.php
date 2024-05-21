<?php
function OpenCon()
{
    $dbhost = "localhost";
    $dbuser = "Thomas";
    $dbpass = "1234"; //or whatever you choose when you installed it
    $db = "glgs";
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $db)
        or die("Connect failed: %s\n" . $conn->error);
    return $conn;
}
function CloseCon($conn)
{
    $conn->close();
}


