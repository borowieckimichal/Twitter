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
if (isset($_GET['userId']) && is_numeric($_GET['userId'])) {

    $receiverId = $_GET['userId'];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $message = isset($_POST['message']) ? $conn->real_escape_string(trim($_POST['message'])) : null;
        $messageId = $_SESSION['loggedUserId'];
        $newMessage = new Message();
        $newMessage->setIdSender($messageId);
        $newMessage->setIdReceiver($receiverId);
        $newMessage->setText($message);
        $newMessage->setUnread();
        if ($newMessage->saveToDB($conn)) {
            header("Location: allmessages.php");
        } else {
            echo "wysyłanie wiadomości nie powiodło się<br>";
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
        <title>Twitter</title>
    </head>
    <body>
        <form action="#" method="post" align="center" cols="200">
            <label>
                Twoja nowa wiadomość  
                <textarea type="text" name="message" cols="90"> wpisz swoją wiadomość</textarea>
                <br>       
                <input type="submit" value="wyślij wiadomość" />
            </label>
        </form>
    </p>
</body>
</html>



