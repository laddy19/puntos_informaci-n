<?php
// Incluir el archivo de conexión que acabamos de crear
include 'conexion.php';

// Configurar encabezados para respuestas en formato JSON (ideal para APIs y frontend)
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los datos enviados por el usuario (documento y contraseña)
    $documento = $_POST['documento'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($documento) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "Por favor ingrese el documento y la contraseña."]);
        exit();
    }

    // Consultar el usuario y su rol en la base de datos
    $sql = "SELECT u.id_user, u.documento, u.password_hash, r.nombre_rol 
            FROM tbl_usuarios u 
            JOIN tbl_roles r ON u.rol_id = r.id_rol 
            WHERE u.documento = ?";
            
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $documento);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        // Verificar la contraseña usando password_verify (requerido por RNF02)
        if (password_verify($password, $usuario['password_hash'])) {
            echo json_encode([
                "status" => "success",
                "message" => "Autenticación exitosa",
                "rol" => $usuario['nombre_rol'],
                "id_user" => $usuario['id_user']
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Contraseña incorrecta."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "El usuario no está registrado."]);
    }

    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido."]);
}
?>
