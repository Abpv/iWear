<?php
    $resultado = $_GET['resultado'] ?? null; //busca resultado y si no existe le asigna null

    require '../includes/funciones.php';
    incluirTemplate('header');
?>
    <main class="contenedor seccion">
        <h1>Administrador de BienesRaices</h1>
        <?php if(intval($resultado) === 1): ?> 
            <p class="alerta exito">Anuncio Creado Correctamente</p>    
        <?php endif; ?>
        <a href="/bienesraices/admin/propiedades/crear.php" class="boton-verde">Nueva Propiedad</a>
    </main>

<?php
    incluirTemplate('footer');
?>