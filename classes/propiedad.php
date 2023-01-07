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

    //iteramos sobre las propiedades para realizar la sanita
    protected static $columnasDB = 
            [
            'id', 'titulo', 'precio', 'imagen', 'descripcion',
            'habitaciones','wc', 'estacionamiento', 'creado', 'vendedor_id'
            ]; 

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

    //metodo conexion a la bd, static ya que usa $db que es static
    public static function setDB($database)
    {
        //self hace referencia a los atributos static de una clase
        self::$db = $database;
    }


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
        //sanitizar los datos
        $atributos = $this->sanitizarAtributos(); //llamamos a un m dentro de la misma clase con $this->metodo()

        //insertar en la bd
        $query = " INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedor_id) 
                VALUES ('$this->titulo', '$this->precio', '$this->imagen', '$this->descripcion', '$this->habitaciones', 
                '$this->wc', '$this->estacionamiento', '$this->creado', '$this->vendedor_id')";

        $resultado = self::$db->query($query);
        
    }
    //se encarga de iterar sobre columnasdb para indentificar y unir los atributos de la BD
    public function getAtributos(){
        $atributos = [];
        foreach(self::$columnasDB as $columna) {
            if($columna === 'id') continue; //lo ignora y continua con el foreach

            $atributos[$columna] = $this->$columna; //al ser una variable lleva el $
        } 
        return $atributos;

    }
    public function sanitizarAtributos(){
        $atributos = $this->getAtributos();
        $sanitizado =[];

        foreach($atributos as $key => $value){ //iterar un array asociativo
            /*
                Viene a sustituir: $titulo = mysqli_real_escape_string($db, $_POST['titulo']); 
                Recorremos el array con los atributos, y con cada atributo le aplicamos la sanitizacion
                con escape_string, usando la conexion creada anteriormente.
                Se sanitiza solo los valores, las llaves no hace falta
            */
            $sanitizado[$key] = self::$db->escape_string($value);   
        } 
        return $sanitizado;
    }
}
