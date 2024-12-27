<?php
include("conn.php");
$newConnection2 = new Connection();
$newCountry = new Countries($newConnection2);
$newCountry->Read();
?>

<?php
class Countries {
    private $db;

    public function __construct($db) {
        $this->db = $db->conn;
    }

    

    public function read() {
        $sqlRead = "SELECT * FROM countries";
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
          $query = "INSERT INTO countries (name, population, languages, continent_id) VALUES (?, ?, ?, ?)";
          $stmt = $this->db->prepare($query);
          $stmt->execute([$name, $population, $languages, $continent]);
          echo "Country added successfully!";
        } catch (PDOException $e) {
          echo "Error creating country: " . $e->getMessage();
        }
      }

    public function edit($id, $name, $population, $languages) {
        $query = "UPDATE countries SET name = ?, population = ?, languages = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$name, $population, $languages, $id]);
    }

    public function delete($id) {
        $query = "DELETE FROM countries WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
    }
}
?>