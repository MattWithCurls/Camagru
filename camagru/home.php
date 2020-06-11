<?php
    session_start();
    if (empty($_SESSION['username'])){
        die('You have to be logged in to visit this page');
        
    }
        echo 'Welcome,' . $_SESSION['username'] ."</br>"; 
    
?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Homepage</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet" href="css/home.css">

</head>
<body>
<!-- partial:index.partial.html -->
<nav class="nav">
  <a href="#" class="nav-item is-active" active-color="orange">Home</a>
  <a href="pictaker.php" class="nav-item" active-color="green">Snap</a>
  <a href="gallery.php" class="nav-item" active-color="blue">Photo Wall</a>
  <a href="#" class="nav-item" active-color="red">Profile</a>
  <a href="logout.php" class="nav-item" active-color="rebeccapurple">Logout</a>
  <span class="nav-indicator"></span>
</nav>
<!-- partial -->
  <script  src="js/home.js"></script>

</body>
</html>