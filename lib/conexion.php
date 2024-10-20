<?php

    $servername = "localhost";
    $username = "root";
    $password = '';
    $dbname = 'aeropuertodb';

    $conn = new mysqli($servername, $username, $password, $dbname);

    if($conn->connect_error){
        die("Conexión Fallida: ".$conn->connect_error);
    }
?>