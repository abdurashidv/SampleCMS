<?php

class Connect {

    private $db;

    public function connectDatabase(string $host, string $port, string $dbname, string $user, string $password) {
        try {
			$this->db = pg_connect("host=" . $host . " port=" . $port . " dbname=" . $dbname . " user=" . $user . " password=" . $password);
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