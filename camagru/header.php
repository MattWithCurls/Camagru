<?php
    session_start();
?>

<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body {margin: 0;}

ul.topnav {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
}

ul.topnav li {float: left;}

ul.topnav li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

ul.topnav li a:hover:not(.active) {background-color: #111;}

ul.topnav li a.active {background-color: #4CAF50;}

ul.topnav li.right {float: right;}

@media screen and (max-width: 600px) {
  ul.topnav li.right, 
  ul.topnav li {float: none;}
}
</style>
</head>
<body>

<ul class="topnav">
  <li><a class="" href="index.php">Home</a></li>
  <li><a href="pictaker.php">Snap</a></li>
  <li><a href="gallery.php">Photo Wall</a></li>
  <?php if ($_SESSION['username'] && !empty($_SESSION['username'])): ?>
    <li><a href='logout.php'> Logout</a></li>
  <?php endif;?>
  <?php if ($_SESSION['username'] && !empty($_SESSION['username'])): ?>
    <li><a href='forgot.php'> profile</a></li>
  <?php endif;?>
</ul>

</body>
</html>