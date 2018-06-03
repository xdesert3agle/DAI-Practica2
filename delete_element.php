<?php
    
    include "classes/database.php";
    include "util/util.php";

    controlAccess();

    $db = Database::getInstance();
    $elementList = $_POST["id"];
    $target = $_POST["target"];
    $deleteQuery = "";


    if ($target != "bill") {
        switch ($target) {
            case "client":
                $deleteQuery = "DELETE FROM clientes WHERE id_cliente = ";
                $redirectDest = "client_list.php";
                break;

            case "vehicle":
                $deleteQuery = "DELETE FROM vehiculos WHERE id_vehiculo = ";
                $redirectDest = "vehicle_list.php";
                break;

            case "replacement":
                $deleteQuery = "DELETE FROM repuestos WHERE id_repuesto = ";
                $redirectDest = "replacement_list.php";
                break;
        }

        for ($i = 0; $i < count($elementList); $i++) {
            $db->conn()->query($deleteQuery . $elementList[$i]);
        }

    } else {
        $deleteBillQuery = "DELETE FROM factura WHERE numero_factura = ";
        $deleteBillLineQuery = "DELETE FROM detalle_factura WHERE numero_factura = ";
        $redirectDest = "bill_list.php";

        for ($i = 0; $i < count($elementList); $i++) {
            $db->conn()->query($deleteBillLineQuery . $elementList[$i]);
            $db->conn()->query($deleteBillQuery . $elementList[$i]);
        }
    }


    header("Location: $redirectDest");


