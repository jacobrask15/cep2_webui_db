<?php
function OpenCon()
{
    $dbhost = "localhost";
    $dbuser = "cep2projectAdminG1";
    $dbpass = "12344321"; //or whatever you choose when you installed it
    $db = "group1lightguide";
    $conn = new mysqli($dbhost, $dbuser, $dbpass,$db)
            or die("Connect failed: %s\n". $conn -> error);
    return $conn;
}
function CloseCon($conn)
{
    $conn -> close();
}


