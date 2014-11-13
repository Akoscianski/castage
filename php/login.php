<?php 
include 'session.inc';
if (isset($_POST['login']) && isset($_POST['password']) && (check_auth($_POST['login'], $_POST['password'])))
{
	header('Location: index.php');
}
?>
<html>
<head><title>Login</title></head>
<body>
<form method="post" action="login.php">
Please login:<br>
        Login : <input type="text" name="login"> <br>
        Password : <input type="password" name="password">
        <input type="submit" value="Login">
</form>
</body>
</html>
