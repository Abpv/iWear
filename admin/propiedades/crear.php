<?php
require '../../includes/app.php';

use App\Propiedad;
use Intervention\Image\ImageManagerStatic as Image;

$propiedad = new Propiedad;

estaAutenticado();

$db = conectarDB();

//consulta para obtener los vendedores
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);

//array con mensajes de errores
$errores = Propiedad::getErrores();

//ejecuta el codigo tras enviar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //creamos nueva instancia de propiedad cuando recibamos el post
    $propiedad = new Propiedad($_POST['propiedad']);

    /** subida de archivos*/
    
    //1. generar un nombre unico para la imagen
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

    //2. formatear imagen si existe
    if($_FILES['propiedad']['tmp_name']['imagen']){
        $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600); //redimensionamos la img
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
        $propiedad->guardar(); //guardar devuelve true o false si el query es correcto o no


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
        <?php include '../../includes/templates/formulario_propiedades.php'; ?>

        <input type="submit" class="boton-verde" value="Crear Propiedad">
    </form>
</main>

<?php
incluirTemplate('footer');
?>