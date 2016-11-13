<?php

class Tweet {

    private $id;
    private $userId;
    private $text;
    private $creationDate;

    public function __construct() {

        $this->id = -1;
        $this->userId = -1;
        $this->text = "";
        $this->creationDate = "";
    }

    public function setUserId($newUserId) {
        $this->userId = $newUserId;
    }

    public function setText($newText) {
        //if(is_string($newText) && count($newText) <= 140) {
        $this->text = $newText;
        //}
    }

    public function setCreationDate($newCreationDate) {

        $this->creationDate = $newCreationDate;
    }

    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getText() {
        return $this->text;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    static public function loadTweetById(mysqli $connection, $id) {

        $sql = "SELECT * FROM Tweet WHERE id=$id";

        $result = $connection->query($sql);

        if ($result == true && $result->num_rows == 1) {

            $row = $result->fetch_assoc();
            $loadedTweet = new Tweet();
            $loadedTweet->id = $row['id'];
            $loadedTweet->userId = $row['userId'];
            $loadedTweet->text = $row['text'];
            $loadedTweet->creationDate = $row['creationDate'];

            return $loadedTweet;
        }

        return null;
    }

    static public function loadAllTweetsByUserId(mysqli $connection, $userId) {

        $sql = "SELECT * FROM Tweet WHERE userId=$userId ORDER BY creationDate DESC";
        $ret = [];

        $result = $connection->query($sql);
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {

                $loadedTweet = new Tweet();
                $loadedTweet->id = $row['id'];
                $loadedTweet->userId = $row['userId'];
                $loadedTweet->text = $row['text'];
                $loadedTweet->creationDate = $row['creationDate'];

                $ret[] = $loadedTweet;
            }
        }

        return $ret;
    }

    static public function loadAllTweets(mysqli $connection) {

        $sql = "SELECT * FROM Tweet ORDER BY creationDate DESC";
        $ret = [];

        $result = $connection->query($sql);
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {

                $loadedTweet = new Tweet();
                $loadedTweet->id = $row['id'];
                $loadedTweet->userId = $row['userId'];
                $loadedTweet->text = $row['text'];
                $loadedTweet->creationDate = $row['creationDate'];

                $ret[] = $loadedTweet;
            }
        }

        return $ret;
    }

    public function saveToDB(mysqli $connection) {

        if ($this->id == -1) {

            //Saving new tweet to DB

            $sql = "INSERT INTO Tweet(userId, text)
        VALUES ('$this->userId', '$this->text')";

            $result = $connection->query($sql);
            if ($result == true) {
                $this->id = $connection->insert_id;

                return true;
            } else {
                return false;
            }
        } else {
            $sql = "UPDATE Tweet SET userId='$this->userId', text='$this->text',
                   creationDate='$this->creationDate' WHERE id=$this->id";
            $result = $connection->query($sql);
            if ($result == true) {
                return true;
            }
        }

        return false;
    }

}
