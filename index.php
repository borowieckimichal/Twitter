<?php
session_start();
if (!isset($_SESSION['loggedUserId'])) {
    header("Location: login.php");
    exit();
}
?>
Twoje ID: <?php echo $_SESSION['loggedUserId']; ?>
<br>
<a href="logout.php">wyloguj się</a>
<br>
<a href="showuser.php">strona użytkownika</a>
<br>
<a href="edituser.php">edycja danych użytkonika</a>
<br>
<a href="allmessages.php">moje wiadomości </a>

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	require_once 'src/connection.php';
	require_once 'src/Tweet.php';
        //require_once 'src/User.php';
            $tweetemail = isset($_POST['tweet']) ? $conn->real_escape_string(trim($_POST['tweet'])) : null;
            $tweetUser = $_SESSION['loggedUserId'];           
            	$newTweet = new Tweet();
		$newTweet->setUserId($tweetUser);
		$newTweet->setText($tweetemail);
                //$newTweet->setCreationDate(date("Y-m-d H:i:s"));				
                if($newTweet->saveToDB($conn)) {
			header("Location: showuser.php");
		} else {
			echo "Dodawanie tweeta nie powiodło się<br>";
                        var_dump($newTweet);
                        var_dump($conn);
                        
		}   
                //$conn->close();
                //$conn = null;
}
?>
<!DOCTYPE HTML>
<html lang="pl">
    <head>
        <meta charset="utf-8"/>
        <title>Twitter</title>
    </head>
    <body>
        <p>
        <table border="2" cellspacing="6" cellpadding="5" align="center">
            <tr>
                <th width="600">Tweety</th>
                <th>Data publikacji</th>
            </tr>
            <tr>                 
                <td>                        
                    <?php
                    
                require_once 'src/Tweet.php';
                require_once 'src/connection.php';
                require_once 'src/User.php';
                    $loadedTweets = Tweet::loadAllTweets($conn);
                    foreach ($loadedTweets as $tweet) {
                     echo  "nr tweeta: ". $tweetId = $tweet->getId() . ' | ';
                     echo  "Tweet: " . $tweetText = $tweet->getText(). ' | ';
                     echo  "nr autora:" .$tweetUserId = $tweet->getUserId() ."<br>";

                  }
                    
                    ?>
                </td>
                <td>  
                    <?php
                    
                    foreach ($loadedTweets as $tweet) {
                        echo $tweet->getCreationDate();
                        echo '<br/>';   
                    }                                        
                    ?>
                </td>      
            </tr>
        </table>
    </p>
    <hr>
    <p>
    <form action="#" method="post" align="center" cols="200">
        <label>
            Twój nowy Tweet  
            <textarea type="text" name="tweet" cols="90"> wpisz swój post</textarea>
            <br>       
        <input type="submit" value="publikuj Post" />
        </label>
    </form>
    </p>
    <hr>
    <p>
        <table border="2" cellspacing="6" cellpadding="5" align="center">
            <tr>
                <th width="600">Użytkownicy</th>
                <th>Wyślij wiadomość</th>
            </tr>  
            <tr>
                <td>
                   <?php 
                 $allUsers = User::loadAllUsers($conn);
                 foreach ($allUsers as $user) {
                    echo $user->getUsername();
                    echo "<br>";
                 }
                    
                    ?>
                </td>
                <td>
                   <?php
                    $tweetUser = $_SESSION['loggedUserId'];                 
                    foreach ($allUsers as $user) {
                        if ($user->getId() != $tweetUser){
                    echo "<a href='editmessage.php?userId=".$user->getId()."'>Wyslij Wiadomość</a>";
                    echo "<br>";
                        }   
                    }
                    ?>
                </td>      
            </tr>
            
        
        </table> 
    </p>
</body>
</html>