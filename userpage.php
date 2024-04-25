<?php
if ($_SESSION['type'] != '2') {
    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>

<html>

<head>

    <title>HOME</title>

    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>

    <div class="header">
        <h1>Hello User,
            <?php echo $_SESSION['user_name']; ?>
        </h1>

        <a href="logout.php">Logout</a>
    </div>

    <iframe src="chart.php" name="targetframe" allowTransparency="true" scrolling="no" frameborder="0" width="1920"
        height="1080">
    </iframe>


</body>

</html>