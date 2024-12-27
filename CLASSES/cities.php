<?php
include("conn.php");
$newConnection = new Connection();
$newCountry = new Countries($newConnection);
?>

<?php
class Countries {
    private $db;

    public function __construct($db) {
        $this->db = $db->conn;
    }



        public function read($idCountery) {
        $sqlRead = "SELECT * FROM cities where country_id = :idCountery";
        try {
            $prepared = $this->db->prepare($sqlRead);
            $prepared->bindParam(':idCountery', $idCountery, PDO::PARAM_INT);
            $prepared->execute();
            return $prepared->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error reading countries: " . $e->getMessage();

        }
    }

    public function create($name, $description, $type, $countryId) {
        try {
            $query = "INSERT INTO cities (name, description, type, country_id) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$name, $description, $type, $countryId]);
            echo "City added successfully!";
        } catch (PDOException $e) {
            echo "Error creating city: " . $e->getMessage();
        }
    }


public function edit($id, $name, $description, $type) {
    $query = "UPDATE cities SET name = ?, description = ?, type = ? WHERE id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->execute([$name, $description, $type, $id]);
}


    public function delete($id) {
        $query = "DELETE FROM cities WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
    }
}
?>