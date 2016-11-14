<?php
session_start();
if (isset($_SESSION['loggedUserId'])) {
    header("Location: lindex.php");
}


require_once 'src/connection.php';
require_once 'src/User.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $email = isset($_POST['email']) ? $conn->real_escape_string(trim($_POST['email'])) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;


    if ($userId = User::logIn($conn, $email, $password)) {

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
        <link rel="stylesheet" href="css/style.css" />
        <title>Twitter - login</title>
    </head>
    <body>
        <div id="l">
            Twitter              
        </div>
        <div id="l1">
            <form method="POST">
                <fieldset>
                    <strong>Twitter - Logowanie</strong><br>
                    <label>
                        E-mail:
                        <input type="text" id="mail" name="email">
                    </label>
                    <br>

                    <label>
                        Hasło:
                        <input type="password" id="password" name="password">
                    </label>
                    <br>
                </fieldset>
                <input type="submit" value="Login">
            </form>
        </div>
        <div id="l2">
            <br>              
            Nie masz jeszcze konta ?
            <br>
            <a href="register.php">zarejestruj się</a>
        </div>
    </body>
</html>
