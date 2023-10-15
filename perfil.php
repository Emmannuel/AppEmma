<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" type="text/css" href="./css/inicio.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<?php
session_start();
// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    // El usuario ya ha iniciado sesión, redirige a la página de inicio de sesión
    header("Location: index.php"); // Cambia "pagina_de_inicio.php" al nombre de la página a la que deseas redirigir
    exit();
}
function cerrarSesion() {
    session_unset(); // Elimina todas las variables de sesión
    session_destroy(); // Destruye la sesión
    setcookie(session_name(), "", time() - 3600, "/"); // Expira la cookie de sesión
    header("Location: index.php"); // Redirige al formulario de inicio de sesión
    exit();
}

if (isset($_POST['cerrar_sesion'])) {
    cerrarSesion();
}
?>
    <div class="top-bar">
        <div class="top-right">
            <form method="post" class="icon-button">
            <button class="icon-button" name="cerrar_sesion">
                <i class="fas fa-sign-out-alt"></i> 
            </button></form>
        </div>
        <h1>Perfil de Usuario</h1>

    </div>
    <div class="container">
    <h1 align="center">Perfil de Usuario</h1>
    <button class="icon-button-p" onclick="editUsers()"><i class="fas fa-edit"></i></button>
    <div class="perfil-edit">
        <p id="username">Nombre de usuario: <?php echo $_SESSION['nom_usuario']; ?></p>
        <p id="email">Correo electrónico: <?php echo $_SESSION['correo']; ?></p>
        <p id="age">Edad: <?php echo $_SESSION['edad']; ?></p>
        <p id="name">Nombre: <?php echo $_SESSION['nombre']; ?></p>
    </div>
    <div id="botones"></div>
    </div>
    <div class="container">
        <div class="perfil-edit" id="buscarUsuarios">
        <h2>Buscar Usuarios</h2>
        <form id="formBusqueda">
            <input type="text" id="busqueda" placeholder="Nombre de usuario">
            <button type="submit">Buscar</button>
        </form>
        <div id="resultados">
            <!-- Aquí se mostrarán los resultados de la búsqueda -->
        </div>
        </div>
    </div>
<?php
echo '<script>';
echo 'var nomUsuario = "' . $_SESSION['nom_usuario'] . '";';
echo 'var correo = "' . $_SESSION['correo'] . '";';
echo 'var edad = "' . $_SESSION['edad'] . '";';
echo 'var nombre = "' . $_SESSION['nombre'] . '";';
echo '</script>';
?>
<script src="./js/perfil.js"></script>
</body>
</html>