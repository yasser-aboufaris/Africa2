<?php
include("conn.php");
$newConnection = new Connection();
$newContinent = new Continents($newConnection);
$newContinent->Read();
?>

<?php
class Continents{
    private $id;
    private $db;

    public function __construct($db){
        $this->db = $db->conn;
    }
    private $sqlRead = "select * from continents ";



    private $sqlModifyPopulation = "";

    private $sqlModifyLanguage = "";

    private $sqlModifyDescription= "";

    private $sqlAddCountry ="insert into continents ";

    public function Read (){

        $prepared = $this->db->prepare($this->sqlRead);
        $prepared->execute();

        $results = $prepared->fetchAll(PDO::FETCH_ASSOC);
        return $results;
        
    }

    public function edit (){
        
    }
    
    
    public function delete(){
        
        
    }
        
        }?>