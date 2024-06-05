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
            <button id="dropdownCheckboxButton" data-dropdown-toggle="dropdownDefaultCheckbox"
                class="text-white bg-lime-700 hover:bg-lime-800 focus:ring-4 focus:outline-none focus:ring-lime-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-lime-600 dark:hover:bg-lime-700 dark:focus:ring-lime-800"
                type="button">
                Categorias
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </button>

            <!-- Dropdown menu -->
            <div id="dropdownDefaultCheckbox"
                class="z-10 hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600">
                <ul class="p-3 space-y-3 text-sm text-gray-700 dark:text-gray-200"
                    aria-labelledby="dropdownCheckboxButton">
                    <li>
                        <div class="flex items-center">
                            <input type="checkbox" value="Anuais" id="anuais-checkbox"
                                class="category-checkbox w-4 h-4 text-lime-600 bg-gray-100 border-gray-300 rounded focus:ring-lime-500 dark:focus:ring-lime-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="anuais-checkbox"
                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Anuais</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <input type="checkbox" value="Perenes" id="perenes-checkbox"
                                class="category-checkbox w-4 h-4 text-lime-600 bg-gray-100 border-gray-300 rounded focus:ring-lime-500 dark:focus:ring-lime-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="perenes-checkbox"
                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Perenes</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <input type="checkbox" value="Ervas" id="ervas-checkbox"
                                class="category-checkbox w-4 h-4 text-lime-600 bg-gray-100 border-gray-300 rounded focus:ring-lime-500 dark:focus:ring-lime-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="ervas-checkbox"
                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Ervas</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <input type="checkbox" value="Suculentas" id="suculentas-checkbox"
                                class="category-checkbox w-4 h-4 text-lime-600 bg-gray-100 border-gray-300 rounded focus:ring-lime-500 dark:focus:ring-lime-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="suculentas-checkbox"
                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Suculentas</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <input type="checkbox" value="Folhagens" id="folhagens-checkbox"
                                class="category-checkbox w-4 h-4 text-lime-600 bg-gray-100 border-gray-300 rounded focus:ring-lime-500 dark:focus:ring-lime-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="folhagens-checkbox"
                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Folhagens</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <input type="checkbox" value="Arbustos" id="arbustos-checkbox"
                                class="category-checkbox w-4 h-4 text-lime-600 bg-gray-100 border-gray-300 rounded focus:ring-lime-500 dark:focus:ring-lime-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="arbustos-checkbox"
                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Arbustos</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <input type="checkbox" value="Árvores" id="arvores-checkbox"
                                class="category-checkbox w-4 h-4 text-lime-600 bg-gray-100 border-gray-300 rounded focus:ring-lime-500 dark:focus:ring-lime-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="arvores-checkbox"
                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Árvores</label>
                        </div>
                    </li>
                    <li>
                        <div cl <!-- Adicione mais checkboxes para outras categorias conforme necessário -->
                </ul>
            </div>


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