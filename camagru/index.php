<?php
    include_once 'header.php';
?>
<?php
session_start();
if ($_SESSION[username] && !empty($_SESSION[username]));
?>

<html lang="en">
    <head>
        <title>USer Login</title>
    </head>
    <body>
        <h1>Login</h1>
        <?php require_once "messages.php"; ?>
        <form action="login.php" method="POST">
            Username:<input type="text" name="username" /><br />
            Password:<input type="password" name="password" /><br />
            <input type="submit" value="Login" />
        </form>
        <p>Don't have an account?</p>
        <a href="register.php">Register</a>
        <p>Forgotten Password?</p>
        <a href="forgot_password.php">Forgot Password</a>
    </body>
</html>