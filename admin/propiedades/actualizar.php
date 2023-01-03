<?php
require '../../includes/funciones.php';
$auth = estaAutenticado();

if(!$auth){
    header('Location: /bienesraices/');
}
//validar un ID valido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if(!$id){
    header('Location: /bienesraices/admin');
}

require '../../includes/config/database.php';
$db = conectarDB();

//consulta para obtener datos de la propiedad
$consulta = "SELECT * FROM propiedades WHERE id = $id";
$resultado = mysqli_query($db, $consulta);
$propiedad = mysqli_fetch_assoc($resultado);

//consulta para obtener los vendedores
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);

//array con mensajes de errores
$errores = [];

$titulo = $propiedad['titulo'];
$precio = $propiedad['precio'];
$descripcion = $propiedad['descripcion'];
$habitaciones = $propiedad['habitaciones'];
$wc = $propiedad['wc'];
$estacionamiento = $propiedad['estacionamiento'];
$vendedor_id = $propiedad['vendedor_id'];
$imagen = $propiedad['imagen'];


//ejecuta el codigo tras enviar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    echo '<pre>';
        var_dump($_POST);
    echo '</pre>';

    $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
    $precio = mysqli_real_escape_string($db, $_POST['precio']);
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string($db, $_POST['wc']);
    $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
    $vendedor_id = mysqli_real_escape_string($db, $_POST['vendedor']);
    $creado = date('Y/m/d');

    //asignamos files hacia una variable
    $imagen = $_FILES['imagen'];



    if (!$titulo) {
        $errores[] = "Debes añadir un título";
    }
    if (!$precio) {
        $errores[] = "Debes añadir un precio";
    }
    if (strlen($descripcion) < 50) {
        $errores[] = "Debes añadir una descripcion de al menos 50 caracteres";
    }
    if (!$habitaciones) {
        $errores[] = "Debes añadir las habitaciones";
    }
    if (!$wc) {
        $errores[] = "Debes añadir un wc";
    }
    if (!$estacionamiento) {
        $errores[] = "Debes añadir un estacionamiento";
    }
    if (!$vendedor_id || $vendedor_id === 0) {
        $errores[] = "Debes añadir un vendedor";
    }
    //validar por tamano (1MB max)
    $medida = 1000 * 1000; //convertimos de bytes a kb
    if ($imagen['size'] > $medida) {
        $errores[] = "El tamaño de la imagen debe ser menor a 100Kb";
    }


    // echo '<pre>';
    // var_dump($_POST);
    // echo '</pre>';
    // exit;

    //revisamos que el array $errores este vacio
    if (empty($errores)) {
        /** subida de archivos*/


        //1. crear carpeta
        $carpetaImagenes = '../../imagenes/';

        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }
        $nombreImagen = '';


        if($imagen['name']){//si hay una imagen nueva a subir
            unlink($carpetaImagenes . $propiedad['imagen']);
            
            //generar un nombre unico
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);

        }else{
            $nombreImagen = $propiedad['imagen'];
        
        }

        //insertar en la bd 
        $query = " UPDATE propiedades SET titulo = '{$titulo}', precio = '{$precio}', imagen = '$nombreImagen', descripcion = '{$descripcion}', habitaciones = {$habitaciones}, wc = {$wc}, estacionamiento = {$estacionamiento}, vendedor_id = {$vendedor_id} WHERE id = $id";

        $resultado = mysqli_query($db, $query);
        if ($resultado) {
            //redireccionar al usuario
            header('Location: /bienesraices/admin?resultado=2');
        }
    }
}

incluirTemplate('header');
?>
<main class="contenedor seccion">
    <h1>Actualizar</h1>

    <a href="/bienesraices/admin/" class="boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>

    <?php endforeach; ?>
    <form method="POST" class="formulario" enctype="multipart/form-data">
        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Título</label>
            <input type="text" name="titulo" id="titulo" placeholder="Título de la Propiedad" value="<?php echo $titulo; ?>">

            <label for="precio">Precio</label>
            <input type="number" name="precio" id="precio" min="1" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

            <label for="imagen">Imágen</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">
            <img src="../../imagenes/<?php echo $imagen; ?>" alt="imagen propiedad" class="imagen-small">
            <label for="descripcion">Descripción</label>
            <!--textarea no tiene value, lo ponemos entre las etiquetas-->
            <textarea name="descripcion" id="descripcion"><?php echo $descripcion; ?></textarea>

        </fieldset>

        <fieldset>
            <legend>Información Propiedad</legend>

            <label for="habitaciones">Habitaciones</label>
            <input type="number" name="habitaciones" id="habitaciones" min="1" max="9" placeholder="Ej: 3" value="<?php echo $habitaciones; ?>">

            <label for="wc">Baños</label>
            <input type="number" name="wc" id="wc" min="1" max="9" placeholder="Ej: 3" value="<?php echo $wc; ?>">

            <label for="estacionamiento">estacionamiento</label>
            <input type="number" name="estacionamiento" id="estacionamiento" min="1" max="9" placeholder="Ej: 3" value="<?php echo $estacionamiento; ?>">
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedor" id="vendedor">
                <option value="">--Seleccione--</option>
                <?php while ($row = mysqli_fetch_assoc($resultado)) : ?>
                    <option <?php echo $vendedor_id === $row['id']  ? 'selected' : ''; ?> value="<?php echo $row['id']; ?>"><?php echo $row['nombre'] . " " . $row['apellido']; ?></option>

                <?php endwhile; ?>
            </select>
        </fieldset>

        <input type="submit" class="boton-verde" value="Actualizar Propiedad">
    </form>
</main>

<?php
incluirTemplate('footer');
?>