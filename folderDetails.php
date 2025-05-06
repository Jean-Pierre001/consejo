<?php
// Obtener la carpeta actual (incluyendo subcarpetas si las hay)
$folderName = isset($_GET['folder']) ? $_GET['folder'] : '';
$folderPath = "folders/$folderName";

// Verificar si la carpeta existe
if (!is_dir($folderPath)) {
  die("La carpeta no existe.");
}

// Función para eliminar archivos y subcarpetas recursivamente
function deleteFolderAndContents($dirPath) {
  if (!is_dir($dirPath)) return;
  $files = array_diff(scandir($dirPath), array('.', '..'));
  foreach ($files as $file) {
    $filePath = $dirPath . DIRECTORY_SEPARATOR . $file;
    if (is_dir($filePath)) {
      deleteFolderAndContents($filePath);
      rmdir($filePath);
    } else {
      unlink($filePath);
    }
  }
  rmdir($dirPath);
}

// Subir archivo
if (isset($_POST['uploadFile'])) {
  $targetDir = "$folderPath/";
  $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

  if (file_exists($targetFile)) {
    echo "El archivo ya existe.";
    $uploadOk = 0;
  }
  if ($_FILES["fileToUpload"]["size"] > 10000000) {
    echo "El archivo es demasiado grande.";
    $uploadOk = 0;
  }
  if (!in_array($fileType, ['jpg', 'png', 'jpeg', 'gif', 'pdf', 'txt', 'docx'])) {
    echo "Solo se permiten archivos JPG, PNG, JPEG, GIF, PDF, TXT o DOCX.";
    $uploadOk = 0;
  }

  if ($uploadOk == 0) {
    echo "El archivo no se pudo subir.";
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
      echo "El archivo ". basename($_FILES["fileToUpload"]["name"]). " ha sido subido.";
    } else {
      echo "Hubo un error al subir el archivo.";
    }
  }
}

// Crear subcarpeta
if (isset($_POST['createFolder'])) {
  $newFolder = $_POST['newFolderName'];
  $newFolderPath = "$folderPath/$newFolder";
  if (!is_dir($newFolderPath)) {
    mkdir($newFolderPath, 0777, true);
    echo "Subcarpeta '$newFolder' creada con éxito.";
  } else {
    echo "La subcarpeta ya existe.";
  }
}

// Eliminar archivo
if (isset($_GET['deleteFile'])) {
  $fileToDelete = $_GET['deleteFile'];
  $filePathToDelete = "$folderPath/$fileToDelete";
  if (file_exists($filePathToDelete)) {
    unlink($filePathToDelete);
    echo "El archivo '$fileToDelete' ha sido eliminado.";
  } else {
    echo "El archivo no existe.";
  }
}

// Eliminar subcarpeta
if (isset($_GET['deleteFolder'])) {
  $folderToDelete = $_GET['deleteFolder'];
  $folderPathToDelete = "$folderPath/$folderToDelete";
  if (is_dir($folderPathToDelete)) {
    deleteFolderAndContents($folderPathToDelete);
    echo "La subcarpeta '$folderToDelete' ha sido eliminada.";
  } else {
    echo "La subcarpeta no existe.";
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Detalles de la Carpeta - <?php echo htmlspecialchars($folderName); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f5f7fa; font-family: 'Segoe UI', sans-serif; }
    header { background: #4A90E2; padding: 25px 0; color: white; text-align: center; }
    .navbar { background-color: white; padding: 1rem; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
    .navbar-brand { font-weight: bold; font-size: 1.7rem; color: #1d3a8a; }
    .navbar-brand span { font-size: 0.7rem; background-color: #1d3a8a; color: white; padding: 2px 4px; border-radius: 3px; margin-right: 4px; }
    .file-item, .folder-item { background: white; padding: 15px; border-radius: 10px; margin-bottom: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); display: flex; justify-content: space-between; align-items: center; }
    .btn-upload, .btn-create-folder { margin-top: 20px; }
    .btn-delete { margin-left: 10px; color: red; }
  </style>
</head>
<body>

<header>
  <h1>Detalles de la Carpeta: <?php echo htmlspecialchars($folderName); ?></h1>
</header>

<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container">
    <a class="navbar-brand" href="index.php">
      <span>Cooperativa</span>Comarca Ltda.
    </a>
  </div>
</nav>

<div class="container py-5">

  <div class="card p-4 mb-5">
    <h2>Subir un archivo</h2>
    <form action="" method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="fileToUpload" class="form-label">Seleccionar archivo</label>
        <input type="file" name="fileToUpload" id="fileToUpload" class="form-control" required>
      </div>
      <button type="submit" name="uploadFile" class="btn btn-primary btn-upload">Subir archivo</button>
    </form>
  </div>

  <div class="card p-4 mb-5">
    <h2>Crear subcarpeta</h2>
    <form action="" method="POST">
      <div class="mb-3">
        <label for="newFolderName" class="form-label">Nombre de la subcarpeta</label>
        <input type="text" name="newFolderName" id="newFolderName" class="form-control" required>
      </div>
      <button type="submit" name="createFolder" class="btn btn-success btn-create-folder">Crear subcarpeta</button>
    </form>
  </div>

  <div class="card p-4">
    <h3>Contenido</h3>
    <div class="file-list">
      <?php
        $items = array_diff(scandir($folderPath), array('.', '..'));
        foreach ($items as $item) {
          $itemPath = "$folderPath/$item";
          $itemUrl = urlencode(trim($folderName === '' ? $item : "$folderName/$item"));
          if (is_dir($itemPath)) {
            echo "<div class='folder-item'>
                    <a href='?folder=$itemUrl'><strong>📁 $item</strong></a>
                    <div>
                      <a href='?folder=" . urlencode($folderName) . "&deleteFolder=" . urlencode($item) . "' class='btn btn-sm btn-outline-danger btn-delete'>Eliminar</a>
                    </div>
                  </div>";
          } else {
            echo "<div class='file-item'>
                    <a href='$itemPath' download>$item</a>
                    <div>
                      <a href='?folder=" . urlencode($folderName) . "&deleteFile=" . urlencode($item) . "' class='btn btn-sm btn-outline-danger btn-delete'>Eliminar</a>
                    </div>
                  </div>";
          }
        }
      ?>
    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
