<?php

    include ('database.php');

    try {
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }

    $db->query('CREATE DATABASE IF NOT EXISTS `camagru`;');
    $db->query('USE `camagru`;');
    $user_creation = $db->prepare('CREATE TABLE `users` (
    	`id`  INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    	`username` varchar(255) NOT NULL ,
        `email` varchar(255) NOT NULL ,
    	`password` varchar(255) NOT NULL ,
        `status` TINYINT(1) NOT NULL DEFAULT 0,
        `forgot` VARCHAR(255) DEFAULT NULL);');
        
    $img_creation = $db->prepare('CREATE TABLE `photo` (
        `id`  INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `username` varchar(255) NOT NULL,
        `img` varchar(255) NOT NULL
    );');

    $comment_table = $db->prepare('CREATE TABLE `comments` (
        `id`  INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `username` varchar(255) NOT NULL,
        `img_id` varchar(255) NOT NULL,
        `comment` varchar(255) NOT NULL
        
    ) ;');

$like_table = $db->prepare('CREATE TABLE `likes`(
        `id`  INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `username` varchar(255) NOT NULL,
        `img_id` varchar(255) NOT NULL
);');
    $user_creation->execute();
    $img_creation->execute();
    $comment_table->execute();
    $like_table->execute();
    echo "SETUP COMPLETE";
