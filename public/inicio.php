<?php
session_start();

use App\Db\Articulos;


require_once __DIR__ . "/../vendor/autoload.php";

Articulos::generarArticulos(100);
$articulos = Articulos::read();

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
    <title>Document</title>
</head>

<body style="background-color:blanchedalmond">
    <h3 class="text-2xl text-center mt-4">Listado de Articulos</h3>
    <div class="container p-8 mx-auto">
        <div class="flex flex-row-reverse mb-1">
            <a href="create.php" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                <i class="fas fa-add mr-2"></i> Crear Artículo</a>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Image</span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nombre
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Descripción
                        </th>
                        <th scope="col" class="px-6 py-3">
                            PVP (€)
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Stock
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($articulos as $item) {
                        $color = ($item->getStock() < 5) ? "text-red-500" : "text-blue-500";
                        echo <<<TXT
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="w-32 p-4">
                            <img src=".{$item->getImagen()}" alt="{$item->getNombre()}" class="">
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                            {$item->getNombre()}
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                            {$item->getDescripcion()}
                        </td>
                       
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white whitespace-nowrap">
                            {$item->getPrecio()} (€)
                        </td>
                        <td class="px-6 py-4 font-semibold $color">
                        {$item->getStock()} 
                        </td>
                        
                        <td class="px-6 py-4">
                            <form method="POST" action="delete.php" class="whitespace-nowrap" >
                                <input type="hidden" name="id" value="{$item->getId()}" />
                                <a href="detalle.php?id={$item->getId()}">
                                <i class="fas fa-info mr-2 hover:text-green-500"></i>
                                </a>
                                <a href="update.php?id={$item->getId()}">
                                <i class="fas fa-edit mr-2 hover:text-yellow-400"></i>
                                </a>
                                <button type="submit">
                                <i class="fas fa-trash hover:text-red-700"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    TXT;
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
    <?php
    if($_SESSION['mensaje']){
        echo <<<TXT
        <script>
        Swal.fire({
            icon: 'success',
            title: '{$_SESSION['mensaje']}',
            showConfirmButton: false,
            timer: 1500
          })
        </script>
        TXT;
        unset($_SESSION['mensaje']);
    }
    ?>
</body>

</html>