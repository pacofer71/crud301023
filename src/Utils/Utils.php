<?php
namespace App\Utils;

use App\Db\Articulos;

class Utils{
    private static  array $types=[
        "image/gif",
        "image/jpeg",
        "image/x-icon",
        "image/png",
        "image/tiff", 
        "image/bmp", 
        "image/webp"
    ];
    public static function hayErrorEnCampo(string $nombre,string $valor,int $longitud, int $id=null): bool{
        if(strlen($valor)<$longitud){
            $_SESSION[$nombre]="*** El campo $nombre debe tener al menos una longitud de $longitud caracteres";
            return true;
        }
        if(Articulos::existeNombre($nombre, $id)){
            $_SESSION[$nombre]="*** El nombre ya estña registrado";
            return true;
        }
        return false;
    }
    public static function hayErrorEnCampoNum(string $nombre, int|float $valor, int $min, int|float $max): bool{
        if($valor<=$min || $valor>$max){
            $_SESSION[$nombre]="Error el campo $nombre debe estar entre $min y $max";
            return true;
        }
      
      return false;
    }
    public static function errorEnTipoImagen($type): bool{
        return !in_array($type, self::$types);
    }
    public static function pintarErrores(string $nombre){
        if(isset($_SESSION[$nombre])){
            echo "<p class='text-red-600 mt-2 text-sm italic'>{$_SESSION[$nombre]}</p>";
            unset($_SESSION[$nombre]);
        }
    }
}