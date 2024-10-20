<?php
include("conexion.php");

// Eliminar aerolíneas
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM aerolinea WHERE aerolinea_id = $delete_id";
    if ($conn->query($sql) === TRUE) {
    } else {
        echo "Error al eliminar aerolínea: " . $conn->error;
    }
}

// Actualizar aerolíneas
if (isset($_POST['update'])) {
    $aerolinea_id = $_POST['aerolinea_id'];
    $nombre_aerolinea = $_POST['nombre_aerolinea'];
    $pais_origen = $_POST['pais_origen'];
    $codigo_aerolinea = $_POST['codigo_aerolinea'];
    $telefono_contacto = $_POST['telefono_contacto'];
    $correo_aerolinea = $_POST['correo_aerolinea'];

    $sql = "UPDATE aerolinea SET 
                nombre_aerolinea='$nombre_aerolinea', 
                pais_origen='$pais_origen', 
                codigo_aerolinea='$codigo_aerolinea', 
                telefono_contacto='$telefono_contacto', 
                correo_aerolinea='$correo_aerolinea'
            WHERE aerolinea_id=$aerolinea_id";
    if ($conn->query($sql) === TRUE) {
    } else {
        echo "Error al actualizar aerolínea: " . $conn->error;
    }
}

// Agregar una aerolínea
if (isset($_POST['add'])) {
    $nombre_aerolinea = $_POST['nombre_aerolinea'];
    $pais_origen = $_POST['pais_origen'];
    $codigo_aerolinea = $_POST['codigo_aerolinea'];
    $telefono_contacto = $_POST['telefono_contacto'];
    $correo_aerolinea = $_POST['correo_aerolinea'];

    $sql = "INSERT INTO aerolinea (nombre_aerolinea, pais_origen, codigo_aerolinea, telefono_contacto, correo_aerolinea) 
            VALUES ('$nombre_aerolinea', '$pais_origen', '$codigo_aerolinea', '$telefono_contacto', '$correo_aerolinea')";
    if ($conn->query($sql) === TRUE) {
    } else {
        echo "Error al agregar aerolínea: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Administrar Aerolíneas</title>
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
                    <a class="nav-link" href="pasajeros.php">Pasajeros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Aerolíneas</a>
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
        <h2>Aerolíneas registradas</h2>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Aerolínea</th>
                    <th>País Origen</th>
                    <th>Código</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM aerolinea";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['aerolinea_id']}</td>
                                <td>{$row['nombre_aerolinea']}</td>
                                <td>{$row['pais_origen']}</td>
                                <td>{$row['codigo_aerolinea']}</td>
                                <td>{$row['telefono_contacto']}</td>
                                <td>{$row['correo_aerolinea']}</td>
                                <td>
                                    <a href='aerolíneas.php?delete_id={$row['aerolinea_id']}' class='btn btn-outline-danger'>Eliminar</a>
                                    <button type='button' class='btn btn-outline-secondary' data-bs-toggle='modal' data-bs-target='#updateModal{$row['aerolinea_id']}'>Actualizar</button>
                                </td>
                              </tr>";

                        // Modal para actualizar aerolínea
                        echo "
                            <div class='modal' id='updateModal{$row['aerolinea_id']}'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h4 class='modal-title'>Actualizar Aerolínea</h4>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <form method='POST' action='aerolíneas.php'>
                                                <input type='hidden' name='aerolinea_id' value='{$row['aerolinea_id']}'>
                                                <div class='mb-3'>
                                                    <label>Nombre Aerolínea:</label>
                                                    <input type='text' class='form-control' name='nombre_aerolinea' value='{$row['nombre_aerolinea']}' required>
                                                </div>
                                                <div class='mb-3'>
                                                    <label>País Origen:</label>
                                                    <input type='text' class='form-control' name='pais_origen' value='{$row['pais_origen']}' required>
                                                </div>
                                                <div class='mb-3'>
                                                    <label>Código Aerolínea:</label>
                                                    <input type='text' class='form-control' name='codigo_aerolinea' value='{$row['codigo_aerolinea']}' required>
                                                </div>
                                                <div class='mb-3'>
                                                    <label>Teléfono Contacto:</label>
                                                    <input type='text' class='form-control' name='telefono_contacto' value='{$row['telefono_contacto']}' required>
                                                </div>
                                                <div class='mb-3'>
                                                    <label>Correo Aerolínea:</label>
                                                    <input type='email' class='form-control' name='correo_aerolinea' value='{$row['correo_aerolinea']}' required>
                                                </div>
                                                <button type='submit' name='update' class='btn btn-outline-secondary'>Actualizar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No hay aerolíneas registradas</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para agregar aerolínea -->
    <div class="container mt-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Agregar Aerolínea</button>
    </div>
    <div class="modal" id="addModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Agregar nueva Aerolínea</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="aerolíneas.php">
                        <div class="mb-3">
                            <label>Nombre Aerolínea:</label>
                            <input type="text" class="form-control" name="nombre_aerolinea" required>
                        </div>
                        <div class="mb-3">
                            <label>País Origen:</label>
                            <input type="text" class="form-control" name="pais_origen" required>
                        </div>
                        <div class="mb-3">
                            <label>Código Aerolínea:</label>
                            <input type="text" class="form-control" name="codigo_aerolinea" required>
                        </div>
                        <div class="mb-3">
                            <label>Teléfono Contacto:</label>
                            <input type="text" class="form-control" name="telefono_contacto" required>
                        </div>
                        <div class="mb-3">
                            <label>Correo Aerolínea:</label>
                            <input type="email" class="form-control" name="correo_aerolinea" required>
                        </div>
                        <button type="submit" name="add" class="btn btn-outline-dark">Agregar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

