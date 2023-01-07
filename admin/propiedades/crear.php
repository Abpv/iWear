<?php
require '../../includes/app.php';

use App\Propiedad;
use Intervention\Image\ImageManagerStatic as Image;

estaAutenticado();

$db = conectarDB();

//consulta para obtener los vendedores
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);

//array con mensajes de errores
$errores = Propiedad::getErrores();

$titulo = '';
$precio = '';
$descripcion = '';
$habitaciones = '';
$wc = '';
$estacionamiento = '';
$vendedor_id = '';


//ejecuta el codigo tras enviar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //creamos nueva instancia de propiedad cuando recibamos el post
    $propiedad = new Propiedad($_POST);

    /** subida de archivos*/
    
    //1. generar un nombre unico para la imagen
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

    //2. formatear imagen si existe
    if($_FILES['imagen']['tmp_name']){
        $image = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 600); //redimensionamos la img
        $propiedad->setImagen($nombreImagen); //pasamos el nombre de la img para que sea enviada a la bd

    }

    //validar
    $errores = $propiedad->validar();

    //revisamos que el array $errores este vacio
    if (empty($errores)) {
        
        
        //3. crear carpeta para subir las imagenes 
        if(!is_dir(CARPETA_IMAGENES)){
            mkdir(CARPETA_IMAGENES);
        }

        //4. guardar img en el servidor
        $image->save(CARPETA_IMAGENES . $nombreImagen); //guarda img en el servidor. save metodo de intervention/image 
        $resultado = $propiedad->guardar(); //guardar devuelve true o false si el query es correcto o no


        if ($resultado) {
            //redireccionar al usuario si el query es correcto
            header('Location: /bienesraices/admin?resultado=1');
        }
    }
}
incluirTemplate('header');
?>
<main class="contenedor seccion">
    <h1>Crear</h1>

    <a href="/bienesraices/admin/" class="boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>

    <?php endforeach; ?>
    <form action="/bienesraices/admin/propiedades/crear.php" method="POST" class="formulario" enctype="multipart/form-data">
        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Título</label>
            <input type="text" name="titulo" id="titulo" placeholder="Título de la Propiedad" value="<?php echo $titulo; ?>">

            <label for="precio">Precio</label>
            <input type="number" name="precio" id="precio" min="1" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

            <label for="imagen">Imágen</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

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

            <select name="vendedor_id" id="vendedor">
                <option value="">--Seleccione--</option>
                <?php while ($row = mysqli_fetch_assoc($resultado)) : ?>
                    <option <?php echo $vendedor_id === $row['id']  ? 'selected' : ''; ?> value="<?php echo $row['id']; ?>"><?php echo $row['nombre'] . " " . $row['apellido']; ?></option>

                <?php endwhile; ?>
            </select>
        </fieldset>

        <input type="submit" class="boton-verde" value="Crear Propiedad">
    </form>
</main>

<?php
incluirTemplate('footer');
?>