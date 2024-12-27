<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>

<body>
    <form action="/submit" method="POST" class="max-w-md mx-auto p-6 bg-white shadow-md rounded-lg space-y-4">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
            <input type="text" id="name" name="name"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                required>
        </div>

        <div>
            <label for="population" class="block text-sm font-medium text-gray-700">Population:</label>
            <input type="number" id="population" name="population"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                required>
        </div>

        <div>
            <label for="languages" class="block text-sm font-medium text-gray-700">Languages:</label>
            <input type="text" id="languages" name="languages" placeholder="e.g., English, French"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                required>
        </div>

        <button type="submit"
            class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition">Submit</button>
    </form>

</body>

</html>