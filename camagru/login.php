<?php

 include_once 'config/database.php';
session_start();

$data = $_POST;

if(empty($data[username]) || empty($data[password])){
    $_SESSION['messages'][] = 'Connection Failed: ' . $e->getMessage();
    header('Location: index.php');
}
// $password = hash(SHA512,$data[password]);

$username = $data[username];
$password = $data[password];

$db->query('USE `camagru`;');
$password = hash(SHA512,$data[password]);
$statement = $db->prepare('SELECT * FROM users WHERE username = :username');
$statement->execute([':username' => $username]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

if (empty($result)){
    $_SESSION['messages'][] = 'Incorrect username or password';
    header('Location: index.php');
}

$user = array_shift($result);

if(0 === (int) $user[status]){
    echo "you should confirm your registration first <br/>";
    die('<a href = "index.php"> Go to</a> my account.');
}

if($user[username] === $username && $user[password] === $password) {
    echo 'You have successfully logged in!' . "<br/>";
    echo '<a href="header.php">Go to</a> my account.';
    $_SESSION[username] = $user[username];
}else{
    $_SESSION['messages'][] = 'Incorrect username or password';
    header('Location: index.php');
}
