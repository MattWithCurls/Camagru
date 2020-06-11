<?php
  header('Location: index.php');
  include_once 'config/database.php';

  if (empty($_POST[username]) || empty($_POST[password]) || empty($_POST[password_confirm]) || empty($_POST[email]) || empty($_POST[hash])) {
      header("Location: index.php?err=fill in all the blanks.\n");
      exit();
  }
  if ($_POST[password] != $_POST[password_confirm]) {
      header("Location: index.php?err=Passwords do not match.\n");
      exit();
  }

  try {
      $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $db->query('USE `camagru`;');
      $stmt = $db->prepare('SELECT COUNT(*) FROM users WHERE username = :username');
      $stmt->bindParam(':username', $_POST[username], PDO::PARAM_STR);
      $stmt->execute();
  } catch (PDOException $e) {
      echo 'Error: '.$e->getMessage();
      exit;
  }
  
  if (!$stmt->fetchColumn()) {
      header("Location: index.php?err=Account does not exist.\n");
      exit();
  }
  $password = hash(SHA512, $_POST[password]);

  try {
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->query('USE `camagru`;');
      $stmt = $db->prepare('SELECT COUNT(*) FROM users WHERE username = :username AND email = :email AND forgot = :hash');
      $stmt->bindParam(':username', $_POST[username], PDO::PARAM_STR);
      $stmt->bindParam(':hash', $_POST[hash], PDO::PARAM_STR);
      $stmt->bindParam(':email', $_POST[email], PDO::PARAM_STR);
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
          $stmt = $db->prepare("UPDATE users SET forgot = 'NULL', password = :password WHERE username = :username AND email = :email AND forgot = :hash");
          $stmt->bindParam(':password', $password, PDO::PARAM_STR);
          $stmt->bindParam(':username', $_POST[username], PDO::PARAM_STR);
          $stmt->bindParam(':hash', $_POST[hash], PDO::PARAM_STR);
          $stmt->bindParam(':email', $_POST[email], PDO::PARAM_STR);
          $stmt->execute();
      } catch (PDOException $e) {
          echo 'Error: '.$e->getMessage();
          exit;
      }

      header("Location: index.php?err=Your password has been correctly changed.\n");
  } else {
      header("Location: index.php?err=error.\n");
  }
  

    