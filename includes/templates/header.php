<?php

    if(!isset($_SESSION)){//revisamos que no haya una sesion activa
        session_start(); 
    }
    $auth = $_SESSION['login'] ?? false;



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iWear - Your Eyewear Store</title>
    <link rel="stylesheet" href="/iWear/build/css/app.css">
</head>
<body>
    <header class="header <?php echo $inicio ? 'inicio' : ''; ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/iWear/index.php">
                    <p class="logo">i<span>Wear</span></p>
                </a>
                <div class="mobile-menu">
                    <img src="/iWear/build/img/barras.svg" alt="menu">
                </div>

                <div class="derecha">
                    <img src="/iWear/build/img/dark-mode.svg" alt="" class="dark-mode-boton">
                    <nav class="navegacion">
                        <a href="nosotros.php">Nosotros</a>
                        <a href="anuncios.php">Anuncios</a>
                        <a href="blog.php">Blog</a>
                        <a href="contacto.php">Contacto</a>
                        <?php if($auth): ?>
                            <a href="/iWear/cerrar-session.php">Cerrar Sesión</a>
                        <?php endif; ?>
                    </nav>
                </div>

            </div><!--.barra-->

            <?php if($inicio){ ?>
                <h1>Las gafas hechas moda</h1>
            <?php } ?>    

        </div>
    </header>