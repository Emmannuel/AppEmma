<?php
// Conectar a tu base de datos aquí
include('../database/conexion.php');

$query = "SELECT * FROM secreto ORDER BY id DESC"; // Esto ordenará los resultados por ID de forma descendente

$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Itera a través de los resultados y crea un array de posts
    $posts = array();
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }

    // Devuelve los posts como respuesta JSON
    echo json_encode(["posts" => $posts]);
} else {
    echo json_encode(["posts" => []]); // Si no hay posts, devuelve un array vacío
}
// Cierra la conexión a la base de datos
mysqli_close($conn);
?>

