<?php
class Database {
    private $host = "10.15.32.49";
    private $username = "marko.radovanovic";
    private $password = "LoneDruid1987";
    private $database = "fakultet";
    public $conn;

    public function __construct(){
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
}
