<?php
session_start();
include '../utils/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['is_admin'] = $user['is_admin'];
            header("Location: ../");
            exit();
        } else {
            $error = "Senha incorreta";
        }
    } else {
        $error = "Usuario não encontrado";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pro-Jardim Plantas</title>
    <link rel="shortcut icon" href="../images/logo.svg" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <link href="style.css" rel="stylesheet" />
</head>

<body class="bg-gray-100 dark:bg-gray-900 dark:text-white">
    <?php include '../components/navbar.php'; ?>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold">Login</h1>
        <form method="POST" class="mt-4">
            <div class="mb-4">
                <label for="username"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Username</label>
                <input type="text" id="username" name="username"
                    class="mt-1 p-2 w-full border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:placeholder-gray-400">
            </div>
            <div class="mb-4">
                <label for="password"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                <input type="password" id="password" name="password"
                    class="mt-1 p-2 w-full border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:placeholder-gray-400">
            </div>
            <button type="submit" class="bg-blue-500 dark:bg-blue-700 text-white p-2 rounded">Login</button>
        </form>
        <?php if (isset($error)) { echo '<p class="text-red-500 dark:text-red-300 mt-4">' . $error . '</p>'; } ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <script src="../utils/scripts.js"></script>
</body>

</html>