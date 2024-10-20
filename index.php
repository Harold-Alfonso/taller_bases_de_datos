<?php
include ("lib/conexion.php");

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
                    <a class="nav-link active" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="lib/pasajeros.php">Pasajeros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="lib/Aerolíneas.php">Aerolíneas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="lib/vuelo.php">Programar vuelos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="lib/reservas.php">Reservas</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-3">
        <h2>Pasajeros registrados</h2>
        <p>A continuación se muestran los pasajeros registrados en nuestro aeropuerto:</p>            
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Documento</th>
                    <th>Nacionalidad</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT nombre, apellido, documento_identidad, nacionalidad, telefono, correo_electronico FROM pasajero";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['nombre']}</td>
                                <td>{$row['apellido']}</td>
                                <td>{$row['documento_identidad']}</td>
                                <td>{$row['nacionalidad']}</td>
                                <td>{$row['telefono']}</td>
                                <td>{$row['correo_electronico']}</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay pasajeros registrados</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="container mt-3">
        <h2>Aerolíneas registradas</h2>
        <p>A continuación se muestran las aerolíneas registradas en nuestro aeropuerto:</p>            
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Aerolinea</th>
                    <th>País Origen</th>
                    <th>Código</th>
                    <th>Teléfono de contacto</th>
                    <th>Correo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT nombre_aerolinea, pais_origen, codigo_aerolinea, telefono_contacto, correo_aerolinea FROM aerolinea";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['nombre_aerolinea']}</td>
                                <td>{$row['pais_origen']}</td>
                                <td>{$row['codigo_aerolinea']}</td>
                                <td>{$row['telefono_contacto']}</td>
                                <td>{$row['correo_aerolinea']}</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No hay aerolíneas registradas</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="container mt-3">
        <h2>Vuelos programados</h2>
        <p>A continuación se muestran los vuelos programados:</p>            
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Aerolinea</th>
                    <th>N° de vuelo</th>
                    <th>Fecha de salida</th>
                    <th>Fecha de llegada</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT v.numero_vuelo, v.fecha_salida, v.fecha_llegada, v.origen, v.destino, v.estado, a.nombre_aerolinea
                    FROM vuelo v
                    JOIN aerolinea a ON v.aerolinea_id = a.aerolinea_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['nombre_aerolinea']}</td>
                                <td>{$row['numero_vuelo']}</td>
                                <td>{$row['fecha_salida']}</td>
                                <td>{$row['fecha_llegada']}</td>
                                <td>{$row['origen']}</td>
                                <td>{$row['destino']}</td>
                                <td>{$row['estado']}</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No hay vuelos programados</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="container mt-3">
        <h2>Reservas programadas</h2>
        <p>A continuación se muestran las reservas programadas:</p>            
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Número de reserva</th>
                    <th>id-Pasajero</th>
                    <th>id-Vuelo</th>
                    <th>Asiento</th>
                    <th>Clase</th>
                    <th>Fecha de la reserva</th>
                    <th>Equipaje registrado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT reserva_id, pasajero_id, vuelo_id, asiento, clase, fecha_reserva, equipaje_registrado FROM reserva";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['reserva_id']}</td>
                                <td>{$row['pasajero_id']}</td>
                                <td>{$row['vuelo_id']}</td>
                                <td>{$row['asiento']}</td>
                                <td>{$row['clase']}</td>
                                <td>{$row['fecha_reserva']}</td>
                                <td>{$row['equipaje_registrado']}</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No hay reservas programadas</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
