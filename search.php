<?php
include $_SERVER['DOCUMENT_ROOT'].'/utils/db.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$sun_requirements = isset($_GET['sun_requirements']) ? $_GET['sun_requirements'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$toxicity = isset($_GET['toxicity']) ? $_GET['toxicity'] : '';

$sql = "SELECT DISTINCT p.id, p.name, p.scientific_name, p.image_path 
        FROM plants p
        LEFT JOIN plant_categories pc ON p.id = pc.plant_id
        LEFT JOIN categories c ON pc.category_id = c.id
        WHERE 1=1";

if (strlen($search) >= 2) {
    $sql .= " AND (p.name LIKE '%$search%' OR p.scientific_name LIKE '%$search%')";
}
if ($sun_requirements) {
    $sql .= " AND p.sun_requirements='$sun_requirements'";
}
if ($category) {
    $sql .= " AND c.name='$category'";
}
if ($toxicity !== '') {
    $sql .= " AND p.toxicity=$toxicity";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $plant_name = urlencode($row["name"]);
        $plant_id = $row["id"];
        $plant_url = "/plant/" . $plant_name . "/" . $plant_id;

        echo '<div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">';
        echo '<img src="'.$row["image_path"].'" alt="'.$row["name"].'" class="w-full h-48 object-cover rounded-lg">';
        echo '<h2 class="text-lg font-bold mt-2 text-gray-900 dark:text-gray-100">'.$row["name"].'</h2>';
        echo '<p class="text-gray-600 dark:text-gray-400">'.$row["scientific_name"].'</p>';
        echo '<a href="'.$plant_url.'" class="text-blue-500 dark:text-blue-300 mt-4 inline-block">Ver mais</a>';
        echo '</div>';
    }
} else {
    echo "Nenhuma planta com essas características foi encontrada 😕";
}

$conn->close();
?>