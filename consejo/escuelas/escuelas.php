<?php
require_once '../baseDatos/conexion.php';

$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';

$sql = "SELECT id, nombre, direccion, directivo, ciudad FROM Escuelas WHERE 1=1";

// Filtrar por nombre si se ha ingresado un nombre
if ($nombre) {
    $sql .= " AND nombre LIKE :nombre";
}

try {
    $stmt = $pdo->prepare($sql);

    // Enlazar los parámetros si se han proporcionado
    if ($nombre) {
        $stmt->bindValue(':nombre', '%' . $nombre . '%');
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listado de Escuelas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body {
      background: linear-gradient(180deg, #f5f7fa 0%, #c3cfe2 100%);
      font-family: 'Segoe UI', sans-serif;
    }

    header {
      background: linear-gradient(90deg, #4A90E2, #50A7F3);
      padding: 5px 0;
      color: white;
      text-align: center;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
    }

    header h1 {
      font-size: 2.5rem;
      font-weight: bold;
      margin-bottom: 10px;
    }

    header i {
      font-size: 2rem;
    }

    .navbar {
      transition: all 0.3s ease;
      background-color: white;
      padding-top: 1rem;
      padding-bottom: 1rem;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .navbar.shrink {
      padding-top: 0.3rem;
      padding-bottom: 0.3rem;
    }

    .navbar-brand {
      font-weight: bold;
      font-size: 1.7rem;
      color: #1d3a8a;
    }

    .navbar-brand span {
      font-size: 0.7rem;
      background-color: #1d3a8a;
      color: white;
      padding: 2px 4px;
      border-radius: 3px;
      margin-right: 4px;
    }

    .nav-link {
      color: #1d3a8a !important;
      font-weight: 500;
    }

    .nav-link:hover,
    .nav-item.dropdown:hover .nav-link {
      color: #f6b800 !important;
    }

    .dropdown-menu {
      border: none;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>
<body class="bg-light">

  <header>
    <i class="bi bi-people fs-1"></i>
    <h1>Gestor de Escuelas</h1>
    <p class="lead">Agrega, da de baja y modifica tus Escuelas en nuestra página web</p>
  </header>

  <nav id="mainNavbar" class="navbar navbar-expand-lg sticky-top">
    <div class="container">
      <a class="navbar-brand" href="../index.php">
        <span>Consejo</span>Escolar.
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="Escuelas.php">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="../usuarios/usuarios.php">Escuelas</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">Servicios</a>

          </li>
        </ul>
      </div>
    </div>
  </nav>
 
  <div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="text-primary">Listado de Escuelas</h2>
      <a href="agregarEscuela.php" class="btn btn-success">
        <i class="bi bi-person-plus-fill"></i> Agregar escuela
      </a>
    </div>

    <!-- Filtro por Nombre y DNI -->
    <form method="POST" class="mb-4">
      <div class="row">
        <div class="col-md-4 mb-3">
          <input type="text" name="nombre" class="form-control" placeholder="Filtrar por nombre" value="<?= htmlspecialchars($nombre) ?>">
        </div>
        <div class="col-md-4 mb-3">
          <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
      </div>
    </form>

    <div class="table-responsive">
      <table class="table table-striped table-hover table-bordered align-middle shadow-sm">
        <thead class="table-dark text-center">
          <tr>
            <th>Nombre</th>
            <th>Direccion</th>
            <th>Directivo</th>
            <th>Ciudad</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
              <td><?= htmlspecialchars($row['nombre']) ?></td>
              <td><?= htmlspecialchars($row['direccion']) ?></td>
              <td><?= htmlspecialchars($row['directivo']) ?></td>
              <td><?= htmlspecialchars($row['ciudad']) ?></td>
              <td>
                <a href="../folders.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm me-1">
                  <i class="bi bi-eye-fill"></i>
                </a>
                <a href="EditarEscuela.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm me-1">
                  <i class="bi bi-pencil-fill"></i>
                </a>
                <a href="EliminarEscuela.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">
                  <i class="bi bi-trash-fill"></i>
                </a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const navbar = document.getElementById('mainNavbar');
    window.addEventListener('scroll', function () {
      if (window.scrollY > 100) {
        navbar.classList.add('shrink');
      } else {
        navbar.classList.remove('shrink');
      }
    });
  </script>
</body>
</html>
