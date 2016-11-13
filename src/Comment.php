<?php

class Comment {

    private $id;
    private $id_user;
    private $id_post;
    private $creation_date;
    private $text;

    public function __construct() {
        $this->id = -1;
        $this->id_user = 0;
        $this->id_post = 0;
        $this->creation_date = 0;
        $this->text = 0;
    }

    public function setIdUser($newid_user) {
        $this->id_user = $newid_user;
    }

    public function setIdPost($newid_post) {
        $this->id_post = $newid_post;
    }

    public function setCreationDate($newCreationDate) {
        if ($newCreationDate === date('Y-m-d H:i:s')) {
            $this->creation_date = $newCreationDate;
        }
    }

    public function setText($newText) {
        if (is_string($newText)) {
            $this->text = $newText;
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getId_user() {
        return $this->id_user;
    }

    public function getId_post() {
        return $this->id_post;
    }

    public function getCreationDate() {
        return $this->creation_date;
    }

    public function getText() {
        return $this->text;
    }

    static public function loadCommentById(mysqli $connection, $id) {

        $sql = "SELECT * FROM Comment WHERE id=$id ORDER BY creation_date DESC";

        $result = $connection->query($sql);

        if ($result == true && $result->num_rows == 1) {

            $row = $result->fetch_assoc();
            $loadedComment = new Comment();
            $loadedComment->id = $row['id'];
            $loadedComment->id_user = $row['id_user'];
            $loadedComment->id_post = $row['id_post'];
            $loadedComment->creation_date = $row['creation_date'];
            $loadedComment->text = $row['text'];

            return $loadedComment;
        }

        return null;
    }

    static public function loadAllCommentsByPostId(mysqli $connection, $id_postu) {

        $sql = "SELECT * FROM Comment WHERE id_postu=$id_postu ORDER BY 
                creation_date DESC";
        $ret = [];

        $result = $connection->query($sql);
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {

                $loadedComment = new Comment();
                $loadedComment->id = $row['id'];
                $loadedComment->id_user = $row['id_usera'];
                $loadedComment->id_post = $row['id_postu'];
                $loadedComment->creation_date = $row['Creation_date'];
                $loadedComment->text = $row['text'];

                $ret[] = $loadedComment;
            }
        }

        return $ret;
    }

    public function saveToDB(mysqli $connection) {

        if ($this->id == -1) {

            //Saving new user to DB

            $sql = "INSERT INTO Comment(id_usera, id_postu, text)
                    VALUES ('$this->id_user','$this->id_post', '$this->text')";

            $result = $connection->query($sql);
            if ($result == true) {
                $this->id = $connection->insert_id;

                return true;
            }
            return false;
        } else {
            $sql = "UPDATE Comment SET text='$this->text'
                        WHERE id=$this->id";

            $result = $connection->query($sql);

            if ($result == true) {
                return true;
            }
        }
    }
}
