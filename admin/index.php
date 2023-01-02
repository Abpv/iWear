<?php
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

    //incluye un template
    require '../includes/funciones.php';
    incluirTemplate('header');
?>
    <main class="contenedor seccion">
        <h1>Administrador de BienesRaices</h1>
        <?php if(intval($resultado) === 1): ?> 
            <p class="alerta exito">Anuncio Creado Correctamente</p>    
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
                <?php while($row = mysqli_fetch_assoc($rs)) : ?>

                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['titulo']; ?></td>
                    <td><img src="/bienesraices/imagenes/<?php echo $row['imagen'];?>" class="imagen-tabla"></td>
                    <td><?php echo $row['precio']; ?></td>
                    <td>
                        <a href="#" class="boton-rojo-block">Eliminar</a>
                        <a href="#" class="boton-amarillo-block">Actualizar</a>
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