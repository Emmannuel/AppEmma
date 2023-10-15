<?php
// Conectar a la base de datos aquí
include('../database/conexion.php');

// Obtener el ID del post y la acción del usuario desde la solicitud AJAX
$postId = $_POST['postId'];
$accion = $_POST['accion'];

// Validar la acción (debe ser "like" o "dislike")
if ($accion !== 'like' && $accion !== 'dislike') {
    http_response_code(400); // Bad Request
    echo json_encode(["message" => "Acción no válida"]);
    exit();
}

// Obtener los valores actuales de likes y dislikes del post
$consulta = "SELECT likes, dislikes FROM secreto WHERE id = ?";
$statement = $conn->prepare($consulta);
$statement->bind_param("i", $postId);
$statement->execute();
$resultado = $statement->get_result();

if ($resultado->num_rows === 1) {
    $fila = $resultado->fetch_assoc();
    $likesActuales = $fila['likes'];
    $dislikesActuales = $fila['dislikes'];

    // Actualizar las variables likes y dislikes en función de la acción
    if ($accion === 'like') {
        $likesNuevos = $likesActuales + 1;
        $dislikesNuevos = $dislikesActuales;
    } elseif ($accion === 'dislike') {
        $likesNuevos = $likesActuales;
        $dislikesNuevos = $dislikesActuales + 1;
    }

    // Actualizar los valores en la tabla secretos
    $consultaActualizar = "UPDATE secreto SET likes = ?, dislikes = ? WHERE id = ?";
    $statementActualizar = $conn->prepare($consultaActualizar);
    $statementActualizar->bind_param("iii", $likesNuevos, $dislikesNuevos, $postId);
    $statementActualizar->execute();

    // Devuelve la respuesta al cliente
    http_response_code(200); // OK
    echo json_encode(["message" => "Acción completada exitosamente", "likes" => $likesNuevos, "dislikes" => $dislikesNuevos]);
} else {
    http_response_code(404); // Not Found
    echo json_encode(["message" => "Post no encontrado"]);
}

mysqli_close($conn);
?>
