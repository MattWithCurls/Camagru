<?php
include_once 'config/database.php';
header("Location:gallery.php?page=$_GET[page]");
session_start();
  
  try {
      $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $db->query('USE `camagru`;');
      $stmt = $db->prepare('DELETE FROM photo WHERE username = :username AND id = :img');
      $stmt->bindParam(':username', $_SESSION[username], PDO::PARAM_STR);
      $stmt->bindParam(':img', $_GET[img], PDO::PARAM_INT);
      $stmt->execute();
  } catch (PDOException $e) {
      echo $sql.'<br>'.$e->getMessage();
  }