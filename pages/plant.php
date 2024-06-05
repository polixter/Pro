<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/utils/db.php';
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/');

// Obter ID da planta da URL amigável
if (isset($_GET['id'])) {
    $plant_id = $_GET['id'];

    // Verificar se o ID é um número inteiro válido
    if (!filter_var($plant_id, FILTER_VALIDATE_INT)) {
        // Redirecionar se o ID não for válido
        header("Location: /");
        exit();
    }

    // Buscar informações da planta no banco de dados
    $sql = "SELECT * FROM plants WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        // Tratamento de erro de preparação de consulta
        die('Erro na preparação da consulta: ' . $conn->error);
    }

    $stmt->bind_param("i", $plant_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $plant = $result->fetch_assoc();

    // Verificar se a planta existe
    if (!$plant) {
        $plant = ['name' => 'Planta não encontrada'];
    }

    $stmt->close();
} else {
    // Redirecionar se nenhum ID for fornecido
    header("Location: /");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($plant['name']); ?> - Banco de Plantas Pro-Jardim</title>
    <link rel="shortcut icon" href="/images/logo.svg" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.1/tailwind.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-200 dark:bg-gray-900 dark:text-white">
    <?php include $_SERVER['DOCUMENT_ROOT'].'/components/navbar.php'; ?>
    <div class="container mx-auto p-4">
        <?php
        if ($plant && $plant['name'] !== 'Planta não encontrada') {
            echo '<div class="bg-gray-200 dark:bg-gray-900 mx-auto overflow-y-auto max-w-full sm:max-w-md rounded-lg">';
            echo '<div class="flex justify-center">';
            echo '<img src="/'.htmlspecialchars($plant["image_path"]).'" alt="'.htmlspecialchars($plant["name"]).'" class="block w-full aspect-[4/3] object-cover rounded-lg overflow-hidden">';
            echo '</div>';
            echo '<h1 class="text-2xl font-bold mt-2 text-center text-gray-900 dark:text-gray-100">'.htmlspecialchars($plant["name"]).'</h1>';
            echo '<p class="text-g text-center text-gray-900 dark:text-gray-300 mt-1"><i>'.htmlspecialchars($plant["scientific_name"]).'</i></p>';
            echo '<div class="border-t border-gray-300 dark:border-gray-700 mt-4"></div>';
            echo '<h2 class="text-xl font-bold mt-4 text-lime-800 dark:text-lime-500 mt-3">Sobre</h2>';
            echo '<p class="mt-2 text-gray-900 dark:text-gray-300 font-semibold">'.nl2br(htmlspecialchars($plant["description"])).'</p>';
            echo '<div class="border-t border-gray-300 dark:border-gray-700 mt-4"></div>';
            echo '<h2 class="text-xl font-bold mt-3 text-lime-800 dark:text-lime-500">Plantio</h2>';
            echo '<p class="mt-1 text-gray-900 dark:text-gray-300 font-semibold">'.nl2br(htmlspecialchars($plant["planting_instructions"])).'</p>';
            echo '<div class="border-t border-gray-300 dark:border-gray-700 mt-4"></div>';
            echo '<h2 class="text-xl font-bold mt-3 text-lime-800 dark:text-lime-500">Cuidados</h2>';
            echo '<p class="mt-1 text-gray-900 dark:text-gray-300 font-semibold">'.nl2br(htmlspecialchars($plant["care_instructions"])).'</p>';
            echo '<div class="border-t border-gray-400 dark:border-gray-700 mt-4"></div>';
            echo '<h2 class="text-xl font-bold mt-3 text-lime-800 dark:text-lime-500">Ficha Técnica</h2>';
            echo '<p class="mt-1 text-gray-9 00 dark:text-gray-300 font-semibold leading-relaxed">'.nl2br(htmlspecialchars($plant["technical_sheet"])).'</p>';
            echo '<ul class="mt-1 text-gray-900 dark:text-gray-300 font-semibold">';
            echo '<li><strong>Toxicidade:</strong> '.($plant["toxicity"] ? "Sim" : "Não").'</li>';
            echo '<li><strong>Requisitos de Sol:</strong> '.htmlspecialchars($plant["sun_requirements"]).'</li>';
            echo '<li><strong>Tipo:</strong> '.htmlspecialchars($plant["type"]).'</li>';
            echo '</ul>';
            echo '</div>';
        } else {
            echo '<div class="p-4 flex flex-col items-center">';
            echo '<img src="../../images/planta-nao-encontrada.webp" class="w-1/2 md:w-1/3">';
            echo '<p class="text-gray-700 dark:text-gray-300 text-xl text-semibold border-2 border-amber-500 p-4 rounded-md">Ops! Parece que essa planta decidiu não aparecer no nosso jardim. Talvez esteja de férias ou se escondendo atrás de um arbusto. Tente procurar outra planta ou volte mais tarde para ver se ela já voltou!</p>';
            echo '</div>';
        }

        $conn->close();
        ?>
    </div>
    <script src="<?php echo BASE_URL; ?>utils/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
</body>

</html>