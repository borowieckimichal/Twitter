<?php
session_start();
require_once 'src/connection.php';
require_once 'src/User.php';
if (!isset($_SESSION['loggedUserId'])) {
    header("Location: login.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $loggedUserId = $_SESSION['loggedUserId'];
       // $loggedUser = User::loadUserById($conn, $id);
        $email = isset($_POST['email']) ? $conn->real_escape_string(trim($_POST['email'])) : null;
	$password = isset($_POST['password']) ? $conn->real_escape_string(trim($_POST['password'])) : null;
	$passwordConfirmation = isset($_POST['passwordConfirmation']) ? trim($_POST['passwordConfirmation']) : null;
	$username = isset($_POST['username']) ? $conn->real_escape_string(trim($_POST['username'])) : null;
	
	//$user = User::loadUserById($conn, $loggedUserId);
        
	if($email && $username && $password  && $password == $passwordConfirmation) {
		
		//$newUser = new User();
                $newUser = User::loadUserById($conn, $loggedUserId);
                //$newUser->loadUserById($conn, $loggedUserId);               
                //$newUser->getId();
                //$newUser = User::loadUserById($conn, $loggedUserId);
		$newUser->setUserName($username);
                $newUser->setPassword($password);
		$newUser->setUserName($username);
                $newUser->setEmail($email);
                
		
		if($newUser->saveToDB($conn)) {
			//header("Location: login.php");
                        echo "zmieniono dane użytkownika<br>";
		} else {
			echo "zmiana danych nie powiodła się<br>";
                        var_dump($newUser);
		}
		
		
	} else {		
		echo 'Nieprawidłowe dane<br>';		
	}
	
	$conn->close();
	$conn = null;
}

?>
<!DOCTYPE HTML>
<html lang="pl">
    <head>
        <meta charset="utf-8"/>
        <title>Twitter - edycja danych</title>
    </head>
    <body>
  <br>
<a href="logout.php">wyloguj się</a>
<br>
<a href="index.php">strona główna</a>
<br>
    <form action="#" method="post" align="center">
 	<fieldset>
            <strong>Twitter - edycja danych użytkownika - zmień swoje dane</strong><br>
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
	<input type="submit" value="zmień dane">
    </form>
    </p>
</body>
</html>

