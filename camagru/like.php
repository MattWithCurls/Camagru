<?php
 include_once 'config/database.php';
  session_start();
  if (!$_SESSION[username] || empty($_SESSION[username])) {
      header('Location: index.php?err=must log in to access this page.');
      exit();
  }
 
  header("Location:gallery.php?page=$_GET[page]");
  if (empty($_GET[img_id])) {
      header("Location:gallery.php?err=fill in all the blanks.\n");
      exit();
  }
  try {
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $db->query('USE `camagru`;');
      $stmt = $db->prepare('SELECT COUNT(*) FROM likes WHERE username = :username AND img_id = :img_id');
      $stmt->bindParam(':img_id', $_GET[img_id], PDO::PARAM_INT);
      $stmt->bindParam(':username', $_SESSION[username], PDO::PARAM_STR);
      $stmt->execute();
  } catch (PDOException $e) {
      echo 'Error: '.$e->getMessage();
      exit;
  }
  if ($stmt->fetchColumn()) {
      try {
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->query('USE `camagru`;');
          $stmt = $db->prepare('DELETE FROM likes WHERE username = :username AND img_id = :img_id');
          $stmt->bindParam(':img_id', $_GET[img_id], PDO::PARAM_INT);
          $stmt->bindParam(':username', $_SESSION[username], PDO::PARAM_STR);
          $stmt->execute();
      } catch (PDOException $e) {
          echo 'Error: '.$e->getMessage();
          exit;
      }
  } else {
      try {
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->query('USE `camagru`;');
          $stmt = $db->prepare('INSERT INTO likes (username, img_id) VALUES  (:username, :img_id)');
          $stmt->bindParam(':img_id', $_GET[img_id], PDO::PARAM_INT);
          $stmt->bindParam(':username', $_SESSION[username], PDO::PARAM_STR);
          $stmt->execute();
      } catch (PDOException $e) {
          echo 'Error: '.$e->getMessage();
          exit;
      }
  }