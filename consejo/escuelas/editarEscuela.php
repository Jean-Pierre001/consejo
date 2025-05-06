<?php
include '../baseDatos/conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos actuales de la escuela
    $sql = "SELECT * FROM escuelas WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $escuela = $stmt->fetch();
    
    if (!$escuela) {
        // Si no se encuentra la escuela, redirigir
        header("Location: escuelas.php");
        exit();
    }
} else {
    header("Location: escuelas.php");
    exit();
}

// Procesar el formulario al enviar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $directivo = $_POST['directivo'];
    $ciudad = $_POST['ciudad'];

    // Actualizar los datos en la base de datos
    $sql_update = "UPDATE escuelas SET 
                    nombre = :nombre, 
                    direccion = :direccion, 
                    directivo = :directivo, 
                    ciudad = :ciudad 
                   WHERE id = :id";
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->execute([
        'nombre' => $nombre,
        'direccion' => $direccion,
        'directivo' => $directivo,
        'ciudad' => $ciudad,
        'id' => $id
    ]);

    // Redirigir después de actualizar
    header("Location: escuelas.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Escuela</title>
    <link rel="stylesheet" href="estilos/editarEscuela.css"> <!-- Asegúrate de tener este archivo -->
</head>
<body>

<div class="container">
    <header>
        <h1>Editar Escuela</h1>
    </header>

    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($escuela['nombre']); ?>" required>

        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($escuela['direccion']); ?>" required>

        <label for="directivo">Directivo:</label>
        <input type="text" id="directivo" name="directivo" value="<?php echo htmlspecialchars($escuela['directivo']); ?>" required>

        <label for="ciudad">Ciudad:</label>
        <input type="text" id="ciudad" name="ciudad" value="<?php echo htmlspecialchars($escuela['ciudad']); ?>" required>

        <button type="submit" class="btn btn-editar">Actualizar Escuela</button>
    </form>
</div>

</body>
</html>
