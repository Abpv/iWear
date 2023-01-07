<?php

namespace App;

class Propiedad
{
    //BD
    /* 
        protected: ya que solo podemos acceder dentro de la clase
        static: no necesitamos diferentes instancias 
    */ 
    protected static $db; 
    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedor_id;


    public function __construct($args = [])
    {
        //$this hacemos referencia a los atributos public, no usamos $ tras -> 
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? 'imagen.jpg';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedor_id = $args['vendedor_id'] ?? '';
    }
    public function guardar()
    {
        //insertar en la bd
        $query = " INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedor_id) 
                VALUES ('$this->titulo', '$this->precio', '$this->imagen', '$this->descripcion', '$this->habitaciones', 
                '$this->wc', '$this->estacionamiento', '$this->creado', '$this->vendedor_id')";

        $resultado = self::$db->query($query);
        debuguear($resultado);
        
    }
    //metodo conexion a la bd, static ya que usa $db que es static
    public static function setDB($database){
        //self hace referencia a los atributos static de una clase
        self::$db = $database;
    }
}
