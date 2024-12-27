<?php
include_once("../CLASSES/cities.php");

session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $type = $_POST['type'];

        $newCountry->edit($id, $name, $description, $type);
        header("Location: list.php?id=" . $_GET['id']);
        exit;
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $newCountry->delete($id);
        header("Location: list.php?id=" . $_GET['id']);
        exit;
    } elseif (isset($_POST['add'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $type = $_POST['type'];
        $countryId = $_GET['id'];

        $newCountry->create($name, $description, $type, $countryId);
        header("Location: list.php?id=" . $_GET['id']);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>City List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            text-align: center;
        }
        .card h2 {
            margin-top: 0;
            font-size: 1.5em;
            color: #333;
        }
        .card p {
            color: #666;
            margin: 10px 0;
        }
        .edit-form, .add-form {
            margin-top: 20px;
            display: none; /* Initially hidden */
        }
        .edit-form input, .edit-form select, .add-form input, .add-form select, .add-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .edit-form button, .add-form button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .edit-form button:hover, .add-form button:hover {
            background-color: #218838;
        }
        .edit-btn, .delete-btn, .add-btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .edit-btn:hover {
            background-color: #0056b3;
        }
        .delete-btn {
            background-color: #dc3545;
        }
        .delete-btn:hover {
            background-color: #c82333;
        }
        .add-btn {
            font-size: 2em;
            line-height: 1;
            padding: 10px;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .add-btn:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function toggleEditForm(id) {
            const form = document.getElementById(`edit-form-${id}`);
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
        function toggleAddForm() {
            const form = document.getElementById('add-form');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</head>
<body>
    <h1 style="text-align: center;">City List</h1>

    <div class="container">
        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $array = $newCountry->read($id);
            $userRole = $_SESSION['role'] ?? 'User'; 

            if (!empty($array)) {
                foreach ($array as $city) {
                    echo "<div class='card'>";
                    echo "<h2>" . htmlspecialchars($city['name']) . "</h2>";
                    echo "<p><strong>Description:</strong> " . htmlspecialchars($city['description']) . "</p>";
                    echo "<p><strong>Type:</strong> " . htmlspecialchars($city['type']) . "</p>";
                    
                    if ($userRole === 'Admin') {
                        echo "<button class='edit-btn' onclick='toggleEditForm(" . $city['id'] . ")'>Edit</button>";
                        echo "<form id='edit-form-" . $city['id'] . "' class='edit-form' method='POST'>";
                        echo "<input type='hidden' name='id' value='" . htmlspecialchars($city['id']) . "'>";
                        echo "<input type='text' name='name' value='" . htmlspecialchars($city['name']) . "' placeholder='City Name'>";
                        echo "<input type='text' name='description' value='" . htmlspecialchars($city['description']) . "' placeholder='Description'>";
                        echo "<select name='type'>";
                        echo "<option value='Capital' " . ($city['type'] === 'Capital' ? 'selected' : '') . ">Capital</option>";
                        echo "<option value='Other' " . ($city['type'] === 'Other' ? 'selected' : '') . ">Other</option>";
                        echo "</select>";
                        echo "<button type='submit' name='edit'>Save Changes</button>";
                        echo "</form>";

                        echo "<form method='POST' style='margin-top: 10px;'>";
                        echo "<input type='hidden' name='id' value='" . htmlspecialchars($city['id']) . "'>";
                        echo "<button type='submit' name='delete' class='delete-btn'>Delete</button>";
                        echo "</form>";
                    }

                    echo "</div>";
                }
            } else {
                echo "<p style='text-align: center;'>No cities found for the selected country.</p>";
            }

            if ($userRole === 'Admin') {
                echo "<div style='text-align: center; margin: 20px;'>";
                echo "<button class='add-btn' onclick='toggleAddForm()'>+</button>";
                echo "<form id='add-form' class='add-form' method='POST'>";
                echo "<input type='text' name='name' placeholder='City Name' required>";
                echo "<textarea name='description' placeholder='Description' rows='3' required></textarea>";
                echo "<select name='type' required>";
                echo "<option value='Capital'>Capital</option>";
                echo "<option value='Other'>Other</option>";
                echo "</select>";
                echo "<button type='submit' name='add'>Add City</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "<p style='text-align: center;'>Please provide a valid country ID.</p>";
        }
        ?>
    </div>

</body>
</html>
