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
            // Get image dimensions
            list($width, $height) = getimagesize($target_file);

            // Resize if the image is larger than 1000px
            if ($width > 1000 || $height > 1000) {
                $resize_command = "convert $target_file -resize 50% $target_file";
                exec($resize_command);
            }

            // Compress the image
            $compress_command = "convert $target_file -quality 85 $target_file";
            exec($compress_command);

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

    // Execute SQL query and handle errors
    if (mysqli_query($conn, $sql)) {
        // success logic
    } else {
        // error logic
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Gerenciar Plantas</title>
    <link rel="stylesheet" href="../utils/styles.css">
</head>

<body>
    <div class="container">
        <h1>Gerenciar Plantas</h1>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo isset($plant['id']) ? $plant['id'] : ''; ?>">
            <div class="mb-4">
                <label for="name">Nome</label>
                <input type="text" id="name" name="name"
                    value="<?php echo isset($plant['name']) ? $plant['name'] : ''; ?>" required>
            </div>
            <div class="mb-4">
                <label for="scientific_name">Nome Científico</label>
                <input type="text" id="scientific_name" name="scientific_name"
                    value="<?php echo isset($plant['scientific_name']) ? $plant['scientific_name'] : ''; ?>" required>
            </div>
            <div class="mb-4">
                <label for="description">Descrição</label>
                <textarea id="description" name="description"
                    required><?php echo isset($plant['description']) ? $plant['description'] : ''; ?></textarea>
            </div>
            <div class="mb-4">
                <label for="planting_instructions">Instruções de Plantio</label>
                <textarea id="planting_instructions" name="planting_instructions"
                    required><?php echo isset($plant['planting_instructions']) ? $plant['planting_instructions'] : ''; ?></textarea>
            </div>
            <div class="mb-4">
                <label for="care_instructions">Instruções de Cuidados</label>
                <textarea id="care_instructions" name="care_instructions"
                    required><?php echo isset($plant['care_instructions']) ? $plant['care_instructions'] : ''; ?></textarea>
            </div>
            <div class="mb-4">
                <label for="toxicity">Toxicidade</label>
                <select id="toxicity" name="toxicity" required>
                    <option value="0"
                        <?php echo (isset($plant['toxicity']) && $plant['toxicity'] == 0) ? 'selected' : ''; ?>>Sem
                        toxicidade</option>
                    <option value="1"
                        <?php echo (isset($plant['toxicity']) && $plant['toxicity'] == 1) ? 'selected' : ''; ?>>Tóxica
                    </option>
                </select>
            </div>
            <div class="mb-4">
                <label for="sun_requirements">Ambiente</label>
                <select id="sun_requirements" name="sun_requirements" required>
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
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Salvar</button>
        </form>
    </div>
    <script src="../utils/scripts.js"></script>
</body>

</html>