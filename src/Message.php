<?php

class Message {

    private $id;
    private $id_sender;
    private $id_receiver;
    private $creation_date;
    private $text;
    private $unread;

    public function __construct() {
        $this->id = -1;
        $this->id_sender = 0;
        $this->id_receiver = 0;
        $this->creation_date = '';
        $this->text = '';
        $this->unread = 0;
    }

    public function setIdSender($newIdSender) {
        $this->id_sender = $newIdSender;
    }

    public function setIdReceiver($newIdReceiver) {
        $this->id_receiver = $newIdReceiver;
    }

    public function setCreationDate($newCreationDate) {
        $this->creation_date = $newCreationDate;
    }

    public function setText($newText) {
        $this->text = $newText;
    }

    public function setUnread($unread) {
        $this->unread = $unread;
    }

    public function getId() {
        return $this->id;
    }

    public function getIdSender() {
        return $this->id_sender;
    }

    public function getIdReceiver() {
        return $this->id_receiver;
    }

    public function getCreationDate() {
        return $this->creation_date;
    }

    public function getText() {
        return $this->text;
    }

    public function getUnread() {
        return $this->unread;
    }

    public function saveToDB(mysqli $connection) {

        if ($this->id == -1) {

            //Saving new message to DB

            $sql = "INSERT INTO Message(id_sender, id_receiver, text, unread)
        VALUES ('$this->id_sender','$this->id_receiver', '$this->text', '$this->unread')";

            $result = $connection->query($sql);
            if ($result == true) {
                $this->id = $connection->insert_id;

                return true;
            }
        }
        return false;
    }

    static public function loadMessageById(mysqli $connection, $id) {

        $sql = "SELECT * FROM Message WHERE id=$id";

        $result = $connection->query($sql);

        if ($result == true && $result->num_rows == 1) {

            $row = $result->fetch_assoc();
            $loadedMessage = new Message();
            $loadedMessage->id = $row['id'];
            $loadedMessage->id_sender = $row['id_sender'];
            $loadedMessage->id_receiver = $row['id_receiver'];
            $loadedMessage->creation_date = $row['creation_date'];
            $loadedMessage->text = $row['text'];
            $loadedMessage->unread = $row['unread'];

            return $loadedMessage;
        }

        return null;
    }

    static public function loadAllMessagesByIdSender(mysqli $connection, $id_sender) {

        $sql = "SELECT * FROM Message WHERE id_sender=$id_sender ORDER BY Creation_date DESC";
        $ret = [];

        $result = $connection->query($sql);
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {

                $loadedMessage = new Message();
                $loadedMessage->id = $row['id'];
                $loadedMessage->id_sender = $row['id_sender'];
                $loadedMessage->id_receiver = $row['id_receiver'];
                $loadedMessage->creation_date = $row['creation_date'];
                $loadedMessage->text = $row['text'];
                $loadedMessage->unead = $row['unread'];

                $ret[] = $loadedMessage;
            }
        }

        return $ret;
    }

    static public function loadAllMessagesByIdReceiver(mysqli $connection, $id_receiver) {

        $sql = "SELECT * FROM Message WHERE id_receiver=$id_receiver ORDER BY Creation_date DESC";
        $ret = [];

        $result = $connection->query($sql);
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {

                $loadedMessage = new Message();
                $loadedMessage->id = $row['id'];
                $loadedMessage->id_sender = $row['id_sender'];
                $loadedMessage->id_receiver = $row['id_receiver'];
                $loadedMessage->creation_date = $row['creation_date'];
                $loadedMessage->text = $row['text'];
                $loadedMessage->unread = $row['unread'];

                $ret[] = $loadedMessage;
            }
        }

        return $ret;
    }

    static public function changeMessageStatus(mysqli $connection, $id) {

        $sql = "UPDATE Message SET unread='1' WHERE id='$id'";

        $result = $connection->query($sql);

        if ($result == true) {
            return true;
        } else {
            return false;
        }
    }

    static public function loadAllUnreadMessagesByIdReceiver(mysqli $connection, $id_receiver) {

        $sql = "SELECT * FROM Message WHERE id_receiver=$id_receiver AND unread='0' ORDER BY Creation_date DESC";
        $ret = [];

        $result = $connection->query($sql);
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {

                $loadedMessage = new Message();
                $loadedMessage->id = $row['id'];
                $loadedMessage->id_sender = $row['id_sender'];
                $loadedMessage->id_receiver = $row['id_receiver'];
                $loadedMessage->creation_date = $row['creation_date'];
                $loadedMessage->text = $row['text'];
                $loadedMessage->unread = $row['unread'];

                $ret[] = $loadedMessage;
            }
        }

        return $ret;
    }

    static public function loadAllReadMessagesByIdReceiver(mysqli $connection, $id_receiver) {

        $sql = "SELECT * FROM Message WHERE id_receiver=$id_receiver AND unread='1' ORDER BY Creation_date DESC";
        $ret = [];

        $result = $connection->query($sql);
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {

                $loadedMessage = new Message();
                $loadedMessage->id = $row['id'];
                $loadedMessage->id_sender = $row['id_sender'];
                $loadedMessage->id_receiver = $row['id_receiver'];
                $loadedMessage->creation_date = $row['creation_date'];
                $loadedMessage->text = $row['text'];
                $loadedMessage->unread = $row['unread'];

                $ret[] = $loadedMessage;
            }
        }

        return $ret;
    }

}
