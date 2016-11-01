<?php
if (isset($_SESSION['loggedUserId'])) {
    header("Location: lindex.php");
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	require_once 'src/connection.php';
	require_once 'src/User.php';
	
	$email = isset($_POST['email']) ? $conn->real_escape_string(trim($_POST['email'])) : null;
	$password = isset($_POST['password']) ? $conn->real_escape_string(trim($_POST['password'])) : null;
	$passwordConfirmation = isset($_POST['passwordConfirmation']) ? trim($_POST['passwordConfirmation']) : null;
	$username = isset($_POST['username']) ? $conn->real_escape_string(trim($_POST['username'])) : null;
	
	$user = User::getUserByEmail($conn, $email);
	if($email && $password && $password == $passwordConfirmation && !$user) {
		
		$newUser = new User();
		$newUser->setEmail($email);
		$newUser->setPassword($password);
		$newUser->setUserName($username);
		
		if($newUser->saveToDB($conn)) {
			header("Location: login.php");
		} else {
			echo "Rejestracja nie powiodła się<br>";
		}
		
		
	} else {
		if($user) {
			echo "Podany adres e-mail istnieje w bazie danych<br>";
		} else {
			echo 'Nieprawidłowe dane<br>';
		}
	}
	
	$conn->close();
	$conn = null;
}
?>
<!DOCTYPE HTML>
<html lang="pl">
    <head>
        <meta charset="utf-8"/>
        <title>Twitter - rejestracja</title>
    </head>
<form method="POST">
	<fieldset>
		<label>
			Nazwa użytkownika:<br>
			<input type="text" name="username">
		</label>           
                <br>
                <label>
			E-mail:<br>
			<input type="text" name="email">
		</label>
		<br>
		<label>
			Hasło:<br>
			<input type="password" name="password">
		</label>
		<br>
		<label>
			Powtórz hasło:<br>
			<input type="password" name="passwordConfirmation">
		</label>
	</fieldset>
	<br>
	<input type="submit" value="zarejestruj się">
</form>
</html>