<?php

include_once 'config/database.php';


// Was the form submitted?
if (isset($_POST["ForgotPassword"])) {
     
    // Harvest submitted e-mail address
    if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email = $_POST["email"];
         
    }else{
        echo "email is not valid";
        exit;
    }
 
    // Check to see if a user exists with this e-mail
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->query('USE `camagru`;');
    $query = $db->prepare('SELECT email FROM users WHERE email = :email');
    $query->bindParam(':email', $email);
    $query->execute();
    $userExists = $query->fetch(PDO::FETCH_ASSOC);
    $db = null;
     
    if ($userExists["email"])
    {

 
        // Create the unique user password reset key
        $hash = md5(rand(0, 1000,$userExists["email"]));
 
        // Create a url which we will direct them to reset their password
        $pwrurl = "localhost:8080/camagru/reset_password.php?q=".$hash;       
        // Mail them their key
        $mailbody = "Dear user,\n\nIf this e-mail does not apply to you please ignore it. It appears that you have requested a password reset at our website www.yoursitehere.com\n\nTo reset your password, please click the link below. If you cannot click it, please paste it into your web browser's address bar.\n\n" . $pwrurl . "\n\nThanks,\nThe Administration";
        mail($userExists["email"], "Camagru - Password Reset", $mailbody);
        echo "Your password recovery key has been sent to your e-mail address.";
    }
    else

        echo "No user with that e-mail address exists.";
}
?>