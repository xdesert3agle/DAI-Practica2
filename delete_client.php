<?php
    
    include('dbconnection.php');

    $client_list = $_POST["id"];
    $dni = $_POST["dni"];

    echo $dni;

    for ($i = 0; $i < count($client_list); $i++) {
        $sqlQuery = "DELETE FROM CLIENTES WHERE ID_CLIENTE = " .$client_list[$i];

        $conn->query($sqlQuery);
    }

    header("Location: clients.php");

?>