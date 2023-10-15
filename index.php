<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App de Secretos</title>
    <link rel="stylesheet" type="text/css" href="./css/index.css" />
</head>
<body>
<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['usuario'])) {
    // El usuario ya ha iniciado sesión, redirige a la página de inicio de sesión
    header("Location: inicio.php"); // Cambia "pagina_de_inicio.php" al nombre de la página a la que deseas redirigir
    exit();
}
?>
    <div class="container">
        <h1>Bienvenido a la App de Secretos</h1>
        <div id="login-form">
            <form  class="form-group">
            <label for="user">Nombre de Usuario:</label>
            <input type="text" name="user" id="user" required>
            <label for="contra">Contraseña:</label>
            <input type="password" name="contra" id="contra" required>
            <button type="button" onclick="login()" class="custom-button" style="margin-left: 140px">Iniciar Sesión</button>
            </form>
            <div class="register-link">
                ¿No tienes una cuenta? <a href="#" id="show-register" >Regístrate</a>
            </div>
        </div>

        <div id="register-form" style="display: none;">
            <form  class="form-group">
            <label for="nombre" ="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>
            <label for="user">Nombre de Usuario:</label>
            <input type="text" name="user" id="users" required>
            <label for="contra">Contraseña:</label>
            <input type="password" name="contra" id="contras" required>
            <label for="correo">Correo:</label>
            <input type="email" name="correo" id="correo" required>
            <label for="edad">Edad:</label>
            <input type="number" name="edad" id="edad" required>
            <br><br>
            <button type="button" onclick="crearUsuario()" id="registrar" class="custom-button" style="margin-left: 140px">Registrar</button>
            </form>
            <div id="mensaje"></div>
            <div class="login-link">
                ¿Ya tienes una cuenta? <a href="#" id="show-login">Iniciar Sesión</a>
            </div>
        </div>
    </div>
    <script src="./js/index.js"></script>
</body>
</html>
