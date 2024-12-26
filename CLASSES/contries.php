<?php
include("conn.php");
$newConnection = new Connection();
?>

<?php class Countries{
    private $conn = new Connection();
    private $sqlAfficahge = "select * from countries ";

    private $sqlDelete = "DELETE FROM countries WHERE id=$id";

    private $sqlModifyPopulation = "";

    private $sqlModifyLanguage = "";

    private $sqlModifyDescription= "";

    private $sqlAddCountry ="insert into countries ";
    

    public function delete(){
        

    }

        }?>