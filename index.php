<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pro-Jardim Plantas</title>
    <link rel="shortcut icon" href="./images/logo.svg" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.1/tailwind.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <link href="./style.css" rel="stylesheet" />
</head>

<body class="bg-gray-200 dark:bg-gray-900 dark:text-white">
    <?php include './components/navbar.php'; ?>
    <div class="container mx-auto p-4">
        <form class="mb-4 flex space-x-4">
            <input type="text" id="search" onkeyup="searchPlants()" placeholder="Pesquisar..."
                class="w-full p-2 border border-primary rounded dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10">
            <select id="sun-requirements" onchange="searchPlants()"
                class="hidden md:block p-2 border border-primary rounded dark:bg-gray-700 dark:border-gray-600 focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10">
                <option value="">Ambiente</option>
                <option value="Full sun">Sol-pleno</option>
                <option value="Part sun">Sol-parcial</option>
                <option value="Part shade">Sombra-parcial</option>
                <option value="Full shade">Sombra</option>
            </select>
            <select id="category" onchange="searchPlants()"
                class="hidden md:block p-2 border border-primary rounded dark:bg-gray-700 dark:border-gray-600 focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10">
                <option value="">Categoria</option>
                <option value="Anuais">Anuais</option>
                <option value="Perenes">Perenes</option>
                <option value="Ervas">Ervas</option>
                <option value="Suculentas">Suculentas</option>
                <option value="Folhagens">Folhagens</option>
                <option value="Arbustos">Arbustos</option>
                <option value="Árvores">Árvores</option>
                <option value="Palmeiras">Palmeiras</option>
                <option value="Frutíferas">Frutíferas</option>
                <option value="Trepadeiras">Trepadeiras</option>
                <option value="Forrações">Forrações</option>
                <option value="Aquáticas">Aquáticas</option>
            </select>

            <select id="toxicity" onchange="searchPlants()"
                class="hidden md:block p-2 border border-primary rounded dark:bg-gray-700 dark:border-gray-600 focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10">
                <option value="">Toxicidade</option>
                <option value="0">Sem Toxicidade</option>
                <option value="1">Toxica</option>
            </select>
        </form>
        <div id="results" class="grid grid-cols-subgrid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <!-- Results will be displayed here -->
        </div>
    </div>
    <script src="./utils/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
</body>

</html>