<?php
session_start();
require_once 'src/connection.php';
require_once 'src/User.php';
require_once 'src/Tweet.php';
require_once 'src/Message.php';
require_once 'src/Comment.php';
if (!isset($_SESSION['loggedUserId'])) {
    header("Location: login.php");
}
?>
Id użytkownika: <?php echo $_SESSION['loggedUserId'];
?>
<br>
<a href="logout.php">Logout</a>
<a href="index.php">strona główna</a>
<!DOCTYPE HTML>
<html lang="pl">
    <head>
        <meta charset="utf-8"/>
        <title>Twitter User Posts</title>
    </head>
    <body>       
        <p>
        <table border="2" cellspacing="6" cellpadding="5" align="center">
            <tr>
                <th width="600">Twój Tweet</th>
                <th>Data publikacji</th>
            </tr>
            <tr>
                <td> <?php
                    $id = $_SESSION['loggedUserId'];

                    $loadedTweets = Tweet::loadAllTweetsByUserId($conn, $id);
                    foreach ($loadedTweets as $tweet) {
                        $tweetId = $tweet->getId();
                        $numberComments = count(Comment::loadAllCommentsByPostId($conn, $tweetId));
                        echo "nr tweeta:" . $tweet->getId() . " | ";
                        echo "Tweet:" . $tweet->getText() . " | ";
                        echo "<a href='postinfo.php?postid=" . $tweet->getId() . "'>strona postu</a>" . " | ";
                        echo "liczba komentarzy:" . $numberComments . " | ";
                        echo "nr autora:" . $tweet->getUserId() . "<br>";
                    }
                    ?>
                </td>
                <td> <?php
                    foreach ($loadedTweets as $tweet) {
                        echo $tweet->getCreationDate();
                        echo "<br>";
                    }
                    ?>
                </td>
            </tr>
        </table >       
    </p>
</body>
</html>



