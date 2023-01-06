<?php

//importar conexion
require 'includes/app.php';
$db = conectarDB();

//crear email y password
$email = "correo@correo.com";
$password = "123456";

//hasheamos el password
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

//crear usuario con un query
$query = "INSERT INTO usuarios (email, password) 
        VALUES ('$email', '$passwordHash');";

// echo $query;

//agregar a la base de datos
mysqli_query($db, $query);
