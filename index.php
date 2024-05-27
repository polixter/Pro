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

<body class="bg-gray-100 dark:bg-gray-900 dark:text-white">
    <?php include './components/navbar.php'; ?>
    <div class="container mx-auto p-4">
        <form class="mb-4 flex space-x-4">
            <input type="text" id="search" onkeyup="searchPlants()" placeholder="Pesquisar..."
                class="w-full p-2 border border-primary rounded dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 focus:ring-2 focus:ring-primary">
            <select id="sun-requirements" onchange="searchPlants()"
                class="p-2 border border-primary rounded dark:bg-gray-700 dark:border-gray-600 focus:ring-2 focus:ring-primary">
                <option value="">Ambiente</option>
                <option value="Full sun">Sol-pleno</option>
                <option value="Part sun">Sol-parcial</option>
                <option value="Part shade">Sombra-parcial</option>
                <option value="Full shade">Sombra</option>
            </select>
            <select id="type" onchange="searchPlants()"
                class="p-2 border border-primary rounded dark:bg-gray-700 dark:border-gray-600 focus:ring-2 focus:ring-primary">
                <option value="">Tipo</option>
                <option value="Perennials">Perenes</option>
                <option value="Annuals">Anuais</option>
                <option value="Herbs">Ervas</option>
                <option value="Succulents">Suculentas</option>
                <option value="Shrubs">Arbustos</option>
                <option value="Trees">Arvores</option>
                <option value="Groundcovers">Forrações</option>
                <option value="Vines">Trepadeira</option>
                <option value="Bulbs">Bulbos</option>
                <option value="Ferns">Samambaias</option>
            </select>
            <select id="toxicity" onchange="searchPlants()"
                class="p-2 border border-primary rounded dark:bg-gray-700 dark:border-gray-600 focus:ring-2 focus:ring-primary">
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
</body>

</html>