<?php
include("conexion.php");

// Eliminar pasajero
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM pasajero WHERE pasajero_id = $id";
    if($conn->query($sql)) {
    } else {
        echo "Error al eliminar pasajero: " . $conn->error;
    }
}

// Agregar pasajero
if(isset($_POST['add'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $documento = $_POST['documento'];
    $nacimiento = $_POST['fecha_nacimiento'];
    $nacionalidad = $_POST['nacionalidad'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    $sql = "INSERT INTO pasajero (nombre, apellido, documento_identidad, fecha_nacimiento, nacionalidad, telefono, correo_electronico)
            VALUES ('$nombre', '$apellido', '$documento', '$nacimiento', '$nacionalidad', '$telefono', '$correo')";

    if($conn->query($sql)) {
    } else {
        echo "Error al agregar pasajero: " . $conn->error;
    }
}

// Actualizar pasajero
if(isset($_POST['update'])) {
    $id = $_POST['pasajero_id'];
    $nombre = $_POST['update_nombre'];
    $apellido = $_POST['update_apellido'];
    $documento = $_POST['update_documento'];
    $nacimiento = $_POST['update_fecha_nacimiento'];
    $nacionalidad = $_POST['update_nacionalidad'];
    $telefono = $_POST['update_telefono'];
    $correo = $_POST['update_correo'];

    $sql = "UPDATE pasajero SET nombre='$nombre', apellido='$apellido', documento_identidad='$documento', fecha_nacimiento='$nacimiento',
            nacionalidad='$nacionalidad', telefono='$telefono', correo_electronico='$correo' WHERE pasajero_id='$id'";

    if($conn->query($sql)) {
    } else {
        echo "Error al actualizar pasajero: " . $conn->error;
    }
}

// Obtener todos los pasajeros
$sql = "SELECT * FROM pasajero";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pasajeros</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="/taller-1-2-corte">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pasajeros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="aerolíneas.php">Aerolíneas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="vuelo.php">Programar vuelos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reservas.php">Reservas</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-3">
        <h2>Pasajeros registrados</h2>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Documento</th>
                    <th>Fecha de nacimiento</th>
                    <th>Nacionalidad</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['pasajero_id']; ?></td>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><?php echo $row['apellido']; ?></td>
                        <td><?php echo $row['documento_identidad']; ?></td>
                        <td><?php echo $row['fecha_nacimiento']; ?></td>
                        <td><?php echo $row['nacionalidad']; ?></td>
                        <td><?php echo $row['telefono']; ?></td>
                        <td><?php echo $row['correo_electronico']; ?></td>
                        <td>
                            <a href="pasajeros.php?delete=<?php echo $row['pasajero_id']; ?>" class="btn btn-outline-danger">Eliminar</a>
                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#updateModal" 
                                data-id="<?php echo $row['pasajero_id']; ?>" 
                                data-nombre="<?php echo $row['nombre']; ?>"
                                data-apellido="<?php echo $row['apellido']; ?>"
                                data-documento="<?php echo $row['documento_identidad']; ?>"
                                data-nacimiento="<?php echo $row['fecha_nacimiento']; ?>"
                                data-nacionalidad="<?php echo $row['nacionalidad']; ?>"
                                data-telefono="<?php echo $row['telefono']; ?>"
                                data-correo="<?php echo $row['correo_electronico']; ?>">
                                Actualizar
                            </button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="container mt-3">
        <h3>Agregar nuevo pasajero</h3>
        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#addModal">
            Agregar nuevo pasajero
        </button>
    </div>

    <!-- Modal para agregar pasajero -->
    <div class="modal" id="addModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Agregar nuevo pasajero</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="pasajeros.php" method="post">
                        <div class="mb-3">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellido">Apellido:</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" required>
                        </div>
                        <div class="mb-3">
                            <label for="documento">Documento:</label>
                            <input type="text" class="form-control" id="documento" name="documento" required>
                        </div>
                        <div class="mb-3">
                            <label for="nacimiento">Fecha de nacimiento:</label>
                            <input type="date" class="form-control" id="nacimiento" name="fecha_nacimiento" required>
                        </div>
                        <div class="mb-3">
                            <label for="nacionalidad">Nacionalidad:</label>
                            <input type="text" class="form-control" id="nacionalidad" name="nacionalidad" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono">Teléfono:</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        <div class="mb-3">
                            <label for="correo">Correo electrónico:</label>
                            <input type="email" class="form-control" id="correo" name="correo" required>
                        </div>
                        <button type="submit" name="add" class="btn btn-success">Agregar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para actualizar pasajero -->
    <div class="modal" id="updateModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Actualizar datos del pasajero</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="pasajeros.php" method="post">
                        <input type="hidden" id="update_id" name="pasajero_id">
                        <div class="mb-3">
                            <label for="update_nombre">Nombre:</label>
                            <input type="text" class="form-control" id="update_nombre" name="update_nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="update_apellido">Apellido:</label>
                            <input type="text" class="form-control" id="update_apellido" name="update_apellido" required>
                        </div>
                        <div class="mb-3">
                            <label for="update_documento">Documento:</label>
                            <input type="text" class="form-control" id="update_documento" name="update_documento" required>
                        </div>
                        <div class="mb-3">
                            <label for="update_fecha_nacimiento">Fecha de nacimiento:</label>
                            <input type="date" class="form-control" id="update_fecha_nacimiento" name="update_fecha_nacimiento" required>
                        </div>
                        <div class="mb-3">
                            <label for="update_nacionalidad">Nacionalidad:</label>
                            <input type="text" class="form-control" id="update_nacionalidad" name="update_nacionalidad" required>
                        </div>
                        <div class="mb-3">
                            <label for="update_telefono">Teléfono:</label>
                            <input type="text" class="form-control" id="update_telefono" name="update_telefono" required>
                        </div>
                        <div class="mb-3">
                            <label for="update_correo">Correo electrónico:</label>
                            <input type="email" class="form-control" id="update_correo" name="update_correo" required>
                        </div>
                        <button type="submit" name="update" class="btn btn-primary">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        var updateModal = document.getElementById('updateModal');
        updateModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var nombre = button.getAttribute('data-nombre');
            var apellido = button.getAttribute('data-apellido');
            var documento = button.getAttribute('data-documento');
            var nacimiento = button.getAttribute('data-nacimiento');
            var nacionalidad = button.getAttribute('data-nacionalidad');
            var telefono = button.getAttribute('data-telefono');
            var correo = button.getAttribute('data-correo');

            var modalId = updateModal.querySelector('#update_id');
            var modalNombre = updateModal.querySelector('#update_nombre');
            var modalApellido = updateModal.querySelector('#update_apellido');
            var modalDocumento = updateModal.querySelector('#update_documento');
            var modalNacimiento = updateModal.querySelector('#update_fecha_nacimiento');
            var modalNacionalidad = updateModal.querySelector('#update_nacionalidad');
            var modalTelefono = updateModal.querySelector('#update_telefono');
            var modalCorreo = updateModal.querySelector('#update_correo');

            modalId.value = id;
            modalNombre.value = nombre;
            modalApellido.value = apellido;
            modalDocumento.value = documento;
            modalNacimiento.value = nacimiento;
            modalNacionalidad.value = nacionalidad;
            modalTelefono.value = telefono;
            modalCorreo.value = correo;
        });
    </script>
</body>
</html>
