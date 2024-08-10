<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $nombre = $_POST['nombre'];
    $instrumento = $_POST['instrumento'];
    $genero = $_POST['genero'] ?? ''; 
    $años_experiencia = $_POST['años_experiencia'] ?? 0; 

    if (!empty($nombre) && !empty($instrumento) && !empty($genero) && isset($años_experiencia)) {
        $sql = "INSERT INTO musicos (nombre, instrumento, genero, años_experiencia) 
                VALUES ('$nombre', '$instrumento', '$genero', $años_experiencia)";
        if ($conn->query($sql) === TRUE) {
            echo "<p>Músico agregado correctamente.</p>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "<p>Por favor completa todos los campos.</p>";
    }
}

// Actualizar (Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $instrumento = $_POST['instrumento'];
    $genero = $_POST['genero'];
    $años_experiencia = $_POST['años_experiencia'];

    $sql = "UPDATE musicos SET nombre='$nombre', instrumento='$instrumento', genero='$genero', años_experiencia=$años_experiencia WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<p>Músico actualizado correctamente.</p>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Eliminar (Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = $_POST['id'];

    $sql = "DELETE FROM musicos WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<p>Músico eliminado correctamente.</p>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Consulta para mostrar los músicos
$sql = "SELECT id, nombre, instrumento, genero, años_experiencia FROM musicos";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Músicos</title>
    <link rel="stylesheet" href="EstiloMusicos.css">
    <script src="scriptMusicos.js" defer></script>
</head>
<body>
    <div class="container">
        <h1>Lista de Músicos</h1>
        <form id="createForm" method="POST" action="index.php">
            <input type="hidden" name="action" value="create">
            <input type="text" name="nombre" id="nombre" placeholder="Nombre" required>
            <input type="text" name="instrumento" id="instrumento" placeholder="Instrumento" required>
            <input type="text" name="genero" id="genero" placeholder="Género" required>
<input type="number" name="años_experiencia" id="años_experiencia" placeholder="Años de Experiencia" required>

            <button type="submit">Agregar Músico</button>
        </form>

        <ul id="musicoList">
            <?php
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<li>";
                    echo htmlspecialchars($row["nombre"]) . " - " . htmlspecialchars($row["instrumento"]) . " - " . htmlspecialchars($row["genero"]) . " - " . htmlspecialchars($row["años_experiencia"]) . " años";
                    echo ' <button class="editBtn" data-id="' . $row["id"] . '" data-nombre="' . htmlspecialchars($row["nombre"]) . '" data-instrumento="' . htmlspecialchars($row["instrumento"]) . '" data-genero="' . htmlspecialchars($row["genero"]) . '" data-años_experiencia="' . htmlspecialchars($row["años_experiencia"]) . '">Editar</button>';
                    echo ' <form class="deleteForm" method="POST" action="index.php" style="display:inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="' . $row["id"] . '">
                            <button type="submit">Eliminar</button>
                          </form>';
                    echo "</li>";
                }
            } else {
                echo "<p>No hay músicos registrados.</p>";
            }
            ?>
        </ul>

        <div id="editFormContainer" style="display:none;">
            <h2>Editar Músico</h2>
            <form id="editForm" method="POST" action="index.php">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" id="editId">
                <input type="text" name="nombre" id="editNombre" placeholder="Nombre" required>
                <input type="text" name="instrumento" id="editInstrumento" placeholder="Instrumento" required>
                <input type="text" name="genero" id="editGenero" placeholder="Género" required>
                <input type="number" name="años_experiencia" id="editAñosExperiencia" placeholder="Años de Experiencia" required>
                <button type="submit">Actualizar Músico</button>
            </form>
        </div>
    </div>
</body>
</html>
