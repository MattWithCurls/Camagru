<?php

    include_once('config/database.php');
    session_start();

    if(empty($_GET[token]) || empty($_GET[email])) {
        header('Location: register.php');
    }

    if (empty($_SESSION[token])){
        $_SESSION['messages'][] = 'Token has expired';
        header('Location: register.php');
    }

    $token = $_GET[token];
    $email = $_GET[email];

    if($_SESSION[token] === $token) {

        // try {
        //     $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        //     $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // } catch (PDOException $e) {
        //     $_SESSION['messages'][] = 'Connection failed: ' . $e->getMessage();
        //     header('Location: register.php');
        //     exit;
        // }
        $db->query('USE `camagru`;');
        $statement = $db->prepare('SELECT * FROM users WHERE email = :email');
        $statement->execute([':email' => $email]);
        
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (empty($result)){
            $_SESSION['messages'][] = 'No such user';
            header('Location: register.php');
            exit;
        }

        $statement = $db->prepare('UPDATE users SET status = :status WHERE email = :email');
        $result = $statement->execute([':status' => 1, ':email' => $email]);

        echo "You've confirmed your registration<br/>";
        echo "<a href='index.php'>Login</a>";

        unset($_SESSION[token]);
    }else{
        $_SESSION['messages'][] = 'Token has expired';
        header('Location: register.php');
    }


    
