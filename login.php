<?php
    require 'includes/app.php';
    $db = conectarDB();

    //autenticacion y validacion
    $errores = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email = mysqli_real_escape_string(
            $db, 
            filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
        
        $password = mysqli_real_escape_string(
            $db,
            $_POST['password']);

        if(!$email){
            $errores[] = "El email es obligatorio o no es válido";
        }
        if(!$password){
            $errores[] = "La contraseña es obligatoria";
        }

        if(empty($errores)){
            //revisar si el usuario existe
            $query = "SELECT * FROM usuarios WHERE email = '$email' ";
            $resultado = mysqli_query($db, $query);

            if($resultado->num_rows){
                //almacenar resultado en usuario
                $usuario = mysqli_fetch_assoc($resultado);
                
                //verificar si el password es correcto
                $auth = password_verify($password, $usuario['password']);
                if($auth){
                    session_start();
                    
                    $_SESSION['usuario'] = $usuario['email'];
                    $_SESSION['login'] = true;

                    header('Location: /bienesraices/admin');

                }else{
                    $errores[] = "La contraseña no es válida";
                }
            }else{
                $errores[] = "El usuario no existe";
            }
        }
    }

    

    incluirTemplate('header');
?>
    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesión</h1>
        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>    
        <form method='POST' action="" class="formulario">
        <fieldset>
            <legend>Email y Password</legend>          
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required placeholder="Tu Email">

                <label for="password">Password</label>
                <input type="password" name="password" id="password" required placeholder="******">
            </fieldset>
            <input type="submit" value="Iniciar Sesión" class="boton-verde">
        </form>
    </main>

<?php
    incluirTemplate('footer');
?>