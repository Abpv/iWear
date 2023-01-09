<?php

namespace App;

class ActiveRecord{

    //BD
    /* 
        protected: ya que solo podemos acceder dentro de la clase
        static: no necesitamos diferentes instancias 
    */
    protected static $db;
    protected static $columnasDB =[];
    protected static $tabla = '';

    //Validacion
    protected static $errores = [];



    //metodo conexion a la bd, static ya que usa $db que es static
    public static function setDB($database)
    {
        //self hace referencia a los atributos static de una clase
        self::$db = $database;
    }

    public function guardar()
    {
        if (!is_null($this->id)) { //si hay id actualiza
            $this->actualizar();
        } else { //si no hay id, crea un nuevo registro
            $this->crear();
        }
    }
    public function crear()
    {
        //sanitizar los datos
        $atributos = $this->sanitizarAtributos(); //llamamos a un m dentro de la misma clase con $this->metodo()

        $string = join(', ', array_values($atributos));

        //insertar en la bd
        $query = " INSERT INTO " . static::$tabla . " (";
        $query .= join(', ', array_keys($atributos)); //join crea un string de un array
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ')";


        $resultado = self::$db->query($query);
        if ($resultado) {
            //redireccionar al usuario si el query es correcto
            header('Location: /bienesraices/admin?resultado=1');
        }
    }
    public function actualizar()
    {
        //sanitizar los datos
        $atributos = $this->sanitizarAtributos(); 
        $valores = [];
        foreach($atributos as $key => $value){//accedemos a las llaves y valores del array atributos ya sanitizado
            $valores[] = "$key='$value'";
        }
        //insertar en la bd 
        $query = " UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id). "' ";
        $query .= " LIMIT 1 ;";

        $resultado = self::$db->query($query);
        
        if ($resultado) {
            //redireccionar al usuario
            header('Location: /bienesraices/admin?resultado=2');
        }        
    }
    public function eliminar(){
        $query = " DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1;";
        $resultado = self::$db->query($query);
        
        if($resultado){
            $this->borrarImagen();
            header('location: /bienesraices/admin?resultado=3');
        }

    }
    //se encarga de iterar sobre columnasdb para indentificar y unir los atributos de la BD
    public function getAtributos()
    {
        $atributos = [];
        foreach (self::$columnasDB as $columna) {
            if ($columna === 'id') continue; //lo ignora y continua con el foreach

            $atributos[$columna] = $this->$columna; //al ser una variable lleva el $
        }
        return $atributos;
    }

    public function sanitizarAtributos()
    {
        $atributos = $this->getAtributos();
        $sanitizado = [];

        foreach ($atributos as $key => $value) { //iterar un array asociativo
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
    public function setImagen($imagen)
    {
        //elimina imagen previa
        if (!is_null($this->id)) { //si hay un id
            $this->borrarImagen();
        } //tras eliminar el archivo, asigna el nuevo 

        //asignar atributo imagen al objeto 
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }
    //eliminar archivo
    public function borrarImagen(){
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if ($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen); //unlink elimina el archivo que le digamos
        }
    }

    //validacion
    public static function getErrores()
    {
        return self::$errores;
    }

    public function validar()
    {
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
    //lista todos los registros
    public static function getAll()
    {
        $query = "SELECT * FROM " . static::$tabla; //static 
        $resultado = self::consultarSQL($query);

        return $resultado;
    }
    //busca un registro por su id
    public static function find($id)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = $id";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado); //array_shift nos devuelve el primer elemento de un array
    }

    public static function consultarSQL($query)
    {
        //consultar bd
        $resultado = self::$db->query($query);

        //iterar resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) { //nos devuelve un array asociativo
            $array[] = self::crearObjeto($registro); //es un array que pasaremos a objeto con el metodo
        }
        //liberar la memoria
        $resultado->free();

        //retornar los resultados
        return $array;
    }
    //Necesitamos objetos para usar active records
    protected static function crearObjeto($registro)
    {
        $objeto = new static; //creamos objeto de la clase que está heredando el metodo

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) { //compara si el objeto creado tiene un id
                $objeto->$key = $value; //cuando se cumpla la condicion, mapea los datos de array a objetos
            }
        }
        return $objeto;
    }

    //sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar($args = [])
    {
        //comparamos el obj actual en memoria con el array de lo introducido por el usuario
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) { //mapea las propiedades del array al objeto
                $this->$key = $value; //escribe las que sean nuevas
            }
        }
    }

}
