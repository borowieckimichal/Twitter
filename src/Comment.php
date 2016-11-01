<?php

class Comment {
    
    private $id;
    private $id_usera;
    private $id_postu;
    private $creation_date;
    private $text;
    
    public function __construct() {
        $this->id = -1;
        $this->id_usera = 0;
        $this->id_postu = 0;
        $this->creation_date = 0;
        $this->text = 0;
    }
    
    public function setIdUsera($newid_usera) {
        $this->id_usera = $newid_usera;
    }
    public function setIdPostu($newid_postu) {
        $this->id_postu = $newid_postu;
    }
    public function setCreationDate($newCreationDate) {
        if($newCreationDate === date('Y-m-d H:i:s')){
        $this->creation_date = $newCreationDate;
        }
    }
        public function setText($newText) {
        if(is_string($newText)) {
        $this->text = $newText;
        }
    }
        public function getId() {
        return $this->id;
    }
        public function getId_usera() {
        return $this->id_usera;
    }
        public function getId_postu() {
        return $this->id_postu;
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
            $loadedComment->id_usera = $row['id_usera'];
            $loadedComment->id_postu = $row['id_postu'];
            $loadedComment->creation_date = $row['creation_date'];
            $loadedComment->text = $row['text'];

            return $loadedComment;
        }

        return null;
    }
    
        static public function loadAllCommentsByPostId(mysqli $connection, $id_postu) {

        $sql = "SELECT * FROM Comment WHERE id_postu=$id_postu ORDER BY creation_date DESC";
        $ret = [];

        $result = $connection->query($sql);
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {

                $loadedComment = new Comment();
                $loadedComment->id = $row['id'];
                $loadedComment->id_usera = $row['id_usera'];
                $loadedComment->id_postu = $row['id_postu'];                
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
        VALUES ('$this->id_usera','$this->id_postu', '$this->text')";

            $result = $connection->query($sql);
            if ($result == true) {
                $this->id = $connection->insert_id;

                return true;
            } else {
                $sql = "UPDATE Comment SET text='$this->text'
                        WHERE id=$this->id";

                $result = $connection->query($sql);

                if ($result == true) {
                    return true;
                }
            }

            return false;
        }
    }
    
    
    
    
}
