<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conecta a la base de datos (ajusta las credenciales)
    include('../database/conexion.php');
    
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    if (isset($data['searchTerm']) && is_string($data['searchTerm'])) {
        $searchTerm = '%' . $data['searchTerm'] . '%'; // Agrega comodines % para buscar coincidencias parciales

        $sql = "SELECT nom_usuario, correo FROM usuario WHERE nom_usuario LIKE ?";
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
            echo json_encode(['error' => 'Error al ejecutar la consulta SQL.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Término de búsqueda no válido']);
    }

    $conn->close();
}
?>
