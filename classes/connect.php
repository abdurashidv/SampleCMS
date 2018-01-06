<?php

class Connect {

    private $db;

    public function connectDatabase(string $dbname, string $user, string $password): string {
        try {
			$this->db = pg_connect("host=localhost port=5432 dbname=$dbname user=$user password=$password");
		}catch (Exception $e) {
			die("Error in connection: " . pg_last_error());
		}
        return $this->db;
    }

    public function disconnectDatabase(): void {
        pg_close($this->db);
    }

}

?>