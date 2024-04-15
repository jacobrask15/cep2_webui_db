<?php 

session_start();

if (isset($_SESSION['user_name']) && $_SESSION['type'] == '1')
{
     include('adminpage.html');

}else if (isset($_SESSION['user_name']) && $_SESSION['type'] == '2'){
     include('userpage.html');
     
}else{
     header("Location: index.php");
     exit();

}

 ?>