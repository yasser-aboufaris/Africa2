<?php
include("conn.php");
$newConnection = new Connection();
$newCity = new Cities($newConnection);
$newCity->Read();


class Cities{
    private $id;
    private $db;

    public function __construct($db){
        $this->db = $db->conn;
    }
    private $sqlRead = "select * from cities ";



    private $sqlModifyPopulation = "";

    private $sqlModifyLanguage = "";

    private $sqlModifyDescription= "";

    private $sqlAddCountry ="insert into cities ";

    public function Read (){

        $prepared = $this->db->prepare($this->sqlRead);
        $prepared->execute();

        $results = $prepared->fetchAll(PDO::FETCH_ASSOC);
        return $results;
        
    }


    public function edit (){
        
    }
     public function ajoute(){

     }
    
    public function delete(){
        
        
    }
        
        }?>