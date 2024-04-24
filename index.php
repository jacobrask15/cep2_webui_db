<!DOCTYPE html>

<html>

<head>

    <title>LOGIN</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

     <form action="login.php" method="post">

        <h2>LOGIN</h2>

        <?php if (isset($_GET['error'])) { ?>

            <p class="error"><?php echo $_GET['error']; ?></p>

        <?php } ?>

            <div class="imgcontainer">
        <img src="dawg.jpg" alt="Avatar" class="avatar">
    </div>

    <div class="profile_container">
        <label for="uname"><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="uname" required>

        <label for="password"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="password" required>

        <button type="submit">Login</button>
    </div>

     </form>

</body>

</html>