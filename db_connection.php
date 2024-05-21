<?php
function OpenCon()
{
    $dbhost = "127.0.0.1";
    $dbuser = "Thomas";
    $dbpass = "1234"; //or whatever you choose when you installed it
    $db = "cep2projectAdminG1";
    $port = "3306";

    $conn = new mysqli($dbhost, $dbuser, $dbpass,$db, $port )
            or die("Connect failed: %s\n". $conn -> error);
    return $conn;
}
function CloseCon($conn)
{
    $conn->close();
}



