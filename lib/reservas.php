<?php
include("conexion.php");

// Obtener los pasajeros y vuelos disponibles
$pasajeros = $conn->query("SELECT pasajero_id, nombre FROM pasajero");
$vuelos = $conn->query("SELECT vuelo_id, destino FROM vuelo");

// Procesar la eliminación de reservas
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM reserva WHERE reserva_id = $delete_id";
    if ($conn->query($sql) === TRUE) {
        // Reserva eliminada con éxito
    } else {
        echo "Error al eliminar reserva: " . $conn->error;
    }
}

// Procesar la actualización de reservas
if (isset($_POST['update'])) {
    $id_reserva = $_POST['reserva_id'];
    $id_pasajero = $_POST['pasajero_id'];
    $id_vuelo = $_POST['vuelo_id'];
    $asiento = $_POST['asiento'];
    $clase = $_POST['clase'];
    $fecha_reserva = $_POST['fecha_reserva'];
    $equipaje = $_POST['equipaje_registrado'];

    $sql = "UPDATE reserva SET 
                pasajero_id='$id_pasajero', 
                vuelo_id='$id_vuelo', 
                asiento='$asiento', 
                clase='$clase', 
                fecha_reserva='$fecha_reserva', 
                equipaje_registrado='$equipaje'
            WHERE reserva_id=$id_reserva";
    if ($conn->query($sql) === TRUE) {
        // Reserva actualizada con éxito
    } else {
        echo "Error al actualizar reserva: " . $conn->error;
    }
}

// Procesar la adición de una nueva reserva
if (isset($_POST['add'])) {
    $id_pasajero = $_POST['id_pasajero'];
    $id_vuelo = $_POST['id_vuelo'];
    $asiento = $_POST['asiento'];
    $clase = $_POST['clase'];
    $fecha_reserva = $_POST['fecha_reserva'];
    $equipaje = $_POST['equipaje'];

    $sql = "INSERT INTO reserva (pasajero_id, vuelo_id, asiento, clase, fecha_reserva, equipaje_registrado) 
            VALUES ('$id_pasajero', '$id_vuelo', '$asiento', '$clase', '$fecha_reserva', '$equipaje')";
    if ($conn->query($sql) === TRUE) {
        // Reserva añadida con éxito
    } else {
        echo "Error al agregar reserva: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reservas</title>
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
                    <a class="nav-link" href="aerolineas.php">Aerolíneas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="vuelo.php">Programar vuelos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Reservas</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-3">
        <h2>Reservas registradas</h2>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>ID Reserva</th>
                    <th>ID Pasajero</th>
                    <th>ID Vuelo</th>
                    <th>Asiento</th>
                    <th>Clase</th>
                    <th>Fecha Reserva</th>
                    <th>Equipaje</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM reserva";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['reserva_id']}</td>
                                <td>{$row['pasajero_id']}</td>
                                <td>{$row['vuelo_id']}</td>
                                <td>{$row['asiento']}</td>
                                <td>{$row['clase']}</td>
                                <td>{$row['fecha_reserva']}</td>
                                <td>{$row['equipaje_registrado']}</td>
                                <td>
                                    <a href='reservas.php?delete_id={$row['reserva_id']}' class='btn btn-outline-danger'>Eliminar</a>
                                    <button type='button' class='btn btn-outline-secondary' data-bs-toggle='modal' data-bs-target='#updateModal{$row['reserva_id']}'>Actualizar</button>
                                </td>
                              </tr>";

                        // Modal para actualizar reserva
                        echo "
                            <div class='modal' id='updateModal{$row['reserva_id']}'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h4 class='modal-title'>Actualizar Reserva</h4>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <form method='POST' action='reservas.php'>
                                                <input type='hidden' name='reserva_id' value='{$row['reserva_id']}'>
                                                <div class='mb-3'>
                                                    <label>ID Pasajero:</label>
                                                    <select class='form-control' name='pasajero_id' required>
                                                        <option value='{$row['pasajero_id']}'>Seleccionado: {$row['pasajero_id']}</option>";
                                                        while ($pasajero = $pasajeros->fetch_assoc()) {
                                                            echo "<option value='{$pasajero['pasajero_id']}'>{$pasajero['nombre']}</option>";
                                                        }
                        echo "                      </select>
                                                </div>
                                                <div class='mb-3'>
                                                    <label>ID Vuelo:</label>
                                                    <select class='form-control' name='vuelo_id' required>
                                                        <option value='{$row['vuelo_id']}'>Seleccionado: {$row['vuelo_id']}</option>";
                                                        while ($vuelo = $vuelos->fetch_assoc()) {
                                                            echo "<option value='{$vuelo['vuelo_id']}'>{$vuelo['destino']}</option>";
                                                        }
                        echo "                      </select>
                                                </div>
                                                <div class='mb-3'>
                                                    <label>Asiento:</label>
                                                    <input type='text' class='form-control' name='asiento' value='{$row['asiento']}' required>
                                                </div>
                                                <div class='mb-3'>
                                                    <label>Clase:</label>
                                                    <input type='text' class='form-control' name='clase' value='{$row['clase']}' required>
                                                </div>
                                                <div class='mb-3'>
                                                    <label>Fecha Reserva:</label>
                                                    <input type='date' class='form-control' name='fecha_reserva' value='{$row['fecha_reserva']}' required>
                                                </div>
                                                <div class='mb-3'>
                                                    <label>Equipaje Registrado:</label>
                                                    <input type='text' class='form-control' name='equipaje_registrado' value='{$row['equipaje_registrado']}' required>
                                                </div>
                                                <button type='submit' name='update' class='btn btn-outline-secondary'>Actualizar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No hay reservas registradas</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para agregar reserva -->
    <div class="container mt-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Agregar Reserva</button>
    </div>
    <div class="modal" id="addModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Agregar nueva Reserva</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="reservas.php">
                        <div class="mb-3">
                            <label>ID Pasajero:</label>
                            <select class="form-control" name="id_pasajero" required>
                                <?php
                                $pasajeros->data_seek(0); // Reiniciar puntero
                                while ($pasajero = $pasajeros->fetch_assoc()) {
                                    echo "<option value='{$pasajero['pasajero_id']}'>{$pasajero['pasajero_id']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>ID Vuelo:</label>
                            <select class="form-control" name="id_vuelo" required>
                                <?php
                                $vuelos->data_seek(0); // Reiniciar puntero
                                while ($vuelo = $vuelos->fetch_assoc()) {
                                    echo "<option value='{$vuelo['vuelo_id']}'>{$vuelo['vuelo_id']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Asiento:</label>
                            <input type="text" class="form-control" name="asiento" required>
                        </div>
                        <div class="mb-3">
                            <label>Clase:</label>
                            <select class="form-control" name="clase" required>
                                <option value="económica">Económica</option>
                                <option value="ejecutiva">Ejecutiva</option>
                                <option value="primera clase">Primera Clase</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Fecha Reserva:</label>
                            <input type="date" class="form-control" name="fecha_reserva" required>
                        </div>
                        <div class="mb-3">
                            <label>Equipaje Registrado:</label>
                            <input type="text" class="form-control" name="equipaje" required>
                        </div>
                        <button type="submit" name="add" class="btn btn-primary">Agregar Reserva</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

