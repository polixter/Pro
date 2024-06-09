<?php
session_start();
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: /login");
    exit();
}

include '../utils/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'];
    $scientific_name = $_POST['scientific_name'];
    $description = $_POST['description'];
    $planting_instructions = $_POST['planting_instructions'];
    $care_instructions = $_POST['care_instructions'];
    $toxicity = $_POST['toxicity'];
    $sun_requirements = $_POST['sun_requirements'];
    $technical_sheet = $_POST['technical_sheet'];

    // Handle the image upload
    $image_path = $_POST['existing_image_path']; // default to existing image
    if (isset($_FILES["image_path"]) && $_FILES["image_path"]["error"] === 0) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["image_path"]["name"]);
        if (move_uploaded_file($_FILES["image_path"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        }
    }

    if ($id) {
        $stmt = $conn->prepare("UPDATE plants SET name=?, scientific_name=?, description=?, planting_instructions=?, care_instructions=?, image_path=?, toxicity=?, sun_requirements=?, technical_sheet=? WHERE id=?");
        $stmt->bind_param("sssssssssi", $name, $scientific_name, $description, $planting_instructions, $care_instructions, $image_path, $toxicity, $sun_requirements, $technical_sheet, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO plants (name, scientific_name, description, planting_instructions, care_instructions, image_path, toxicity, sun_requirements, technical_sheet) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $name, $scientific_name, $description, $planting_instructions, $care_instructions, $image_path, $toxicity, $sun_requirements, $technical_sheet);
    }

    if ($stmt->execute()) {
        $plant_id = $id ? $id : $stmt->insert_id;

        // Atualiza as categorias
        $stmt = $conn->prepare("DELETE FROM plant_categories WHERE plant_id = ?");
        $stmt->bind_param("i", $plant_id);
        $stmt->execute();
        $stmt->close();

        if (isset($_POST['categories'])) {
            $stmt = $conn->prepare("INSERT INTO plant_categories (plant_id, category_id) VALUES (?, ?)");
            foreach ($_POST['categories'] as $category_id) {
                $stmt->bind_param("ii", $plant_id, $category_id);
                $stmt->execute();
            }
            $stmt->close();
        }

        header("Location: /");
        exit();
    } else {
        $error = "Error: " . $stmt->error;
    }

    $stmt->close();
}

$plant = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM plants WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $plant = $result->fetch_assoc();
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Plantas - Banco de Plantas Pro-Jardim</title>
    <link rel="shortcut icon" href="../images/logo.svg">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.1/tailwind.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
</head>

<body class="bg-gray-100 dark:bg-gray-900 dark:text-white">
    <?php include '../components/navbar.php'; ?>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold">Planta</h1>
        <form method="POST" class="mt-4" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $plant['id'] ?? '' ?>">
            <input type="hidden" name="existing_image_path" value="<?= $plant['image_path'] ?? '' ?>">

            <?php
            function createInput($id, $label, $type = 'text', $value = '') {
                return "
                <div class='mb-4'>
                    <label for='$id' class='block text-sm font-medium text-gray-700 dark:text-gray-300'>$label</label>
                    <input type='$type' id='$id' name='$id' value='$value'
                        class='mt-1 p-2 w-full border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:placeholder-gray-400'>
                </div>";
            }

            function createTextarea($id, $label, $value = '') {
                return "
                <div class='mb-4'>
                    <label for='$id' class='block text-sm font-medium text-gray-700 dark:text-gray-300'>$label</label>
                    <textarea id='$id' name='$id'
                        class='mt-1 p-2 w-full border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:placeholder-gray-400'>$value</textarea>
                </div>";
            }

            echo createInput('name', 'Nome', 'text', $plant['name'] ?? '');
            echo createInput('scientific_name', 'Nome Científico', 'text', $plant['scientific_name'] ?? '');
            echo createTextarea('description', 'Descrição', $plant['description'] ?? '');
            echo createTextarea('planting_instructions', 'Instruções de Plantio', $plant['planting_instructions'] ?? '');
            echo createTextarea('care_instructions', 'Cuidados', $plant['care_instructions'] ?? '');
            echo createTextarea('technical_sheet', 'Ficha Técnica', $plant['technical_sheet'] ?? '');
            ?>
            <div class="mb-4">
                <label for="image_path"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Imagem</label>
                <input type="file" id="image_path" name="image_path"
                    class="mt-1 p-2 w-full border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:placeholder-gray-400">
            </div>
            <div class="mb-4">
                <label for="toxicity"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Toxicidade</label>
                <select id="toxicity" name="toxicity"
                    class="mt-1 p-2 w-full border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:placeholder-gray-400">
                    <option value="0" <?= (isset($plant['toxicity']) && $plant['toxicity'] == 0) ? 'selected' : ''; ?>>
                        Sem
                        toxicidade</option>
                    <option value="1" <?= (isset($plant['toxicity']) && $plant['toxicity'] == 1) ? 'selected' : ''; ?>>
                        Tóxica
                    </option>
                </select>
            </div>
            <div class="mb-4">
                <label for="sun_requirements"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ambiente</label>
                <select id="sun_requirements" name="sun_requirements"
                    class="mt-1 p-2 w-full border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:placeholder-gray-400">
                    <option value="Full sun"
                        <?= (isset($plant['sun_requirements']) && $plant['sun_requirements'] == 'Full sun') ? 'selected' : ''; ?>>
                        Sol-pleno</option>
                    <option value="Part sun"
                        <?= (isset($plant['sun_requirements']) && $plant['sun_requirements'] == 'Part sun') ? 'selected' : ''; ?>>
                        Sol-parcial</option>
                    <option value="Part shade"
                        <?= (isset($plant['sun_requirements']) && $plant['sun_requirements'] == 'Part shade') ? 'selected' : ''; ?>>
                        Sombra-parcial</option>
                    <option value="Full shade"
                        <?= (isset($plant['sun_requirements']) && $plant['sun_requirements'] == 'Full shade') ? 'selected' : ''; ?>>
                        Sombra</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Categorias</label>
                <?php
                // Define as categorias e seus IDs
                $categories = [
                    23 => 'Flores', 11 => 'Anuais', 15 => 'Folhagens', 21 => 'Forrações', 18 => 'Palmeiras',
                    12 => 'Perenes', 16 => 'Arbustos', 19 => 'Frutíferas', 20 => 'Trepadeiras', 13 => 'Ervas',
                    14 => 'Suculentas', 24 => 'Cactos', 22 => 'Aquaticas', 17 => 'Arvores'
                ];

                // Busca as categorias atuais da planta
                $plant_categories = [];
                if ($plant) {
                    $stmt = $conn->prepare("SELECT category_id FROM plant_categories WHERE plant_id = ?");
                    $stmt->bind_param("i", $plant['id']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        $plant_categories[] = $row['category_id'];
                    }
                    $stmt->close();
                }

                // Gera os checkboxes
                foreach ($categories as $id => $name) {
                    $checked = in_array($id, $plant_categories) ? 'checked' : '';
                    echo "<div class='flex items-center mb-2'>
                            <input type='checkbox' id='category_$id' name='categories[]' value='$id' $checked class='mr-2'>
                            <label for='category_$id' class='text-sm font-medium text-gray-700 dark:text-gray-300'>$name</label>
                          </div>";
                }
                ?>
            </div>
            <button type="submit" class="bg-lime-500 dark:bg-lime-700 text-white p-2 rounded">Salvar</button>
        </form>
    </div>
    <script src="../utils/scripts.js"></script>
</body>

</html>