<?php
session_start();
require_once 'src/connection.php';
require_once 'src/Tweet.php';
require_once 'src/User.php';
require_once 'src/Message.php';
require_once 'src/Comment.php';

if (!isset($_SESSION['loggedUserId'])) {
    header("Location: login.php");
}
?>
Twoje ID: <?php echo $_SESSION['loggedUserId']; ?>
<br>
<a href="logout.php">wyloguj się  </a>
<br>
<a href="index.php">strona główna </a>
<br>
<?php
if (isset($_GET['postid']) && is_numeric($_GET['postid'])) {


    $postid = $_GET['postid'];
    $tweet = Tweet::loadTweetById($conn, $postid);
    echo "nr tweeta: " . $tweetId = $tweet->getId() . ' | ';
    echo "Tweet: " . $tweetText = $tweet->getText() . ' | ';
    echo "nr autora:" . $tweetUserId = $tweet->getUserId() . "<br>";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $comment = isset($_POST['comment']) ? $conn->real_escape_string(trim($_POST['comment'])) : null;
        $commentUser = $_SESSION['loggedUserId'];
        $newComment = new Comment();
        $newComment->setIdPost($postid);
        $newComment->setIdUser($commentUser);
        $newComment->setText($comment);
        $newComment->saveToDB($conn);

        if (!$newComment->saveToDB($conn)) {
            echo "Dodawanie komentarza nie powiodło się<br>";
        }
    }

    $comments = Comment::loadAllCommentsByPostId($conn, $postid);
    foreach ($comments as $comment) {
        echo "nr autora: " . $iduser = $comment->getId_user() . ' | ';
        echo "nr tweeta: " . $idPost = $comment->getId_post() . ' | ';
        echo "Komentarz: " . $komentarz = $comment->getText() . ' | ';
        echo "Data dodania: " . $data = $comment->getCreationDate() . ' | ' . "<br>";
    }
}
?>
<!DOCTYPE HTML>
<html lang="pl">
    <head>
        <meta charset="utf-8"/>
        <title>Twitter - strona postu</title>
    </head>
    <body>
        <p>
        <form action="#" method="post" align="center" cols="200">
            <label>
                Twój nowy komentarz  
                <textarea type="text" name="comment" cols="90"> wpisz swój komentarz</textarea>
                <br>       
                <input type="submit" value="publikuj komentarz" />
            </label>
        </form>
    </p>
</body>
</html>
