<?php
include("conn.php");
$newConnection = new Connection();
$newCountry = new Countries($newConnection);
$newCountry->Read();
?>

<?php
class Countries {
    private $db;

    public function __construct($db) {
        $this->db = $db->conn;
    }

    

    public function read() {
        $sqlRead = "SELECT * FROM cities";
        try {
            $prepared = $this->db->prepare($sqlRead);
            $prepared->execute();
            return $prepared->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error reading countries: " . $e->getMessage();
            
        }
    }

    public function create($name, $population, $languages, $continent) {
        try {
            $query = "INSERT INTO cities (name, population, languages, continent) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$name, $population, $languages, $continent]);
            echo "Country added successfully!";
        } catch (PDOException $e) {
            echo "Error creating country: " . $e->getMessage();
        }
    }

    public function edit($id, $name, $population, $languages) {
        $query = "UPDATE cities SET name = ?, type = ?, WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$name, $population, $languages, $id]);
    }

    public function delete($id) {
        $query = "DELETE FROM cities WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
    }
}
?>