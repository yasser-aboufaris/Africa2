<?php
session_start();
include "../htmlCom/nav.php";
include "../htmlCom/hero.php";
include "../CLASSES/countries.php";

$newConnection2 = new Connection();
$newCountry = new Countries($newConnection2);

$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Countries</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold">Countries</h1>
            <?php if ($isLoggedIn) : ?>
                <p class="text-blue-500">Welcome, <?= htmlspecialchars($_SESSION['username']); ?>!</p>
            <?php else : ?>
                <p class="text-gray-500">Welcome, Guest! Log in for a personalized experience.</p>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $Country = $newCountry->Read();
            foreach ($Country as $row) {
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
                        <div class="flex justify-center">
                            <a href="list.php?id=<?= $row['id'] ?>" 
                               class="bg-[#80808048] px-3 py-2 md:px-4 md:py-2 rounded-full hover:bg-[#292929] active:bg-red-700 text-white text-sm md:text-lg font-semibold transition duration-300 btn-primary">
                                View Cities
                            </a>
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
</body>
</html>
