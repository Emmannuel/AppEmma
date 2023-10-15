<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conecta a la base de datos (ajusta las credenciales)
    include('../database/conexion.php');
    
    $searchTerm = json_decode(file_get_contents("php://input"), true);

    if (is_string($searchTerm)) {
        $searchTerm = '%' . $searchTerm . '%'; // Agrega comodines % para buscar coincidencias parciales

        $sql = "SELECT nom_usuario, correo FROM usuario WHERE nom_usuario LIKE ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $searchTerm); // Enlaza el parámetro

        if ($stmt->execute()) {
            // Obtiene el resultado
            $result = $stmt->get_result();
            $resultados = [];

            while ($row = $result->fetch_assoc()) {
                $resultados[] = $row;
            }
            echo json_encode($resultados);
        } else {
            echo json_encode([]); // Devuelve un arreglo vacío si hay un error en la consulta
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode([]); // Devuelve un arreglo vacío si no se proporciona un término de búsqueda válido
    }
}
?>