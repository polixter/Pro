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
    <link href="../style.css" rel="stylesheet" />
</head>

<body class="bg-gray-200 dark:bg-gray-900 dark:text-white">
    <?php include '../components/navbar.php'; ?>
    <div class="min-h-screen flex items-center justify-center bg-gray-200 dark:bg-gray-900 dark:text-white px-4 sm:px-0">
        <div class="max-w-sm w-full space-y-12">
            <form method="POST" action="login.php" class="space-y-6">
                <input type="hidden" name="remember" value="true">
                <div class="rounded-md shadow-sm space-y-3">
                    <div>
                        <label for="username" class="sr-only">Username</label>
                        <input id="username" name="username" type="text" required
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm"
                            placeholder="Usuario">
                    </div>
                    <div>
                        <label for="password" class="sr-only">Senha</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm"
                            placeholder="Senha">
                    </div>
                </div>
                <div>
                    <?php if (isset($error)): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-3" role="alert">
                        <strong class="font-bold">Erro:</strong>
                        <span class="block sm:inline"><?php echo $error; ?></span>
                    </div>
                    <?php endif; ?>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition active:bg-green-400">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true" class="h-5 w-5 text-green-500 group-hover:text-green-400">
                                <path fill-rule="evenodd"
                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </span>
                        Entrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <script src="../utils/scripts.js"></script>
</body>

</html>