<?php


class Connection
{
    public $conn; 
    private $serverName = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "africa2";

    public function __construct()
    {

        try {
            $conn = new PDO("mysql:host=$this->serverName;dbname=$this->database", $this->username, $this->password);

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } 
        catch(PDOException $e) {
            echo "error";
        }

        $conn = null;

    }
}