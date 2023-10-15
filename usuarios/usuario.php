<?php
// Inicia la sesión si aún no está iniciada
session_start();

// Comprueba si el usuario está autenticado; ajusta esto según tu lógica de autenticación
if (isset($_SESSION['usuario'])) {
    // Conecta a la base de datos (ajusta las credenciales según tu configuración)
    include("../database/conexion.php");
        // Obtiene los valores enviados desde JavaScript
        $nuevoNomUsuario = $_POST['nom_usuario'];
        $nuevoCorreo = $_POST['correo'];
        $nuevaEdad = $_POST['edad'];
        $nuevoNombre = $_POST['nombre'];

        // Actualiza los datos en la base de datos (ajusta esta consulta según tu estructura)
        $sql = "UPDATE usuario SET nom_usuario='$nuevoNomUsuario', correo='$nuevoCorreo', edad=$nuevaEdad, nombre='$nuevoNombre' WHERE id=" . $_SESSION['id'];

        // Ejecuta la consulta (ajusta el método de ejecución según tu base de datos)
        $stmt = $conn->prepare($sql);
        /*$stmt->bind_param('i', $_SESSION['usuario_id']);*/ // Suponiendo que tienes un campo 'id' en tu tabla de usuarios

        if ($stmt->execute()) {
            // Los datos se actualizaron con éxito
            echo 'success';
            $_SESSION['nom_usuario'] = $nuevoNomUsuario;
            $_SESSION['correo'] = $nuevoCorreo;
            $_SESSION['edad'] = $nuevaEdad;
            $_SESSION['nombre'] = $nuevoNombre;
        } else {
            // Hubo un error al actualizar los datos
            echo 'Error al actualizar los datos en la base de datos.';
        }

        // Cierra la conexión a la base de datos
        $stmt->close();
        $conn->close();
} else {
    // El usuario no está autenticado; puedes redirigirlo a la página de inicio de sesión
    header("Location: index.php");
}
?>
