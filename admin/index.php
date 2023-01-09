<?php
    require '../includes/app.php';
    estaAutenticado();

    use App\Propiedad; //importamos la clase Propiedad
    use App\Vendedor;

    //usamos active records para obtener las propiedades
    $propiedades = Propiedad::getAll();
    $vendedores = Vendedor::getAll();
    
    debuguear($propiedades);
    //muestra mensaje condicional
    $resultado = $_GET['resultado'] ?? null; //busca resultado y si no existe le asigna null

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id){
            $propiedad = Propiedad::find($id);           
            $propiedad->eliminar();
      
        }

    }

    //incluye un template
    incluirTemplate('header');
?>
    <main class="contenedor seccion">
        <h1>Administrador de BienesRaices</h1>
        <?php if(intval($resultado) === 1) : ?> 
            <p class="alerta exito">Anuncio Creado Correctamente</p>    
        <?php elseif(intval($resultado) ===2) : ?>
            <p class="alerta exito">Anuncio Actualizado Correctamente</p>    

        <?php endif; ?>
        <a href="/bienesraices/admin/propiedades/crear.php" class="boton-verde">Nueva Propiedad</a>
        
        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <!--Mostrar resultados-->
            <tbody>
                <?php foreach($propiedades as $propiedad ) : ?>
                
                <tr>
                    <td><?php echo $propiedad->id; ?></td>
                    <td><?php echo $propiedad->titulo; ?></td>
                    <td><img src="/bienesraices/imagenes/<?php echo $propiedad->imagen;?>" class="imagen-tabla"></td>
                    <td><?php echo $propiedad->precio; ?></td>
                    <td>
                        <form action="" method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" 
                            class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

<?php
    //cerrar conexion
    mysqli_close($db);


    incluirTemplate('footer');
?>