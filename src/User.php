<?php

class User {

    private $id;
    private $username;
    private $hashedPassword;
    private $email;

    public function __construct() {

        $this->id = -1;
        $this->username = "";
        $this->email = "";
        $this->hashedPassword = "";
    }

    /**
     * 
     * @param type $newUsername
     */
    public function setUserName($newUsername) {
        $this->username = $newUsername;
    }

    public function setPassword($newPassword) {
        $newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        $this->hashedPassword = $newHashedPassword;
    }

    public function setEmail($newEmail) {
        $this->email = $newEmail;
    }

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getHashedPassword() {
        return $this->hashedPassword;
    }

    public function getEmail() {
        return $this->email;
    }
    
    public function verifyPassword($password) {
        return password_verify($password, $this->hashedPassword);
    }

    public function saveToDB(mysqli $connection) {

        if ($this->id == -1) {

            //Saving new user to DB

            $sql = "INSERT INTO users(username, hashed_password, email)
        VALUES ('$this->username', '$this->hashedPassword', '$this->email')";

            $result = $connection->query($sql);
            if ($result == true) {
                $this->id = $connection->insert_id;

                return true;
            } else {
              
            return false;
            }
        } else {
                $sql = "UPDATE users SET username='$this->username',hashed_password='$this->hashedPassword',email='$this->email'  
                WHERE id=$this->id";

                $result = $connection->query($sql);

                if ($result == true) {
                    return true;
                } else {
                    return false;
                }
        }       
    }

    /**
     * 
     * @param mysqli $connection
     * @param type $id
     * @return \User
     */
    static public function loadUserById(mysqli $connection, $id) {

        $sql = "SELECT * FROM users WHERE id=$id";

        $result = $connection->query($sql);

        if ($result == true && $result->num_rows == 1) {

            $row = $result->fetch_assoc();
            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->username = $row['username'];
            $loadedUser->hashedPassword = $row['hashed_password'];
            $loadedUser->email = $row['email'];

            return $loadedUser;
        }

        return null;
    }

    static public
            function loadAllUsers(mysqli $connection) {

        $sql = "SELECT * FROM users";
        $ret = [];

        $result = $connection->query($sql);
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {

                $loadedUser = new User();
                $loadedUser->id = $row['id'];
                $loadedUser->username = $row['username'];
                $loadedUser->hashedPassword = $row['hashed_password'];
                $loadedUser->email = $row['email'];

                $ret[] = $loadedUser;
            }
        }

        return $ret;
    }

    public function delete(mysqli $connection) {

        if ($this->id != -1) {
            $sql = "DELETE FROM users WHERE id=$this->id";
            $result = $connection->query($sql);
            if ($result == true) {

                $this->id = -1;
                return true;
            }
            return false;
        }
        return true;
    }
    
       static public function loadUserByEmail(mysqli $connection, $email) {

        $sql = "SELECT * FROM users WHERE email='$email'";

        $result = $connection->query($sql);

        if ($result == true && $result->num_rows == 1) {

            $row = $result->fetch_assoc();
            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->username = $row['username'];
            $loadedUser->hashedPassword = $row['hashed_password'];
            $loadedUser->email = $row['email'];

            return $loadedUser;
        }

        return null;
    }
    
    static public function logIn(mysqli $connection, $email, $password) {
		$loadedUser = self::loadUserByEmail($connection, $email);
			
			if(password_verify($password, $loadedUser->hashedPassword)) {
				return $loadedUser;
			} else {
				return false;
			}
		
		}
	
        
        
        
        static public function getUserByEmail(mysqli $conn, $email) {
		$sql = "SELECT * FROM users WHERE email = '$email'";
		$result = $conn->query($sql);
		if($result->num_rows == 1) {
			$row = $result->fetch_assoc();
			$user = new User();
			
			$user->setEmail($row['email']);
			$user->setPassword($row['hashed_password']);
			$user->setUserName($row['username']);
			//$user->setActive($row['active']);
			return $user;
		} else {
			return false;
		}
	}

}
