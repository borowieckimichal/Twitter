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
<br>
<a href="logout.php">wyloguj się</a>
<br>
<a href="index.php">strona główna </a>
<br>

<?php
$userLoged = $_SESSION['loggedUserId'];
echo 'Wiadomości wysłane'. '<br>';
 $messagesSender = Message::loadAllMessagesByIdSender($conn, $userLoged);
        foreach ($messagesSender as $message) {  
            echo "nr wysyłającego: " . $message->getIdSender() . ' | ';
            echo "nr otrzymującego: " . $message->getIdReceiver() . ' | ';
            echo "Wiadomość: " . $message->getText() . ' | ';
            echo "status wiadomości: " . $message->getUnread() . ' | ';
            echo "Data przesłania: " . $message->getCreationDate() . ' | ' ."<br>";  
        }
echo 'Wiadomości otrzymane'. '<br>';

$messagesReceiver = Message::loadAllMessagesByIdReceiver($conn, $userLoged);
        foreach ($messagesReceiver as $message) {  
            echo "nr wysyłającego: " . $message->getIdSender() . ' | ';
            echo "nr otrzymującego: " . $message->getIdReceiver() . ' | ';
            echo "Wiadomość: " . $message->getText() . ' | ';
            echo "status wiadomości: " . $message->getUnread() . ' | ';
            echo "Data przesłania: " . $message->getCreationDate() . ' | ' ."<br>";  
        }