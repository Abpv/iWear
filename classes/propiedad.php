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
    
    //Validacion
    protected static $errores = [];
    
    
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
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedor_id = $args['vendedor_id'] ?? 1;
    }
    public function guardar()
    {
        //sanitizar los datos
        $atributos = $this->sanitizarAtributos(); //llamamos a un m dentro de la misma clase con $this->metodo()

        $string = join(', ', array_values($atributos));

        //insertar en la bd
        $query = " INSERT INTO propiedades (";
        $query .= join(', ', array_keys($atributos)); //join crea un string de un array
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ')";


        $resultado = self::$db->query($query);
        return $resultado;
        
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

    //Subida de archivos
    public function setImagen($imagen){
        //asignar atributo imagen nombre imagen
        if($imagen){
            $this->imagen = $imagen;
        }

    }

    //validacion
    public static function getErrores(){
        return self::$errores; 
    }
    
    public function validar(){
        if (!$this->titulo) {
            self::$errores[] = "Debes añadir un título";
        }

        if (!$this->precio) {
            self::$errores[] = "Debes añadir un precio";
        }
        if (strlen($this->descripcion) < 50) {
            self::$errores[] = "Debes añadir una descripcion de al menos 50 caracteres";
        }
        if (!$this->habitaciones) {
            self::$errores[] = "Debes añadir las habitaciones";
        }
        if (!$this->wc) {
            self::$errores[] = "Debes añadir un wc";
        }
        if (!$this->estacionamiento) {
            self::$errores[] = "Debes añadir un estacionamiento";
        }
        if (!$this->vendedor_id || $this->vendedor_id === 0) {
            self::$errores[] = "Debes elegir un vendedor";
        }
    
        if (!$this->imagen) {
            self::$errores[] = "La imagen es obligatoria";
        }
       
        return self::$errores;
    }
    //lista todas las propiedades
    public static function getAll(){
        $query = "SELECT * FROM propiedades";
        $resultado = self::consultarSQL($query); 
       
        return $resultado;
    }

    public static function consultarSQL($query){
        //consultar bd
        $resultado = self::$db->query($query);

        //iterar resultados
        $array = [];
        while($registro = $resultado->fetch_assoc() ){//nos devuelve un array asociativo
            $array[] = self::crearObjeto($registro); //es un array que pasaremos a objeto con el metodo
        }
        //liberar la memoria
        $resultado->free();
        
        //retornar los resultados
        return $array;
    }
    //Necesitamos objetos para usar active records
    protected static function crearObjeto($registro){
        $objeto = new self;

        foreach($registro as $key => $value){
            if(property_exists($objeto, $key)){ //compara si el objeto creado tiene un id
                $objeto->$key = $value; //cuando se cumpla la condicion, mapea los datos de array a objetos
            }
        }
        return $objeto;
    }   
}
