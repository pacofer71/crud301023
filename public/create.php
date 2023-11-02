<?php

use App\Db\Articulos;
use App\Utils\Utils;

require_once __DIR__ . "/../vendor/autoload.php";

session_start();
if (isset($_POST['btn'])) {
    $nombre = ucfirst(htmlspecialchars(trim($_POST['nombre'])));
    $descripcion = ucfirst(htmlspecialchars(trim($_POST['descripcion'])));
    $precio = (float) htmlspecialchars(trim($_POST['precio']));
    $stock = (int) htmlspecialchars(trim($_POST['stock']));

    $errores = false;
    if (Utils::hayErrorEnCampo('Nombre', $nombre, 3)) {
        $errores = true;
    }
    if (Utils::hayErrorEnCampo('Descripcion', $descripcion, 10)) {
        $errores = true;
    }
    if (Utils::hayErrorEnCampoNum("Precio", $precio, 0, 9999.99)) {
        $errores = true;
    }
    if (Utils::hayErrorEnCampoNum("Stock", $stock, 0, 1000)) {
        $errores = true;
    }
    //----------------------------------------------------------------------------- IMAGEN
    if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {
        if (Utils::errorEnTipoImagen($_FILES['imagen']['type'])) {
            $errores = true;
            $_SESSION['Imagen'] = "*** El archivo subido debe ser una imagen";
        } else {
            $nombreI = "./img/" . uniqid() . $_FILES['imagen']['name'];
            if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $nombreI)) {
                $_SESSION['Imagen'] = "*** No se pudo guardar la imagen!!!";
                $errores = true;
            } else {
                $imagen = substr($nombreI, 1);
            }
        }
    } else {
        $imagen = "/img/default.png";
    }
    //----------------------------------------------------------------------------- FIN IMAGE
    if($errores){
        header("Location:{$_SERVER['PHP_SELF']}");
        die();
    }
    (new Articulos)->setNombre($nombre)
    ->setDescripcion($descripcion)
    ->setStock($stock)
    ->setPrecio($precio)
    ->setImagen($imagen)
    ->create();
    $_SESSION['mensaje']="Artículo guardado con éxito";
    header("Location:inicio.php");

} else {


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
        <title>Crear</title>
    </head>

    <body style="background-color:blanchedalmond">
        <h3 class="text-2xl text-center mt-4">Nuevo Usuario</h3>
        <div class="container p-8 mx-auto">
            <div class="w-3/4 mx-auto p-6 rounded-xl bg-gray-400">
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                    <div class="mb-6">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Nombre</label>
                        <input type="text" name="nombre" id="nombre" placeholder="Nombre..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <?php
                        Utils::pintarErrores("Nombre");
                        ?>
                    </div>
                    <div class="mb-6">
                        <label for="desc" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Descripción</label>
                        <textarea name="descripcion" rows='5' id="desc" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                        <?php
                        Utils::pintarErrores("Descripcion");
                        ?>
                    </div>
                    <div class="mb-6">
                        <label for="precio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Precio (€)</label>
                        <input type="number" id="precio" name="precio" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" step="0.01" max="9999,99" min="0">
                        <?php
                        Utils::pintarErrores("Precio");
                        ?>
                    </div>
                    <div class="mb-6">
                        <label for="stock" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Stock</label>
                        <input type="number" id="stock" name="stock" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" step="1" min="0" />
                        <?php
                        Utils::pintarErrores("Stock");
                        ?>
                    </div>
                    <div class="mb-6">
                        <div class="flex w-full">
                            <div class="w-1/2 mr-2">
                                <label for="imagen" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    IMAGEN</label>
                                <input type="file" id="imagen" oninput="img.src=window.URL.createObjectURL(this.files[0])" name="imagen" accept="image/*" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                            </div>
                            <div class="w-1/2">
                                <img src="./img/noimage.png" class="h-72 rounded w-full object-cover border-4 border-black" id="img">
                            </div>
                        </div>

                        <?php
                        Utils::pintarErrores("Imagen");
                        ?>
                    </div>

                    <div class="flex flex-row-reverse">
                        <button type="submit" name="btn" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <i class="fas fa-save mr-2"></i>GUARDAR
                        </button>
                        <button type="reset" class="mr-2 text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-blue-800">
                            <i class="fas fa-paintbrush mr-2"></i>LIMPIAR
                        </button>
                        <a href="inicio.php" class="mr-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-blue-800">
                            <i class="fas fa-backward mr-2"></i>VOLVER
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </body>

    </html>
<?php } ?>