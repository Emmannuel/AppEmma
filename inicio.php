<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Página de Inicio</title>
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
            <button class="icon-button" onclick="mostrarFormulario()">
                <i class="fas fa-edit"></i> 
            </button>
            <button class="icon-button" onclick="per()">
                <i class="fas fa-user"></i>
            </button>
            <form method="post" class="icon-button">
            <button class="icon-button" name="cerrar_sesion">
                <i class="fas fa-sign-out-alt"></i> 
            </button></form>
        </div>
        <h1>Mi Aplicación de Secretos</h1>

    </div>
    <div class="container">
    <div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarFormulario()">&times;</span>
        <h1>Publicar un Nuevo Post</h1>
        <form id="post-form">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required><br>
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea><br>
        <label for="tema">Tema:</label>
        <select id="tema" name="tema">
            <option value="Vida">Vida</option>
            <option value="Escuela">Escuela</option>
        </select><br>
        <button type="button" onclick="crearPost()" id="registrar" class="custom-button">Publicar</button>
    </form>
    </div>
</div>
    <h2>Posts</h2>
    <div id="posts-container">
        <!-- Aquí se cargarán los posts -->
    </div>
</div>
    <script src="./js/inicio.js"></script>
</body>
</html>
