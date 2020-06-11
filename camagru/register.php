<?php
include_once 'header.php';
?>

<html lang="en">
<head>
  <title>User Registration</title>
</head>
<body>
  <h1>Register</h1>
  <?php require_once "messages.php";?>
    <form action="signup.php" method="POST">
      Username: <input type="text" name="username" /><br />
      Email: <input type="email" name="email" /><br />
      Password: <input type="password" name="password" minlength="8" required/><br />
      Confirm password: <input type="password" name="password_confirm" minlength="8" required/><br />
      <input type="submit" value="Register" />
    </form>
</body>
</html>