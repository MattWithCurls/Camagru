<?php
include_once 'config/database.php'; 
// Was the form submitted?
if (isset($_POST["ResetPasswordForm"]))
{
    // Gather the post data
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirm_password"];
    $hash = $_POST["q"];
    // Use the same salt from the forgot_password.php file
    
    // Generate the reset key
    $resetkey  = md5(rand(0, 1000,$email));
     // Does the new reset key match the old one?
    if ($resetkey == $hash)
    {
        if ($password == $confirmpassword)
        {
            //has and secure the password
            $password = hash('SHA512', $password);
            // Update the user's password
            $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             $db->query('USE `camagru`;');
                $query = $db->prepare('UPDATE users SET password = :password WHERE email = :email');
                $query->bindParam(':password', $password);
                $query->bindParam(':email', $email);
                $query->execute();
                $db = null;
            echo "Your password has been successfully reset.";
        }
        else
            echo "Your password's do not match.";
    }
    else
        echo "Your password reset key is invalid.";
}
?>