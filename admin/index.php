<?php
    require '../includes/funciones.php';
    $auth = estaAutenticado();

    if(!$auth){
        header('Location: /bienesraices/');
    }

    /*CONEXION BASE DATOS*/
    //importamos la conexion
    require '../includes/config/database.php';
    $db = conectarDB();
    //escribimos query
    $query = "SELECT * FROM propiedades";
    //consultar bd
    $rs = mysqli_query($db, $query);
    

    //muestra mensaje condicional
    $resultado = $_GET['resultado'] ?? null; //busca resultado y si no existe le asigna null

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id){
            //elimina la imagen
            $query = "SELECT imagen FROM propiedades WHERE id = $id";
            $resultado = mysqli_query($db, $query);
            $propiedad = mysqli_fetch_assoc($resultado);
            unlink('../imagenes/' . $propiedad['imagen']);

            //elimina la propiedad
            $query = "DELETE FROM propiedades WHERE id = $id";
            $resultado = mysqli_query($db, $query);
           
            
            

          

            if($resultado){
                header('location: /bienesraices/admin');
            }
        
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
                <?php while($propiedad = mysqli_fetch_assoc($rs)) : ?>
                
                <tr>
                    <td><?php echo $propiedad['id']; ?></td>
                    <td><?php echo $propiedad['titulo']; ?></td>
                    <td><img src="/bienesraices/imagenes/<?php echo $propiedad['imagen'];?>" class="imagen-tabla"></td>
                    <td><?php echo $propiedad['precio']; ?></td>
                    <td>
                        <form action="" method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad['id']; ?>">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="propiedades/actualizar.php?id=<?php echo $propiedad['id']; ?>" 
                            class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>

<?php
    //cerrar conexion
    mysqli_close($db);


    incluirTemplate('footer');
?>