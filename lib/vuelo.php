<?php
include("./conexion.php");

// Eliminar vuelo
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM vuelo WHERE vuelo_id = $id";
    if ($conn->query($sql)) {
    } else {
        echo "Error al eliminar el vuelo programado: " . $conn->error;
    }
}

// Agregar vuelo
if (isset($_POST['add'])) {
    $aerolinea_id = $_POST['aerolinea_id'];
    $numero_vuelo = $_POST['numero_vuelo'];
    $fecha_salida = $_POST['fecha_salida'];
    $fecha_llegada = $_POST['fecha_llegada'];
    $origen = $_POST['origen'];
    $destino = $_POST['destino'];
    $estado = $_POST['estado'];

    // Verificar si el número de vuelo ya existe
    $check_numero_vuelo = "SELECT * FROM vuelo WHERE numero_vuelo = '$numero_vuelo'";
    $result_check_vuelo = $conn->query($check_numero_vuelo);

    if ($result_check_vuelo->num_rows > 0) {
        // El número de vuelo ya está registrado
        echo "<script>alert('Error: El número de vuelo ya está programado.');</script>";
    } else {
        // Verificar que aerolinea_id existe en la tabla aerolinea
        $check_aerolinea = "SELECT * FROM aerolinea WHERE aerolinea_id = '$aerolinea_id'";
        $result_check = $conn->query($check_aerolinea);

        if ($result_check->num_rows > 0) {
            // Aerolínea existe, proceder a insertar el vuelo
            $sql = "INSERT INTO vuelo (aerolinea_id, numero_vuelo, fecha_salida, fecha_llegada, origen, destino, estado)
                    VALUES ('$aerolinea_id', '$numero_vuelo', '$fecha_salida', '$fecha_llegada', '$origen', '$destino', '$estado')";

            if ($conn->query($sql)) {
                // Inserción exitosa
            } else {
                echo "Error al programar el vuelo: " . $conn->error;
            }
        } else {
            echo "Error: La aerolínea especificada no existe.";
        }
    }
}

// Actualizar vuelo programado
if (isset($_POST['update'])) {
    $vuelo_id = $_POST['vuelo_id'];
    $aerolinea_id = $_POST['update_aerolinea_id'];
    $numero_vuelo = $_POST['update_numero_vuelo'];
    $fecha_salida = $_POST['update_fecha_salida'];
    $fecha_llegada = $_POST['update_fecha_llegada'];
    $origen = $_POST['update_origen'];
    $destino = $_POST['update_destino'];
    $estado = $_POST['update_estado'];

    // Verificar que aerolinea_id existe en la tabla aerolinea
    $check_aerolinea = "SELECT * FROM aerolinea WHERE aerolinea_id = '$aerolinea_id'";
    $result_check = $conn->query($check_aerolinea);

    if ($result_check->num_rows > 0) {
        // Aerolinea existe
        $sql = "UPDATE vuelo SET aerolinea_id='$aerolinea_id', numero_vuelo='$numero_vuelo', fecha_salida='$fecha_salida', fecha_llegada='$fecha_llegada',
                origen='$origen', destino='$destino', estado='$estado' WHERE vuelo_id='$vuelo_id'";

        if ($conn->query($sql)) {
            // Actualización exitosa
        } else {
            echo "Error al actualizar el vuelo programado: " . $conn->error;
        }
    } else {
        echo "Error: La aerolínea especificada no existe.";
    }
}

// Obtener todos los vuelos
$sql_vuelos = "
    SELECT v.vuelo_id, v.numero_vuelo, v.fecha_salida, v.fecha_llegada, v.origen, v.destino, v.estado, a.nombre_aerolinea 
    FROM vuelo v
    JOIN aerolinea a ON v.aerolinea_id = a.aerolinea_id
";
$result_vuelos = $conn->query($sql_vuelos);

// Obtener todas las aerolíneas
$sql_aerolineas = "SELECT aerolinea_id, nombre_aerolinea, pais_origen, codigo_aerolinea, telefono_contacto, correo_aerolinea FROM aerolinea";
$result_aerolineas = $conn->query($sql_aerolineas);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Bootstrap Example</title>
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
                    <a class="nav-link" href="aerolíneas.php">Aerolíneas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Programar vuelos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reservas.php">Reservas</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-3">
        <h2>Vuelos programados</h2>
        <p>A continuación se muestran los vuelos programados:</p>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>AEROLINEA</th>
                    <th>NUMERO DE VUELO</th>
                    <th>FECHA DE SALIDA</th>
                    <th>FECHA DE LLEGADA</th>
                    <th>ORIGEN</th>
                    <th>DESTINO</th>
                    <th>ESTADO</th>
                    <th>ACCION</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_vuelos->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['vuelo_id']; ?></td>
                        <td><?php echo $row['nombre_aerolinea']; ?></td>
                        <td><?php echo $row['numero_vuelo']; ?></td>
                        <td><?php echo $row['fecha_salida']; ?></td>
                        <td><?php echo $row['fecha_llegada']; ?></td>
                        <td><?php echo $row['origen']; ?></td>
                        <td><?php echo $row['destino']; ?></td>
                        <td><?php echo $row['estado']; ?></td>
                        <td>
                            <a href="vuelo.php?delete=<?php echo $row['vuelo_id']; ?>" class="btn btn-outline-danger">Eliminar</a>
                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#updateModal" 
                                data-vuelo_id="<?php echo $row['vuelo_id']; ?>" 
                                data-aerolinea_id="<?php echo $row['nombre_aerolinea']; ?>"
                                data-numero_vuelo="<?php echo $row['numero_vuelo']; ?>"
                                data-fecha_salida="<?php echo $row['fecha_salida']; ?>"
                                data-fecha_llegada="<?php echo $row['fecha_llegada']; ?>"
                                data-origen="<?php echo $row['origen']; ?>"
                                data-destino="<?php echo $row['destino']; ?>"
                                data-estado="<?php echo $row['estado']; ?>">
                                Actualizar
                            </button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="container mt-3">
        <h3>Programar un nuevo vuelo</h3>
        <p>Bienvenido, si deseas programar un nuevo vuelo por favor presiona el botón de "Programar Vuelo".</p>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            Programar Vuelo
        </button>
    </div>

    <!-- Modal para agregar vuelo -->
    <div class="modal" id="addModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">PROGRAMAR VUELO</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="vuelo.php" method="post">
                        <div class="mb-3">
                            <label for="aerolinea_id">AEROLINEA:</label>
                            <select class="form-control" id="aerolinea_id" name="aerolinea_id" required>
                                <option value="">Seleccione una aerolínea</option>
                                <?php while ($aerolinea = $result_aerolineas->fetch_assoc()): ?>
                                    <option value="<?php echo $aerolinea['aerolinea_id']; ?>">
                                        <?php echo $aerolinea['nombre_aerolinea']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="numero_vuelo">NUMERO DE VUELO:</label>
                            <input type="text" class="form-control" id="numero_vuelo" placeholder="Número de vuelo" name="numero_vuelo" required>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_salida">FECHA DE SALIDA:</label>
                            <input type="date" class="form-control" id="fecha_salida" name="fecha_salida" required>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_llegada">FECHA DE LLEGADA:</label>
                            <input type="date" class="form-control" id="fecha_llegada" name="fecha_llegada" required>
                        </div>
                        <div class="mb-3">
                            <label for="origen">ORIGEN:</label>
                            <input type="text" class="form-control" id="origen" placeholder="Origen" name="origen" required>
                        </div>
                        <div class="mb-3">
                            <label for="destino">DESTINO:</label>
                            <input type="text" class="form-control" id="destino" placeholder="Destino" name="destino" required>
                        </div>
                        <div class="mb-3">
                            <label for="estado">ESTADO:</label>
                            <select class="form-control" id="estado" name="estado" required>
                                <option value="en tiempo">En tiempo</option>
                                <option value="retrasado">Retrasado</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                        </div>
                        <input type="hidden" name="add" value="1">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para actualizar vuelo -->
    <div class="modal" id="updateModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">ACTUALIZAR VUELO</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="vuelo.php" method="post">
                        <input type="hidden" id="vuelo_id" name="vuelo_id">
                        <div class="mb-3">
                            <label for="update_aerolinea_id">AEROLINEA:</label>
                            <select class="form-control" id="update_aerolinea_id" name="update_aerolinea_id" required>
                                <option value="">Seleccione una aerolínea</option>
                                <?php
                                $result_aerolineas = $conn->query($sql_aerolineas); // Recargar las aerolíneas
                                while ($aerolinea = $result_aerolineas->fetch_assoc()): ?>
                                    <option value="<?php echo $aerolinea['aerolinea_id']; ?>">
                                        <?php echo $aerolinea['nombre_aerolinea']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="update_numero_vuelo">NUMERO DE VUELO:</label>
                            <input type="text" class="form-control" id="update_numero_vuelo" placeholder="Número de vuelo" name="update_numero_vuelo" required>
                        </div>
                        <div class="mb-3">
                            <label for="update_fecha_salida">FECHA DE SALIDA:</label>
                            <input type="date" class="form-control" id="update_fecha_salida" name="update_fecha_salida" required>
                        </div>
                        <div class="mb-3">
                            <label for="update_fecha_llegada">FECHA DE LLEGADA:</label>
                            <input type="date" class="form-control" id="update_fecha_llegada" name="update_fecha_llegada" required>
                        </div>
                        <div class="mb-3">
                            <label for="update_origen">ORIGEN:</label>
                            <input type="text" class="form-control" id="update_origen" placeholder="Origen" name="update_origen" required>
                        </div>
                        <div class="mb-3">
                            <label for="update_destino">DESTINO:</label>
                            <input type="text" class="form-control" id="update_destino" placeholder="Destino" name="update_destino" required>
                        </div>
                        <div class="mb-3">
                            <label for="update_estado">ESTADO:</label>
                            <select class="form-control" id="update_estado" name="update_estado" required>
                                <option value="en tiempo">En tiempo</option>
                                <option value="retrasado">Retrasado</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                        </div>
                        <input type="hidden" name="update" value="1">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        var updateModal = document.getElementById('updateModal');
        updateModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;

            var vuelo_id = button.getAttribute('data-vuelo_id');
            var aerolinea_id = button.getAttribute('data-aerolinea_id');
            var numero_vuelo = button.getAttribute('data-numero_vuelo');
            var fecha_salida = button.getAttribute('data-fecha_salida');
            var fecha_llegada = button.getAttribute('data-fecha_llegada');
            var origen = button.getAttribute('data-origen');
            var destino = button.getAttribute('data-destino');
            var estado = button.getAttribute('data-estado');

            var modalBodyInputVueloId = updateModal.querySelector('.modal-body input#vuelo_id');
            var modalBodySelectAerolineaId = updateModal.querySelector('.modal-body select#update_aerolinea_id');
            var modalBodyInputNumeroVuelo = updateModal.querySelector('.modal-body input#update_numero_vuelo');
            var modalBodyInputFechaSalida = updateModal.querySelector('.modal-body input#update_fecha_salida');
            var modalBodyInputFechaLlegada = updateModal.querySelector('.modal-body input#update_fecha_llegada');
            var modalBodyInputOrigen = updateModal.querySelector('.modal-body input#update_origen');
            var modalBodyInputDestino = updateModal.querySelector('.modal-body input#update_destino');
            var modalBodySelectEstado = updateModal.querySelector('.modal-body select#update_estado');

            modalBodyInputVueloId.value = vuelo_id;
            modalBodySelectAerolineaId.value = aerolinea_id;
            modalBodyInputNumeroVuelo.value = numero_vuelo;
            modalBodyInputFechaSalida.value = fecha_salida;
            modalBodyInputFechaLlegada.value = fecha_llegada;
            modalBodyInputOrigen.value = origen;
            modalBodyInputDestino.value = destino;
            modalBodySelectEstado.value = estado;
        });
    </script>
</body>
</html>
