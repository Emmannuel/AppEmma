<?php
// Conectar a tu base de datos aquí
include('../database/conexion.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener los datos del nuevo post desde la solicitud
    date_default_timezone_set("America/Mexico_City");
    $data = json_decode(file_get_contents("php://input"));

    // Validación básica de campos
    if (empty($data->titulo) || empty($data->descripcion) || empty($data->tema)) {
        http_response_code(400); // Bad Request
        echo json_encode(["message" => "Por favor, complete todos los campos."]);
        exit();
    }

    // Obtener la fecha y hora actual
    $fechaHoraActual = date("H:i:s");
    $fecha = date("Y-m-d");

    // Guardar el nuevo post en la base de datos
    // Debes implementar la lógica de inserción en tu base de datos
    // Asumiendo que estás utilizando MySQLi, aquí hay un ejemplo de inserción:

    $titulo = mysqli_real_escape_string($conn, $data->titulo);
    $descripcion = mysqli_real_escape_string($conn, $data->descripcion);
    $tema = mysqli_real_escape_string($conn, $data->tema);

    $query = "INSERT INTO secreto (titulo, descripccion, tema, time, fecha) VALUES ('$titulo', '$descripcion', '$tema', '$fechaHoraActual', '$fecha')";
    
    if (mysqli_query($conn, $query)) {
        // Inserción exitosa
        $postGuardado = [
            "titulo" => $titulo,
            "descripcion" => $descripcion,
            "tema" => $tema,
            "time" => $fechaHoraActual,
            "fecha" => $fecha
        ];

        // Envía una respuesta exitosa al cliente
        http_response_code(200);
        echo json_encode(["message" => "Post creado exitosamente", "post" => $postGuardado]);
    } else {
        // Error en la inserción
        http_response_code(500); // Internal Server Error
        echo json_encode(["message" => "Error al crear el post: " . mysqli_error($conn)]);
    }

    // Cierra la conexión a la base de datos
    mysqli_close($conn);
} else {
    // No se permiten solicitudes que no sean POST
    http_response_code(405); // Method Not Allowed
    echo json_encode(["message" => "Método no permitido"]);
}
?>
