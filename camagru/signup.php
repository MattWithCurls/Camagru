<?php

 include_once 'config/database.php';

session_start();

$data = $_POST;

if (empty($data[username]) ||
    empty($data[password]) ||
    empty($data[email]) ||
    empty($data[password_confirm])) {

                
                $_SESSION['messages'][] = 'Please fill all required field';
                header('Location: register.php');
                exit;
    }
    if ($data[password] !== $data[password_confirm]) {
        $_SESSION['messages'][] = 'password and confirm password should match';
        header('Location: register.php');
        exit;
    }
    $password = hash(SHA512,$data[password]);

   
        $db->query('USE `camagru`;');
        $statement = $db->prepare('SELECT * FROM users WHERE username = :username OR email = :email');
        if($statement){
            $statement->execute([
                ':username' => $data[username],
                ':email' => $data[email]
            ]);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($result)){
                $_SESSION['messages'][] = 'User with username already exists!';
                header('Location: register.php');
                exit;
            }
        }

        $db->query('USE `camagru`;');
        $statement = $db->prepare('INSERT INTO users (username,email,password) VALUES (:username,:email,:password)');
        if ($statement) {
            $result = $statement->execute([
                ':username' => $data[username],
                ':email' => $data[email],
                ':password' => $password,
            ]);
        if($result){
                $_SESSION['token'] = hash('sha256', uniqid()); 

                $email = $data[email];
                $message = sprintf('Hi %s,Please confirm registration http://localhost:8080/Camagru/confirm.php?%s',
                $data[username],
                http_build_query([
                    'token' => $_SESSION[token],
                    'email' => $email
                ])
                );
                $headers = 'From: msteer@camagru.com';
                mail($email,'[Camagru App] User registration', $message,$headers);
                $_SESSION['messages'][] = 'thank you for registration.Check email and confirm';
                header('Location: register.php');
                exit;
            }
        }