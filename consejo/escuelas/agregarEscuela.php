<?php
include '../baseDatos/conexion.php';

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $directivo = $_POST['directivo'];
    $ciudad = $_POST['ciudad'];

    // Consulta para insertar el nuevo Escuela
    $sql_insert = "INSERT INTO escuelas (nombre, direccion, directivo, ciudad) 
                   VALUES (:nombre, :direccion, :directivo, :ciudad)";
    $stmt_insert = $pdo->prepare($sql_insert);
    $stmt_insert->execute([
        'nombre' => $nombre,
        'direccion' => $direccion,
        'directivo' => $directivo,
        'ciudad' => $ciudad
    ]);

    // Redirigir a la lista de escuelas después de agregar
    header("Location: escuelas.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Escuela</title>
    <link rel="stylesheet" href="estilos/agregarEscuela.css"> <!-- Enlace al archivo CSS -->
</head>
<body>

    <div class="container">
        <header>
            <h1>Agregar Nuevo Escuela</h1>
        </header>

        <!-- Formulario para agregar un nuevo Escuela -->
        <form action="" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="direccion">Direccion:</label>
            <input type="text" id="direccion" name="direccion" required>

            <label for="directivo">Directivo:</label>
            <input type="text" id="directivo" name="directivo" required>

            <label for="ciudad">Ciudad:</label>
            <input type="text" id="ciudad" name="ciudad" required>

            <button type="submit" class="btn btn-agregar">Agregar Escuela</button>
        </form>
    </div>

</body>
</html>
