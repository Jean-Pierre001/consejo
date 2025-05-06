<?php
require_once '../baseDatos/conexion.php';

$cue = isset($_POST['cue']) ? $_POST['cue'] : '';

$sql = "SELECT id, CUE, turno, servicio, direccion, localidad, telefono, correo_electronico, directivo FROM escuelas WHERE 1=1";

// Filtrar por CUE si se ha ingresado uno
if ($cue) {
    $sql .= " AND CUE LIKE :cue";
}

try {
    $stmt = $pdo->prepare($sql);
    if ($cue) {
        $stmt->bindValue(':cue', '%' . $cue . '%');
    }
    $stmt->execute();
} catch (PDOException $e) {
    die("Error al consultar la base de datos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Listado de Escuelas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="escuela.css">
</head>
<body>

<header class="text-white bg-primary p-4 text-center">
  <h1><i class="bi bi-people"></i> Gestor de Escuelas</h1>
</header>

<div class="container my-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary">Listado de Escuelas</h2>
    <a href="agregarEscuela.php" class="btn btn-success">
      <i class="bi bi-person-plus-fill"></i> Agregar escuela
    </a>
  </div>

  <!-- Formulario de búsqueda -->
  <form method="POST" class="mb-4">
    <div class="row">
      <div class="col-md-4 mb-3">
        <input type="text" name="cue" class="form-control" placeholder="Filtrar por CUE" value="<?= htmlspecialchars($cue) ?>">
      </div>
      <div class="col-md-4 mb-3">
        <button type="submit" class="btn btn-primary w-100">Filtrar</button>
      </div>
    </div>
  </form>

  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th>CUE</th>
          <th>Turno</th>
          <th>Servicio</th>
          <th>Dirección</th>
          <th>Localidad</th>
          <th>Teléfono</th>
          <th>Correo</th>
          <th>Directivo</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
          <tr>
            <td><?= htmlspecialchars($row['CUE']) ?></td>
            <td><?= htmlspecialchars($row['turno']) ?></td>
            <td><?= htmlspecialchars($row['servicio']) ?></td>
            <td><?= htmlspecialchars($row['direccion']) ?></td>
            <td><?= htmlspecialchars($row['localidad']) ?></td>
            <td><?= htmlspecialchars($row['telefono']) ?></td>
            <td><?= htmlspecialchars($row['correo_electronico']) ?></td>
            <td><?= htmlspecialchars($row['directivo']) ?></td>
            <td>
              <a href="../folders.php?CUE=<?= $row['CUE'] ?>" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i></a>
              <a href="EditarEscuela.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
              <a href="EliminarEscuela.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
