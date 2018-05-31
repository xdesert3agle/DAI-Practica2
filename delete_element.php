<?php
    
    include('dbconnection.php');
    include('util.php');

    controlAccess();

    $elementList = $_POST["id"];
    $target = $_POST["target"];
    $deleteQuery = "";

    switch ($target) {
        case "client":
            $deleteQuery = "DELETE FROM CLIENTES WHERE ID_CLIENTE = ";
            $redirectDest = "client_list.php";
            break;
        
        case "vehicle":
            $deleteQuery = "DELETE FROM VEHICULOS WHERE ID_VEHICULO = ";
            $redirectDest = "vehicle_list.php";
            break;
    }

    for ($i = 0; $i < count($elementList); $i++) {
        $conn->query($deleteQuery . $elementList[$i]);
    }

    header("Location: $redirectDest");

?>


