<?php


class Connection
{
    public $conn; 
    private $serverName = "localhost";
    private $username = "root";
    private $password = "";

    public function __construct()
    {
        
        

try {
    $conn = new PDO("mysql:host=$this->serverName", $this->username, $this->password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch(PDOException $e) {
    echo "error";
}

$conn = null;

    }
}