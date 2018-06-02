<?php
    
    include "classes/database.php";
    include "util/util.php";

    controlAccess();

    $db = Database::getInstance();
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

        case "replacement":
            $deleteQuery = "DELETE FROM REPUESTOS WHERE ID_REPUESTO = ";
            $redirectDest = "replacement_list.php";
            break;
    }

    for ($i = 0; $i < count($elementList); $i++) {
        $db->conn()->query($deleteQuery . $elementList[$i]);
    }

    header("Location: $redirectDest");

?>


