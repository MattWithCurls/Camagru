<?php echo '
<form action="reset.php" method="POST">
 <input type="text" name="email" size="20" /><br />
<input type="password" name="password" size="20" /><br />
 <input type="password" name="confirm_password" size="20" /><br />
<input type="hidden" name="q" value="';

if (isset($_GET["q"])) {

    echo $_GET["q"];
}

    echo '" /><input type="submit" name="ResetPasswordForm" value=" Reset Password " />
</form>';
?>