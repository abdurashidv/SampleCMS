<?php

class User {

    private $result;
    private $query;
    private $userID;

    public function isUserValid(string $login, string $password): string {
        $this->query = "SELECT id, firstname, lastname FROM users WHERE login = '$login' AND password = '$password' ";
		$this->result = pg_query($this->query);

		if( $this->result != 'FALSE' ){
			while ($row = pg_fetch_array($this->result)) {
				$this->userID = $row['id'];
			}
		}

        return $this->userID;
    }

    public function registerUser(string $firstname, string $lastname, string $login, string $password1, string $password2): boolean {
        $this->query = "INSERT INTO users VALUES ('$firstname','$lastname', '$login', '$password1', '$password2')";
        $this->result = pg_query($this->query);

        return $this->result != 'FALSE' ? true : false;
    }

    public function loginUser( string $login, string $password ): string {
        $this->query = "SELECT firstname, lastname, login, password FROM users WHERE login = '$login' AND password = '$password'";
        $this->result = pg_query($this->query);

        return $this->result != 'FALSE' ? true : false;
    }
}

?>