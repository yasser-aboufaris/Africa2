<?php

define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASSWORD','');
define('DB_DATABASE','africa2');

class Connection
{
    public $conn; 

    public function __construct()
    {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE); // Assign the connection to the class property

        if ($this->conn->connect_error) {
            die ("<h1>Database Connection Failed</h1>");
        }
      
    }
}

?>
