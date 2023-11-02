<?php

use App\Db\Articulos;

require_once __DIR__ . "/../vendor/autoload.php";

if (!isset($_GET['id']) || !Articulos::existe($_GET['id'])) {
    header("Location:inicio.php");
    die();
}
$id = $_GET['id'];
$articulo = Articulos::findArticlebyId($id);
if ($articulo == null) {
    header("Location:inicio.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind css -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Detalle</title>
</head>

<body style="background-color:blanchedalmond">
    <h3 class="text-2xl text-center mt-4">Detalle Articulo</h3>
    <div class="container p-8 mx-auto">

        <div class="w-1/3 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mx-auto">
            <img class="rounded-t-lg object-cover" src=".<?php echo $articulo->getImagen() ?>" alt="" />
            <div class="p-5">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><?php echo $articulo->getNombre(); ?></h5>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"><?php echo $articulo->getDescripcion(); ?></p>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"><span class="font-bold">PRECIO: </span><?php echo $articulo->getPrecio(); ?> (€)</p>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"><span class="font-bold">STOCK: </span><?php echo $articulo->getStock(); ?></p>
                <a href="inicio.php" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <i class="fas fa-home mr-2"></i>INICIO

                </a>
            </div>
        </div>

    </div>
</body>

</html>