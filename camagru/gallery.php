<?php
include_once 'config/database.php';

  session_start();
 
  if ($_SESSION[username] && !empty($_SESSION[username])) {
      if (!$_GET[page]) {
          header('Location: gallery.php?page=1');
      }
  } else {
      header('Location: index.php?err= log in to access this page.');
  }
    include_once 'database.php';
    $start = ($_GET[page] - 1) * 10;

    try {
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->query('USE `camagru`;');
        $stmt = $db->prepare('SELECT * FROM photo LIMIT 10 OFFSET :start');
        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Error: '.$e->getMessage();
        exit;
    }

    $result = $stmt->fetchAll();
    if (!$result) {
        if ($_GET[page] > 1) {
            $prev = $_GET[page] - 1;
            header("Location: gallery.php?page=$prev");
            exit();
        } else {
            echo "<span class='empty'>Gallery empty.</span>";
        }
    }
    ?>
      <title>Camagru</title>
      <article class='main'>
      <div class=container>
      <?php
      foreach ($result as $key => $value) {
          echo "<div class='fleximgbox'>";
          try {
            $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $db->query('USE `camagru`;');
              $stmt = $db->prepare('SELECT COUNT(*) FROM likes WHERE img_id = :img_id');
              $stmt->bindParam(':img_id', $value[id], PDO::PARAM_INT);
              $stmt->execute();
          } catch (PDOException $e) {
              echo 'Error: '.$e->getMessage();
              exit;
          }
          $likes = $stmt->fetchColumn();
          if ($value[username] == $_SESSION[username]) {
              echo "<a href='remove.php?img=$value[id]&page=$_GET[page]'><img src='images/filter/remove.png' width='42' style='position:absolute;'></a>";
          }
          echo "<img src='$value[img]' style='width:426px;'>
          <br/>
          User : <i>$value[username]
          <br/></i>Likes: $likes
          <a href='like.php?img_id=$value[id]&page=$_GET[page]' style='float:right; margin-top: -20px;'><img src='images/filter/like.png' width='42' height='42'></a>
          <form class='comment' action='comment.php?img_id=$value[id]&page=$_GET[page]' method='post'><br/>
          <input class='form' style='width:79%;' type='text' placeholder='Enter your comment' name='comment' required>
          <button type='submit' class='button' style='width: auto;'>post</button>
          </form>";
          try { 
            $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $db->query('USE `camagru`;');
              $stmt = $db->prepare("SELECT * FROM comments WHERE img_id = $value[id]");
              $stmt->execute();
          } catch (PDOException $e) {
              echo 'Error: '.$e->getMessage();
              exit;
          }
          $result = $stmt->fetchAll();
          if ($result) {
              echo "<div class='comments'>";
              foreach ($result as $key => $value) {
                  echo "-> <i>$value[username]</i> <br/> $value[comment] <hr>";
              }
              echo '</div>';
          }
          echo '</div>';
      }
      echo '</div><center>
      <ul class="pagination">';
      try {
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->query('USE `camagru`;');
        $stmt = $db->prepare('SELECT COUNT(*) FROM photo');
        $stmt->execute();
      } catch (PDOException $e) {
          echo 'Error: '.$e->getMessage();
          exit;
      }
      $nbpage = ($stmt->fetchColumn() - 1) / 10 + 1;
      $prev = $_GET[page] - 1;
      if ($prev > 0) {
          echo "<li><a href='?page=$prev'>«</a></li>";
      }
      for ($i = 1; $i <= $nbpage; ++$i) {
          echo "<li><a href='?page=$i'>$i</a></li>";
      }
      $next = $_GET[page] + 1;
      if ($next < $nbpage) {
          echo "<li><a href='?page=$next'>»</a></li>";
      }
      echo '</ul></center>';
    ?>
  </article>
</div>