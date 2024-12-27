<?php
include("conn.php");
$newConnection = new Connection();
$newCountry = new Countries($newConnection);
$newCountry->Read();
?>

<?php
class Countries{
    private $id;
    private $db;

    public function __construct($db){
        $this->db = $db->conn;
    }
    private $sqlRead = "select * from continents ";



    private $sqlModifyPopulation = "";

    private $sqlModifyLanguage = "";

    private $sqlModifyDescription= "";

    private $sqlAddCountry ="insert into countries ";

    public function Read (){

        $prepared = $this->db->prepare($this->sqlRead);
        $prepared->execute();

        $results = $prepared->fetchAll(PDO::FETCH_ASSOC);
        var_dump($results);
        
    }
    
    
    public function delete(){
        
        
    }
        
        }?>