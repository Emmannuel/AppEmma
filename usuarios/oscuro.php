<?php
// Conecta a tu base de datos (ajusta las credenciales según tu configuración)
include("../database/conexion.php");
// Verificar si el usuario ha enviado una preferencia de modo oscuro
if (isset($_GET['dark_mode'])) {
    $darkModePreference = intval($_GET['dark_mode']); // Obtener la preferencia del usuario
    
    // Obtener el ID de usuario (ajusta esto según tu lógica de autenticación)
    session_start();
    $usuario_id = $_SESSION['id']; // Supongamos que tienes un ID de usuario en la sesión.
    
    // Actualiza la preferencia de modo oscuro en la base de datos
    $sql = "UPDATE usuario SET dark_mode = $darkModePreference WHERE id = $usuario_id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Preferencia de modo oscuro guardada con éxito";
    } else {
        echo "Error al guardar la preferencia de modo oscuro: " . $conn->error;
    }
    
    $conn->close();
}
?>