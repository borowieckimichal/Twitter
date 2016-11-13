<?php
session_start();
require_once 'src/connection.php';
require_once 'src/Tweet.php';
require_once 'src/User.php';
require_once 'src/Message.php';
require_once 'src/Comment.php';
if (!isset($_SESSION['loggedUserId'])) {
    header("Location: login.php");
    exit();
}
?>
Twoje ID: <?php echo $_SESSION['loggedUserId']; ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Wiadomość</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/style.css" />
    </head>
    <body>

        <br>
        <a href="logout.php">wyloguj się</a>
        <br>
        <a href="index.php">strona główna </a>
        <br>
        <a href="allmessages.php">strona wiadomości </a>
        <br>
        <?php
        if (isset($_GET['messageId']) && is_numeric($_GET['messageId'])) {

            $messageId = $_GET['messageId'];

            $message = Message::changeMessageStatus($conn, $messageId);

            $userLogged = $_SESSION['loggedUserId'];

            $messagesReceiver = Message::loadAllMessagesByIdReceiver($conn, $userLogged);
            foreach ($messagesReceiver as $message) {
                echo "nr wysyłającego: " . $message->getIdSender() . ' | ';
                echo "nr otrzymującego: " . $message->getIdReceiver() . ' | ';
                echo "Wiadomość: " . $message->getText() . ' | ';
                echo "Data przesłania: " . $message->getCreationDate() . ' | ' . "<br>";
                echo "</div>";
            }
        } 