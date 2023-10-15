<?php
include("../database/conexion.php");

// Obtiene el usuario y la contraseña del formulario
$usuario = $_POST['nom_usuario'];
$contra = $_POST['contra'];

// Consulta para buscar el usuario en la base de datos
$query = "SELECT * FROM usuario WHERE nom_usuario = '$usuario'";
$result = $conn->query($query);

$response = array(); // Inicializa un array para la respuesta

if ($result->num_rows == 1) {
    // Usuario encontrado, verifica la contraseña
    $row = $result->fetch_assoc();
    $contra_encriptada_db = $row['contra']; // Suponiendo que el campo de contraseña se llama 'contra' en tu base de datos

    if (password_verify($contra, $contra_encriptada_db)) {
        // La contraseña es válida, autentica al usuario
        session_start();

        // Establece las variables de sesión
        $_SESSION['usuario'] = $usuario;
        $_SESSION['nom_usuario'] = $row['nom_usuario'];
        $_SESSION['correo'] = $row['correo'];
        $_SESSION['edad'] = $row['edad'];
        $_SESSION['nombre'] = $row['nombre'];
        $_SESSION['id'] = $row['id'];
        $_SESSION['admin'] = $row['admin']; // Asume que 'administrador' es el campo que almacena si el usuario es administrador o no
        $usu = password_hash($usuario, PASSWORD_DEFAULT);
        // Establece una cookie de sesión con SameSite=None y Secure para permitir contextos de terceros y conexiones seguras
        $expiracion = time() + 86400;
        setcookie("sesion_expira", $usu, [
            'expires' => $expiracion,
            'path' => '/',
            'domain' => '',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'None'
        ]);

        $response['success'] = true;
        $response['message'] = "Acceso correcto";
    } else {
        // La contraseña no es válida
        $response['success'] = false;
        $response['message'] = "La contraseña no concuerda con el usuario";
    }
} else {
    // Usuario no encontrado
    $response['success'] = false;
    $response['message'] = "El usuario no existe" . $conn->error;
}

// Cierra la conexión a la base de datos
$conn->close();

// Envía la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
