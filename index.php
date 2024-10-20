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
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
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
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
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
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="container mt-3">
        <h2>Reservas programados</h2>
        <p>A continuación se muestran las reservas programados:</p>            
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Numero de reserva</th>
                    <th>id-Pasajero</th>
                    <th>id-vuelo</th>
                    <th>asiento</th>
                    <th>clase</th>
                    <th>fecha de la reserva</th>
                    <th>equipaje registrado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
