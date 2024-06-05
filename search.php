<?php
include $_SERVER['DOCUMENT_ROOT'].'/utils/db.php';

session_start();

$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;

$search = isset($_GET['search']) ? $_GET['search'] : '';
$sun_requirements = isset($_GET['sun_requirements']) ? $_GET['sun_requirements'] : '';
$categories = isset($_GET['categories']) ? explode(',', $_GET['categories']) : [];
$toxicity = isset($_GET['toxicity']) ? $_GET['toxicity'] : '';

$sql = "SELECT p.id, p.name, p.scientific_name, p.image_path 
        FROM plants p
        LEFT JOIN plant_categories pc ON p.id = pc.plant_id
        LEFT JOIN categories c ON pc.category_id = c.id
        WHERE 1=1";

$params = [];
$types = '';

if (strlen($search) >= 2) {
    $sql .= " AND (p.name LIKE ? OR p.scientific_name LIKE ?)";
    $searchParam = '%' . $search . '%';
    array_push($params, $searchParam, $searchParam);
    $types .= 'ss';
}
if ($sun_requirements) {
    $sql .= " AND p.sun_requirements=?";
    array_push($params, $sun_requirements);
    $types .= 's';
}
if ($toxicity !== '') {
    $sql .= " AND p.toxicity=?";
    array_push($params, $toxicity);
    $types .= 'i';
}
if (!empty($categories)) {
    $category_placeholders = implode(',', array_fill(0, count($categories), '?'));
    $sql .= " AND c.name IN ($category_placeholders)";
    $params = array_merge($params, $categories);
    $types .= str_repeat('s', count($categories));

    $sql .= " GROUP BY p.id
              HAVING COUNT(DISTINCT c.name) = ?";
    array_push($params, count($categories));
    $types .= 'i';
} else {
    $sql .= " GROUP BY p.id";
}

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

// Adicione logs para depuração
error_log("SQL: " . $sql);
error_log("Params: " . implode(', ', $params));

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $plant_name = urlencode($row["name"]);
        $plant_id = $row["id"];
        $plant_url = "/plant/" . $plant_name . "/" . $plant_id;

        echo '<div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">';
        echo '<a href="'.$plant_url.'" class="block">';
        echo '<img src="'.$row["image_path"].'" alt="'.$row["name"].'" class="w-full h-48 object-cover rounded-lg">';
        echo '</a>';
        echo '<h2 class="text-lg font-bold mt-2 text-gray-900 dark:text-gray-100">'.$row["name"].'</h2>';
        echo '<p class="italic text-gray-600 dark:text-gray-400">'.$row["scientific_name"].'</p>';
        // Adicionar o botão de edição apenas para administradores
        if ($is_admin) {
            echo '<a href="/manage?id='.$row["id"].'" class="text-yellow-500 dark:text-yellow-300 mt-4 inline-block ml-2">Editar</a>';
        }

        echo '</div>';
    }
} else {
    echo "Não encontramos nenhuma planta com essas características 😕";
}

$conn->close();
?>