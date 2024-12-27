<?php
session_start();
$role = $_SESSION['role'] ?? 'Guest'; 
?>

<nav class="bg-black p-4 navbar fixed top-0 left-0 rounded-bl-xl rounded-br-xl w-full z-50">
    <ul class="flex justify-around items-center">
        <?php if ($role === 'Admin') : ?>
            <li class="navbar-item">
                <a href="../src/index.php" class="text-white text-sm md:text-lg font-semibold hover:text-[#757575] transition duration-300 navbar-link">
                    Dashboard
                </a>
            </li>
        <?php elseif ($role === 'User') : ?>
            <li class="navbar-item">
                <a href="../src/index2.php" class="text-white text-sm md:text-lg font-semibold hover:text-[#757575] transition duration-300 navbar-link">
                    Dashboard
                </a>
            </li>
        <?php else : ?>
            <li class="navbar-item">
                <a href="../src/index.php" class="text-white text-sm md:text-lg font-semibold hover:text-[#757575] transition duration-300 navbar-link">
                    Main
                </a>
            </li>
        <?php endif; ?>

        <ul class="flex gap-4">
            <li class="navbar-item">
                <a href="../CLASSES/login.php" class="bg-[#80808048] px-3 py-2 md:px-4 md:py-2 rounded-full hover:bg-[#292929] active:bg-red-700 text-white text-sm md:text-lg font-semibold transition duration-300 btn-primary">
                    Login
                </a>
            </li>
        </ul>
    </ul>
</nav>
