<?php

class User {

    private $result;
    private $query;
    private $userID;

    public function getUserID(string $login, string $password) {
        $this->query = "SELECT id, firstname, lastname FROM users WHERE login = '$login' AND password = '$password' ";
		$this->result = pg_query($this->query);

		if( $this->result != 'FALSE' ){
			while ($row = pg_fetch_array($this->result)) {
				$this->userID = $row['id'];
            }
            return $this->userID;    
        }

        return -1;
    }

    public function registerUser(string $firstname, string $lastname, string $login, string $displayname, string $password): boolean {
        $this->query = "INSERT INTO users(firstname, lastname, displayname, login, password) VALUES ('$firstname','$lastname', '$displayname', '$login', '$password')";
        $this->result = pg_query($this->query);

        return $this->result != 'FALSE' ? true : false;
    }

    public function loginUser( string $login, string $password ) {
        $this->query = "SELECT firstname, lastname, login, password FROM users WHERE login = '$login' AND password = '$password'";
        $this->result = pg_query($this->query);

        return $this->result;
    }
}

?>