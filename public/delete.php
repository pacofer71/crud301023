<?php

use App\Db\Articulos;

if(!isset($_POST['id'])){
    header("Location:inicio.php");
    die();
}
$id=$_POST['id'];
session_start();
require_once __DIR__ ."/../vendor/autoload.php";

$imagen=Articulos::devolverImagen($id);
if(basename($imagen)!="default.png"){
    unlink(".$imagen");
}
Articulos::delete($id);
$_SESSION['mensaje']="Artículo borradocon éxito";
header("Location:inicio.php");