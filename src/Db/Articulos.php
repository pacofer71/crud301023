<?php

namespace App\Db;

use \PDO;
use \PDOException;

class Articulos extends Conexion
{
    private int $id;
    private string $nombre;
    private string $descripcion;
    private float $precio;
    private int $stock;
    private string $imagen;

    public function __construct()
    {
        parent::__construct();
    }

    //------------------------------------------------------------------------------- CRUD ---------------------------------------
    public function create()
    {
        $q = "insert into articulos(nombre, descripcion, precio, stock, imagen) values(:n, :d, :p, :s, :i)";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':d' => $this->descripcion,
                ':p' => $this->precio,
                ':s' => $this->stock,
                ':i' => $this->imagen
            ]);
        } catch (PDOException $ex) {
            die("Error al insertar: " . $ex->getMessage());
        }
        parent::$conexion = null;
    }

    public static function read()
    {
        parent::setConexion();
        $q = "select * from articulos order by id desc";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al leer: " . $ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt->fetchAll(PDO::FETCH_CLASS, Articulos::class);
    }

    public function update($id){
        $q = "update articulos set nombre=:n, descripcion=:d, precio=:p, imagen=:i, stock=:s where id=:id";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':d' => $this->descripcion,
                ':p' => $this->precio,
                ':s' => $this->stock,
                ':i' => $this->imagen,
                ':id'=>$id
            ]);
        } catch (PDOException $ex) {
            die("Error en update: " . $ex->getMessage());
        }
        parent::$conexion = null;
    }

    

    public static function delete(int $id)
    {
        parent::setConexion();
        $q = "delete from articulos where id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([':i' => $id]);
        } catch (PDOException $ex) {
            die("Error al borrar: " . $ex->getMessage());
        }
        parent::$conexion = null;
    }


    //-------------------------------------------------------------------------------- FAKER -------------------------------------
    private static function hayArticulos(): bool
    {
        parent::setConexion();
        $q = "select id from articulos";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al comprobar si hay articulos: " . $ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt->rowCount();
    }

    public static function generarArticulos(int $cantidad)
    {
        if (self::hayArticulos()) return;
        $faker = \Faker\Factory::create('es_ES');
        $faker->addProvider(new \Mmo\Faker\PicsumProvider($faker));

        for ($i = 0; $i < $cantidad; $i++) {
            $nombre = ucfirst($faker->unique()->words(random_int(2, 4), true));
            $descripcion = $faker->text();
            $precio = $faker->randomFloat(2, 10, 9999);
            $stock = random_int(1, 20);
            $imagen = "/img/" . $faker->picsum(dir: "./img/", width: 640, height: 480, fullPath: false);

            (new Articulos)->setNombre($nombre)
                ->setDescripcion($descripcion)
                ->setPrecio($precio)
                ->setStock($stock)
                ->setImagen($imagen)
                ->create();
        }
    }
    //--------------------------------------------------------------------------------OTROS METODOS -------------------------------


    public static function findArticleById(int $id): null|Articulos
    {
        if (!is_int($id)) return false;
        parent::setConexion();
        $q = "select * from articulos where id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([':i' => $id]);
        } catch (PDOException $ex) {
            die("Error al comprobar id" . $ex->getMessage());
        }
        parent::$conexion = null;

        $stmt->setFetchMode(PDO::FETCH_CLASS, Articulos::class);
        return $stmt->fetch();
    }

    public static function devolverImagen(int $id): string|null
    {
        parent::setConexion();
        $q = "select imagen from articulos where id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([':i' => $id]);
        } catch (PDOException $ex) {
            die("Error el recuperar imagen: " . $ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt->fetch(PDO::FETCH_OBJ)->imagen;
    }

    public static function existeNombre(string $nombre, int|null $id=null):bool{
        parent::setConexion();
        $q=($id==null) ? "select id from articulos where nombre=:n" : "select id from articulos where nombre=:n AND id!=:i";
        $options=($id==null) ? [':n'=>$nombre] : [':n'=>$nombre, ':i'=>$id];
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute($options);
        }catch(PDOException $ex){
            die("error en existeNombre: ".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->rowCount();
    }


    //--------------------------------------------------------------------------------- SETTERS -------------------------------------


    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Set the value of descripcion
     *
     * @return  self
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Set the value of precio
     *
     * @return  self
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Set the value of stock
     *
     * @return  self
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Set the value of imagen
     *
     * @return  self
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }
    //-------------------------------------------------------------------------------------- getters ---------------------------


    /**
     * Get the value of nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Get the value of descripcion
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Get the value of precio
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Get the value of stock
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Get the value of imagen
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }
}
