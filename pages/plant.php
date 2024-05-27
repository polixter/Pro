<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/utils/db.php';

// Obter ID da planta da URL amigável
if (isset($_GET['id'])) {
    $plant_id = $_GET['id'];
    
    // Buscar informações da planta no banco de dados
    $sql = "SELECT * FROM plants WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $plant_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $plant = $result->fetch_assoc();

    // Verificar se a planta existe
    if (!$plant) {
        $plant = ['name' => 'Planta não encontrada'];
    }
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
    <title><?php echo htmlspecialchars($plant['name']); ?> - Pro-Jardim Plantas</title>
    <link rel="shortcut icon" href="/images/logo.svg" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.1/tailwind.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <link href="/style.css" rel="stylesheet" />
</head>

<body class="bg-gray-100 dark:bg-gray-900 dark:text-white">
    <?php include $_SERVER['DOCUMENT_ROOT'].'/components/navbar.php'; ?>
    <div class="container mx-auto p-4">
        <?php
        if ($plant && $plant['name'] !== 'Planta não encontrada') {
            echo '<div class="bg-white dark:bg-gray-800 p-6 mx-auto overflow-y-auto max-w-full sm:max-w-md rounded-lg">';
            echo '<div class="flex justify-center">';
            echo '<img src="/'.htmlspecialchars($plant["image_path"]).'" alt="'.htmlspecialchars($plant["name"]).'" class="block w-full aspect-square object-cover rounded-lg overflow-hidden">';
            echo '</div>';
            echo '<h1 class="text-2xl font-bold mt-2 text-center text-gray-900 dark:text-gray-100">'.htmlspecialchars($plant["name"]).'</h1>';
            echo '<p class="text-lg font-bold text-center text-gray-700 dark:text-gray-300 mt-1"><i>'.htmlspecialchars($plant["scientific_name"]).'</i></p>';
            echo '<p class="mt-2 text-gray-700 dark:text-gray-300">'.nl2br(htmlspecialchars($plant["description"])).'</p>';
            echo '<h2 class="text-xl font-semibold mt-4 text-gray-900 dark:text-gray-100">Plantio</h2>';
            echo '<p class="mt-1 text-gray-700 dark:text-gray-300">'.nl2br(htmlspecialchars($plant["planting_instructions"])).'</p>';
            echo '<h2 class="text-xl font-semibold mt-4 text-gray-900 dark:text-gray-100">Cuidados</h2>';
            echo '<p class="mt-1 text-gray-700 dark:text-gray-300">'.nl2br(htmlspecialchars($plant["care_instructions"])).'</p>';
            echo '<h2 class="text-xl font-semibold mt-4 text-gray-900 dark:text-gray-100">Ficha Técnica</h2>';
            echo '<p class="mt-1 text-gray-700 dark:text-gray-300">'.nl2br(htmlspecialchars($plant["technical_sheet"])).'</p>';
            echo '<ul class="mt-1 text-gray-700 dark:text-gray-300">';
            echo '<li><strong>Toxicidade:</strong> '.($plant["toxicity"] ? "Sim" : "Não").'</li>';
            echo '<li><strong>Requisitos de Sol:</strong> '.htmlspecialchars($plant["sun_requirements"]).'</li>';
            echo '<li><strong>Tipo:</strong> '.htmlspecialchars($plant["type"]).'</li>';
            echo '</ul>';
            echo '</div>';
        } else {
            echo '<p class="text-gray-700 dark:text-gray-300">Planta não encontrada.</p>';
        }

        $conn->close();
        ?>
    </div>
    <script src="/utils/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
</body>

</html>