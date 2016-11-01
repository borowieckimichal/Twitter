<?php
session_start();
if (isset($_SESSION['loggedUserId'])) {
    header("Location: lindex.php");
}


require_once 'src/connection.php';
require_once 'src/User.php';
if($_SERVER['REQUEST_METHOD'] == 'POST') {

	
	$email = isset($_POST['email']) ? $conn->real_escape_string(trim($_POST['email'])) : null;
	$password = isset($_POST['password']) ? trim($_POST['password']) : null;
	
	
		if($userId = User::logIn($conn, $email, $password)) {
			
                     $_SESSION['loggedUserId'] = $userId->getId();
			header("Location: index.php");
		} else {
			echo "Niepoprawne dane logowania<br>";
                        
		}
	
	
	$conn->close();
	$conn = null;
}
?>

<!DOCTYPE HTML>
<html lang="pl">
    <head>
        <meta charset="utf-8"/>
        <title>Twitter - login</title>
    </head>
	<body>
		<form method="POST" align="center">
			<fieldset>
			<strong>Twitter - Logowanie</strong><br>
                                <label>
					E-mail:
					<input type="text" name="email">
				</label>
				<br>
                                
				<label>
					Hasło:
					<input type="password" name="password">
				</label>
				<br>
			</fieldset>
			<input type="submit" value="Login">
		</form>
		<br>
                <hr>
		<a href="register.php"> zarejestruj się</a>
	</body>
</html>
