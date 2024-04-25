<?php
if (empty($_SESSION['user_name']) && $_SESSION['type'] != '1') {
    header("Location: index.php");
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

        <h1>Hello Admin,
            <?php echo $_SESSION['user_name']; ?>
        </h1>
        <a href="logout.php">Logout</a>
    </div>

    <iframe src="chart.html" name="targetframe" allowTransparency="true" scrolling="no" frameborder="0" width="1920"
        height="1080">
    </iframe>
</body>

</html>