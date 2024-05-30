<?php
session_start();
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: /login");
    exit();
}

include '../utils/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $scientific_name = $_POST['scientific_name'];
    $description = $_POST['description'];
    $planting_instructions = $_POST['planting_instructions'];
    $care_instructions = $_POST['care_instructions'];
    $toxicity = $_POST['toxicity'];
    $sun_requirements = $_POST['sun_requirements'];
    $type = $_POST['type'];
    $technical_sheet = $_POST['technical_sheet'];

    // Handle the image upload
    if (isset($_FILES["image_path"]) && $_FILES["image_path"]["error"] == 0) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["image_path"]["name"]);
        if (move_uploaded_file($_FILES["image_path"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        } else {
            $image_path = $_POST['existing_image_path']; // use existing image if upload fails
        }
    } else {
        $image_path = $_POST['existing_image_path']; // use existing image if no new file uploaded
    }

    if ($id) {
        $sql = "UPDATE plants SET name='$name', scientific_name='$scientific_name', description='$description', planting_instructions='$planting_instructions', care_instructions='$care_instructions', image_path='$image_path', toxicity='$toxicity', sun_requirements='$sun_requirements', type='$type', technical_sheet='$technical_sheet' WHERE id=$id";
    } else {
        $sql = "INSERT INTO plants (name, scientific_name, description, planting_instructions, care_instructions, image_path, toxicity, sun_requirements, type, technical_sheet) VALUES ('$name', '$scientific_name', '$description', '$planting_instructions', '$care_instructions', '$image_path', '$toxicity', '$sun_requirements', '$type', '$technical_sheet')";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: /manage");
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM plants WHERE id=$id";
    $result = $conn->query($sql);
    $plant = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Plantas</title>
    <link rel="shortcut icon" href="../images/logo.svg" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.1/tailwind.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <link href="../style.css" rel="stylesheet" />
</head>

<body class="bg-gray-100 dark:bg-gray-900 dark:text-white">
    <?php include '../components/navbar.php'; ?>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold"><?php echo $id ? 'Editar' : 'Adicionar'; ?> Planta</h1>
        <form method="POST" class="mt-4" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo isset($plant['id']) ? $plant['id'] : ''; ?>">
            <input type="hidden" name="existing_image_path"
                value="<?php echo isset($plant['image_path']) ? $plant['image_path'] : ''; ?>">

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome</label>
                <input type="text" id="name" name="name"
                    value="<?php echo isset($plant['name']) ? $plant['name'] : ''; ?>"
                    class="mt-1 p-2 w-full border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:placeholder-gray-400">
            </div>
            <div class="mb-4">
                <label for="scientific_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome
                    Científico</label>
                <input type="text" id="scientific_name" name="scientific_name"
                    value="<?php echo isset($plant['scientific_name']) ? $plant['scientific_name'] : ''; ?>"
                    class="mt-1 p-2 w-full border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:placeholder-gray-400">
            </div>
            <div class="mb-4">
                <label for="description"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descrição</label>
                <textarea id="description" name="description"
                    class="mt-1 p-2 w-full border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:placeholder-gray-400"><?php echo isset($plant['description']) ? $plant['description'] : ''; ?></textarea>
            </div>
            <div class="mb-4">
                <label for="planting_instructions"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Instruções de Plantio</label>
                <textarea id="planting_instructions" name="planting_instructions"
                    class="mt-1 p-2 w-full border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:placeholder-gray-400"><?php echo isset($plant['planting_instructions']) ? $plant['planting_instructions'] : ''; ?></textarea>
            </div>
            <div class="mb-4">
                <label for="care_instructions"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cuidados</label>
                <textarea id="care_instructions" name="care_instructions"
                    class="mt-1 p-2 w-full border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:placeholder-gray-400"><?php echo isset($plant['care_instructions']) ? $plant['care_instructions'] : ''; ?></textarea>
            </div>
            <div class="mb-4">
                <label for="technical_sheet" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ficha
                    Técnica</label>
                <textarea id="technical_sheet" name="technical_sheet"
                    class="mt-1 p-2 w-full border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:placeholder-gray-400"><?php echo isset($plant['technical_sheet']) ? $plant['technical_sheet'] : ''; ?></textarea>
            </div>
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
                    <option value="0"
                        <?php echo (isset($plant['toxicity']) && $plant['toxicity'] == 0) ? 'selected' : ''; ?>>Sem
                        toxicidade</option>
                    <option value="1"
                        <?php echo (isset($plant['toxicity']) && $plant['toxicity'] == 1) ? 'selected' : ''; ?>>Toxica
                    </option>
                </select>
            </div>
            <div class="mb-4">
                <label for="sun_requirements"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ambiente</label>
                <select id="sun_requirements" name="sun_requirements"
                    class="mt-1 p-2 w-full border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:placeholder-gray-400">
                    <option value="Full sun"
                        <?php echo (isset($plant['sun_requirements']) && $plant['sun_requirements'] == 'Full sun') ? 'selected' : ''; ?>>
                        Sol-pleno</option>
                    <option value="Part sun"
                        <?php echo (isset($plant['sun_requirements']) && $plant['sun_requirements'] == 'Part sun') ? 'selected' : ''; ?>>
                        Sol-parcial</option>
                    <option value="Part shade"
                        <?php echo (isset($plant['sun_requirements']) && $plant['sun_requirements'] == 'Part shade') ? 'selected' : ''; ?>>
                        Sombra-parcial</option>
                    <option value="Full shade"
                        <?php echo (isset($plant['sun_requirements']) && $plant['sun_requirements'] == 'Full shade') ? 'selected' : ''; ?>>
                        Sombra</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 dark:bg-blue-700 text-white p-2 rounded">Salvar</button>
        </form>
    </div>
    <script src="../utils/scripts.js"></script>
</body>

</html>