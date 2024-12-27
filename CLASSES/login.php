<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbName = "africa"; 
    public $conn;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbName}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}

class UserAuth {
    private $conn;
    public $error = "";

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function login($email, $password) {
        if (!empty($email) && !empty($password)) {
            $sql = "SELECT users.id, users.name, users.password, roles.name AS role 
                    FROM users 
                    JOIN roles ON users.role_id = roles.id 
                    WHERE users.email = :email";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() === 1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($password, $user['password'])) {
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['name'];
                    $_SESSION['role'] = $user['role'];

                    if ($user['role'] === 'Admin') {
                        header("Location: ../src/index.php");
                    } else {
                        header("Location: ../src/index.php");
                    }
                    exit();
                } else {
                    $this->error = "Invalid password!";
                }
            } else {
                $this->error = "No user found with this email.";
            }
        } else {
            $this->error = "Please fill in all fields.";
        }
    }
}


$database = new Database();
$userAuth = new UserAuth($database->conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userAuth->login($email, $password);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

<div class="flex flex-col justify-center items-center flex-grow">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6">Login</h2>
        <?php if ($userAuth->error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                <?php echo $userAuth->error; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition">Login</button>
        </form>
        <p class="text-center mt-4 text-gray-600">
            Don't have an account? <a href="register.php" class="text-blue-500 hover:underline">Register here</a>
        </p>
    </div>
</div>

</body>
</html>
