<?php
require_once('db_connection.php');

class Student
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->conn;
    }

    public function create($ime, $prezime, $email, $telefon)
    {
        $stmt = $this->conn->prepare("INSERT INTO studenti (ime, prezime, email, telefon) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $ime, $prezime, $email, $telefon);
        return $stmt->execute();
    }

    public function read()
    {
        $result = $this->conn->query("SELECT id, ime, prezime, email, telefon FROM studenti ORDER BY id");
        $rows = array();

        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function update($ime, $prezime, $email, $telefon)
    {
        $stmt = $this->conn->prepare("UPDATE studenti SET ime=?, prezime=?, email=?, telefon=? WHERE id=?");
        $stmt->bind_param("sssi", $ime, $prezime, $telefon, $email, $id);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM studenti WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
