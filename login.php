<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_abort();
session_start(); 


if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $user = "ingazues";
    $server = "localhost";
    $passWord = "ZKwuHSXxm5GqrFno5CSB";
    $database = "reservasIngazu";
    $conexion = new mysqli($server, $user, $passWord, $database);

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    } 

    $nombre_usuario = $_POST['nombre'];
    $contrasena = $_POST['password'];

    $_SESSION['name'] = $nombre_usuario;

    $sql = "SELECT * FROM usuario WHERE nombre = '$nombre_usuario'";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $hashed_password = $fila['PASSWORD'];
        if ($contrasena == $hashed_password) {
            $mailNewLocation = $fila['nombre'];
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['mensaje'] = "CONTRASEÑA INCORRECTA. INTÉNTALO DE NUEVO";
        }
    } else {
        $_SESSION['mensaje'] = "Usuario no encontrado.";
    }

    $conexion->close();
}


?>

<!DOCTYPE html>
<html lang="en">    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Sesión</title>
    <style>
        #container{
            margin-bottom: 1px;
        }
        #header {
        cursor: pointer;
        text-align: center;
        border: 1px solid black;
        background-color: darkblue;
        color: white;
        padding: 20px;
        
        }
        
        #bienvenida {
        width: 100%;
        text-align: center;
        margin: 10px auto; /* Centra horizontalmente y agrega margen superior e inferior */
        }

        footer {
        width: 100%;
        margin-top: auto;
        text-align: center;
        
        }
        #mensajeError {
            color: red;
            text-align: center;
            margin-top: 10px;
        }

        #dinamicText{
            margin: auto;
            margin-top: 25px;
            margin-bottom: 25px;
            height: 30px;
            text-align: center;
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            font-size: 20px;
        }
        #divVacio{
            height: 125px;
        }
        #divVacio2{
            height: 125px;
        }
        #formulario{
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 900px;
            text-align: center;
            margin: auto;
            box-sizing: border-box;
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-group input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-group input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .bottom-text {
            margin-top: 20px;
            color: #777;
        }

        #mensajeError {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <header id="header">
        <h1>Ingazu LOGIN</h1>
    </header>
    <div id="divVacio"></div>
    <div id="formulario">
    <div id='dinamicText'></div>
    <script>
        var textoOriginal = "Introduce tus claves de sesión";
        
        var elementoTexto = document.getElementById("dinamicText");
        
        var velocidadEscritura = 30;

        function mostrarTextoDinamico(texto, index, callback) {
            if (index < texto.length) {
                elementoTexto.innerHTML += texto.charAt(index);
                index++;
                setTimeout(function() {
                    mostrarTextoDinamico(texto, index, callback);
                }, velocidadEscritura);
            } else {
                if (typeof callback === 'function') {
                    callback();
                }
            }
        }
        mostrarTextoDinamico(textoOriginal, 0);
    </script>
    <form action="" method="post">
    <div class="form-group">
        <label for="nombre">Nombre usuario</label>
        <input type="text" id="email" name="nombre" placeholder="example@example.com" required>
    </div>

    <div class="form-group">
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
    </div>

    <div class="form-group">
        <input type="submit" value="Iniciar Sesión">

    <div id="mensajeError">
        <?php
            if (isset($_SESSION['mensaje'])) {
                echo $_SESSION['mensaje'];
                unset($_SESSION['mensaje']); 
            }
        ?>
    </div>
    <div id="divVacio2"></div>
    </div>
    </div>
    <footer id="footer">
        <p>&copy; 2024 Restaurante Ingazu - Plataforma de Reservas</p>
    </footer>
    <?php
     if (isset($_SESSION['mensaje'])) {
        echo $_SESSION['mensaje'];
        unset($_SESSION['mensaje']); 
    }
    ?>
</body>
</html>