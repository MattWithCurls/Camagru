<?php
include_once 'config/database.php';

  session_start();
  if (!$_SESSION[username] || empty($_SESSION[username])) {
      header('Location: index.php?err=must log in to access this page.');
      exit();
  }
  if (empty(strip_tags($_POST[comment])) || empty($_GET[img_id])) {
      header("Location: gallery.php?page=$_GET[page]");
      exit();
  }
  include_once 'database.php';
  header("Location: gallery.php?page=$_GET[page]");

  try {
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->query('USE `camagru`;');
    $stmt = $db->prepare('INSERT INTO comments (username, img_id, comment) VALUES  (:username, :img_id, :comment)');
    $stmt->bindParam(':img_id', $_GET[img_id], PDO::PARAM_INT);
    $stmt->bindParam(':username', $_SESSION[username], PDO::PARAM_STR);
    $stmt->bindParam(':comment', strip_tags($_POST[comment]), PDO::PARAM_STR);
    $stmt->execute();
    $stmt = $db->prepare('SELECT users.email FROM users INNER JOIN photo ON users.username = photo.username WHERE photo.id = :img_id');
    $stmt->bindParam(':img_id', $_GET[img_id], PDO::PARAM_INT);
    $stmt->execute();
  } catch (PDOException $e) {
      echo 'Error: '.$e->getMessage();
      exit;
  }

  $mail = $stmt->fetchColumn();
  $to = $mail;
  $subject = 'Camagru | Your comments';
  $message = "
  This person Commented on your : $_SESSION[username]
  Comment : $_POST[comment]
  ";

  $headers = 'From:matt@camagru.com'."\r\n";
  mail($to, $subject, $message, $headers);