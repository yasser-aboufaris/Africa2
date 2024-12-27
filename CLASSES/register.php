<?php
include_once 'conn.php';
include "../htmlCom/nav.php";
class UserRegistration {
    private $conn;
    public $message = "";

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function register($name, $email, $password, $confirmPassword) {
        if (!empty($name) && !empty($email) && !empty($password)) {
            if ($password === $confirmPassword) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $role_id = 1; 

                try {
                    $sql = "INSERT INTO users (name, email, password, role_id) VALUES (:name, :email, :password, :role_id)";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                    $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
                    $stmt->bindParam(':role_id', $role_id, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        $this->message = "Registration successful! You can now <a href='login.php' class='text-blue-500 underline'>login</a>.";
                    } else {
                        $this->message = "An error occurred. Please try again.";
                    }
                } catch (PDOException $e) {
                    $this->message = "Error: " . $e->getMessage();
                }
            } else {
                $this->message = "Passwords do not match!";
            }
        } else {
            $this->message = "All fields are required!";
        }
    }
}

$database = new Connection();
$userRegistration = new UserRegistration($database->conn);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    $userRegistration->register($name, $email, $password, $confirmPassword);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

<div class="flex flex-col justify-center items-center flex-grow">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6">Register</h2>
        <?php if ($userRegistration->message): ?>
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-2 rounded mb-4">
                <?php echo $userRegistration->message; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>
            <div class="mb-4">
                <label for="confirm_password" class="block text-gray-700">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition">Register</button>
        </form>
    </div>
</div>

</body>
</html>
