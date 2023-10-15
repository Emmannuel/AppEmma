<?php
// Conectar a la base de datos (ajusta los detalles de conexión)
include('../database/conexion.php');

// Verificar si se ha enviado el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario de registro
    $nombre = $_POST["nombre"];
    $nom_usuario = $_POST["nom_usuario"];
    $contra = password_hash($_POST["contra"], PASSWORD_DEFAULT); // Hash de la contraseña
    $correo = $_POST["correo"];
    $edad = $_POST["edad"];
    $admin = "no"; // Valor por defecto

    // Insertar los datos en la base de datos
    $sql = "INSERT INTO usuario (nombre, nom_usuario, contra, correo, edad, admin) 
            VALUES ('$nombre', '$nom_usuario', '$contra', '$correo', $edad, '$admin')";

    $response = [];

    if ($conn->query($sql) === TRUE) {
        $response["success"] = true;
        $response["message"] = "Registro exitoso";
    } else {
        $response["success"] = false;
        $response["message"] = "Error al registrar: " . $conn->error;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>