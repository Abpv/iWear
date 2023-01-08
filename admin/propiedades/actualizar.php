<?php

use App\Propiedad;
use Intervention\Image\ImageManagerStatic as Image;

require '../../includes/app.php';
estaAutenticado();

//validar un ID valido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if(!$id){
    header('Location: /bienesraices/admin');
}
$propiedad = Propiedad::find($id); //devuelve un objeto con la propiedad

//consulta para obtener los vendedores
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);

//array con mensajes de errores
$errores = Propiedad::getErrores();

//ejecuta el codigo tras enviar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //asignar los atributos
    $args = $_POST['propiedad']; //almacenamos en el array todos los post que tengan propiedad[] en el form

    // $args['titulo'] = $_POST['titulo'] ?? null;
    // $args['precio'] = $_POST['precio'] ?? null;

    //mapea las propiedades del objeto $propiedad con el array $args
    $propiedad->sincronizar($args); 
    
    //validacion
    $errores = $propiedad->validar();

    //subida de archivos
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

    if($_FILES['propiedad']['tmp_name']['imagen']){
        $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600); //redimensionamos la img
        $propiedad->setImagen($nombreImagen); //pasamos el nombre de la img para que sea enviada a la bd
    }

    //revisamos que el array $errores este vacio y pasamos la validacion
    if (empty($errores)) {
        //almacenar imagen
        if($_FILES['propiedad']['tmp_name']['imagen']){
            $image->save(CARPETA_IMAGENES . $nombreImagen);
        }
        $propiedad -> guardar();
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
        <?php include '../../includes/templates/formulario_propiedades.php'; ?>

        <input type="submit" class="boton-verde" value="Actualizar Propiedad">
    </form>
</main>

<?php
incluirTemplate('footer');
?>