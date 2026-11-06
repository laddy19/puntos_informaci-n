<?php
// Incluir la conexión a la base de datos
include 'conexion.php';

// Configurar encabezados para respuestas en formato JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Recibir el ID o código del alumno por la URL (ej: malla.php?id_user=1)
    $id_user = $_GET['id_user'] ?? '';

    if (empty($id_user)) {
        echo json_encode(["status" => "error", "message" => "No se especificó el usuario alumno."]);
        exit();
    }

    // Consultar las asignaturas y su estado académico asociadas al alumno
    // (Simulando la integración con los servicios académicos descritos en el SRS)
    $sql = "SELECT asignatura, creditos, estado, semestre 
            FROM tbl_malla_curricular 
            WHERE id_user = ?";
            
    // Nota: Si la tabla específica de asignaturas se creará próximamente, 
    // este endpoint retornará la estructura JSON lista para el frontend del kiosco.
    
    echo json_encode([
        "status" => "success",
        "id_user" => $id_user,
        "mensaje" => "Estructura de malla curricular lista para renderizar en el kiosco."
    ]);

    $conexion->close();
} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido."]);
}
?>
