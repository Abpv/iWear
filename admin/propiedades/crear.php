<?php

    require '../../includes/config/database.php';
    $db = conectarDB();
    
    //array con mensajes de errores
    $errores = [];

    //ejecuta el codigo tras enviar el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        // echo '<pre>';
        //     var_dump($_POST);
        // echo '</pre>';

        $titulo = $_POST['titulo'];
        $precio = $_POST['precio'];
        $descripcion = $_POST['descripcion'];
        $habitaciones = $_POST['habitaciones'];
        $wc = $_POST['wc'];
        $estacionamiento = $_POST['estacionamiento'];
        $vendedor_id = $_POST['vendedor'];

        if(!$titulo ){
            $errores[] = "Debes añadir un título";
        }
        if(!$precio ){
            $errores[] = "Debes añadir un precio";
        }
        if(strlen($descripcion) < 50 ){
            $errores[] = "Debes añadir una descripcion de al menos 50 caracteres";
        }
        if(!$habitaciones ){
            $errores[] = "Debes añadir las habitaciones";
        }
        if(!$wc ){
            $errores[] = "Debes añadir un wc";
        }
        if(!$estacionamiento ){
            $errores[] = "Debes añadir un estacionamiento";
        }
        if(!$vendedor_id || $vendedor_id === 0){
            $errores[] = "Debes añadir un vendedor";
        }

        // echo '<pre>';
        //     var_dump($vendedor_id);
        // echo '</pre>';
        // // exit;

        //revisamos que el array $errores este vacio
        if(empty($errores)){
            //insertar en la bd
            $query = " INSERT INTO propiedades (titulo, precio, descripcion, habitaciones, wc, estacionamiento, vendedor_id) 
                VALUES ('$titulo', '$precio', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$vendedor_id')";
        
            $resultado = mysqli_query($db, $query);
            if($resultado){
                echo 'insertado correctamente';
            }
        }




    }
    require '../../includes/funciones.php';
    incluirTemplate('header');
?>
    <main class="contenedor seccion">
        <h1>Crear</h1>

        <a href="/bienesraices/admin/" class="boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>

        <?php endforeach; ?>
        <form action="/bienesraices/admin/propiedades/crear.php" method="POST" class="formulario">
            <fieldset>
                <legend>Información General</legend>

                <label for="titulo">Título</label>
                <input type="text" name="titulo" id="titulo" placeholder="Título de la Propiedad">

                <label for="precio">Precio</label>
                <input type="number" name="precio" id="precio" min="1" placeholder="Precio Propiedad">

                <label for="imagen">Imágen</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png">

                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion"></textarea>

            </fieldset>

            <fieldset>
                <legend>Información Propiedad</legend>

                <label for="habitaciones">Habitaciones</label>
                <input type="number" name="habitaciones" id="habitaciones" min="1" max="9" placeholder="Ej: 3">

                <label for="wc">Baños</label>
                <input type="number" name="wc" id="wc" min="1" max="9" placeholder="Ej: 3">

                <label for="estacionamiento">estacionamiento</label>
                <input type="number" name="estacionamiento" id="estacionamiento" min="1" max="9" placeholder="Ej: 3">
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>

                <select name="vendedor" id="vendedor">
                    <option value="0">--Seleccione--</option>
                    <option value="1">Juan</option>
                    <option value="2">Karen</option>
                </select>
            </fieldset>

            <input type="submit" class="boton-verde" value="Crear Propiedad">
        </form>
    </main>

<?php
    incluirTemplate('footer');
?>