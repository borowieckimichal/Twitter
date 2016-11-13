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
        $komentarz = isset($_POST['komentarz']) ? $conn->real_escape_string(trim($_POST['komentarz'])) : null;
        $komentarztUser = $_SESSION['loggedUserId'];
        $newComment = new Comment();
        $newComment->setIdPostu($postid);
        $newComment->setIdUsera($komentarztUser);
        $newComment->setText($komentarz);
        if ($newComment->saveToDB($conn)) {
            //header("Location: showuser.php");
        } else {
            echo "Dodawanie komentarza nie powiodło się<br>";
        }
    }

    //wyswietl wszystkie komentarze


    $comments = Comment::loadAllCommentsByPostId($conn, $postid);
    foreach ($comments as $comment) {
        echo "nr autora: " . $idusera = $comment->getId_usera() . ' | ';
        echo "nr tweeta: " . $idPostu = $comment->getId_postu() . ' | ';
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
                <textarea type="text" name="komentarz" cols="90"> wpisz swój komentarz</textarea>
                <br>       
                <input type="submit" value="publikuj komentarz" />
            </label>
        </form>
    </p>
</body>
</html>
