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


        <?php
        $userLoged = $_SESSION['loggedUserId'];
        echo 'Wiadomości wysłane' . '<br>';
        $messagesSender = Message::loadAllMessagesByIdSender($conn, $userLoged);
        foreach ($messagesSender as $message) {
            echo "nr wysyłającego: " . $message->getIdSender() . ' | ';
            echo "nr otrzymującego: " . $message->getIdReceiver() . ' | ';
            echo "Wiadomość: " . substr($message->getText(), 0, 30) . ' | ';
            //echo "status wiadomości: " . $message->getUnread() . ' | ';
            echo "Data przesłania: " . $message->getCreationDate() . ' | ' . "<br>";
        }
        echo 'Wiadomości otrzymane' . '<br>';
        ?>
        <div class='message_unread'>
        <?php
        $unreadMessage = Message::loadAllUnreadMessagesByIdReceiver($conn, $userLoged);

        foreach ($unreadMessage as $message) {

            echo "nr wysyłającego: " . $message->getIdSender() . ' | ';
            echo "nr otrzymującego: " . $message->getIdReceiver() . ' | ';
            echo "Wiadomość: " . substr($message->getText(), 0, 30) . ' | ';
            echo "<a href='messageinfo.php?messageId=" . $message->getId() . "'>przeczytaj całą wiadomość</a>" . ' | ';
            echo "Data przesłania: " . $message->getCreationDate() . ' | ' . "<br>";
        }
        ?>   
        </div>
        <div class='message_read'>
            <?php
            $readMessage = Message::loadAllReadMessagesByIdReceiver($conn, $userLoged);

            foreach ($readMessage as $message) {

                echo "nr wysyłającego: " . $message->getIdSender() . ' | ';
                echo "nr otrzymującego: " . $message->getIdReceiver() . ' | ';
                echo "Wiadomość: " . substr($message->getText(), 0, 30) . ' | ';
                echo "<a href='messageinfo.php?messageId=" . $message->getId() . "'>przeczytaj całą wiadomość</a>" . ' | ';
                echo "Data przesłania: " . $message->getCreationDate() . ' | ' . "<br>";
            }
            ?>
        </div>


    </body>
</html>
