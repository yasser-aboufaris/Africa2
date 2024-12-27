<?php
session_start();
include "../htmlCom/nav.php";
include "../htmlCom/hero.php";
include "../CLASSES/countries.php";

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit();
}

$newConnection2 = new Connection();
$newCountry = new Countries($newConnection2);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $newCountry->create(
                    $_POST['name'], 
                    $_POST['population'], 
                    $_POST['languages'],
                    $_POST['continent_id'],
                );
                break;
            case 'edit':
                $newCountry->edit($_POST['id'], $_POST['name'], $_POST['population'], $_POST['languages']);
                break;
            case 'delete':
                $newCountry->delete($_POST['id']);
                break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Countries Management</h1>
            <button onclick="toggleForm()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Add New Country
            </button>
        </div>

        <div id="addForm" class="hidden mb-8 bg-white p-6 rounded-lg shadow">
            <form method="POST" class="space-y-4">
                <input type="hidden" name="action" value="add">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Name</label>
                        <input type="text" name="name" required class="w-full p-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Population</label>
                        <input type="number" name="population" required class="w-full p-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Languages</label>
                        <input type="text" name="languages" required class="w-full p-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Continent ID</label>
                        <input type="number" name="continent_id" required class="w-full p-2 border rounded">
                    </div>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Save Country
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php
            $Country = $newCountry->Read();
            foreach($Country as $row) {
            ?>
                <div class="bg-black rounded-lg shadow overflow-hidden">
                    <div class="p-5">
                        <h5 class="mb-2 text-2xl font-bold text-white">
                            <?= htmlspecialchars($row['name']) ?>
                        </h5>
                        <p class="mb-3 text-gray-400">
                            Population: <?= htmlspecialchars($row['population']) ?><br>
                            Languages: <?= htmlspecialchars($row['languages']) ?>
                        </p>
                        <div class="flex justify-around h-14">
                            <button onclick="editCountry(<?= htmlspecialchars(json_encode($row)) ?>)" 
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-700 rounded-lg hover:bg-yellow-800">
                                Modify
                            </button>
                            <a href="list.php?id=<?= $row['id'] ?>" class="bg-[#80808048] px-3 py-2 md:px-4 md:py-2 rounded-full hover:bg-[#292929] active:bg-red-700 text-white text-sm md:text-lg font-semibold transition duration-300 btn-primary">
                                view cities
                            </a>
                            <form method="POST" class="inline">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" onclick="return confirm('Are you sure?')"
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-700 rounded-lg hover:bg-red-800">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
    <?php
            }
            ?>
        </div>
    </div>
    <?php 
include "../htmlCom/footer.php";
 ?>

    <script>
        function toggleForm() {
            const form = document.getElementById('addForm');
            form.classList.toggle('hidden');
        }

        function editCountry(country) {
            const form = document.getElementById('addForm');
            form.classList.remove('hidden');
            
            const formElements = form.getElementsByTagName('input');
            formElements.action.value = 'edit';
            
            const newInput = document.createElement('input');
            newInput.type = 'hidden';
            newInput.name = 'id';
            newInput.value = country.id;
            form.getElementsByTagName('form')[0].appendChild(newInput);
            
            formElements.name.value = country.name;
            formElements.population.value = country.population;
            formElements.languages.value = country.languages;
            formElements.continent_id.value = country.continent_id;
        }
    </script>
</body>
</html>