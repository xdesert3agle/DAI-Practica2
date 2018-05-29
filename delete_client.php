<?php
    
    include('dbconnection.php');

    /*
    $id = $_POST['id'];
    $conn->query("DELETE FROM CLIENTES WHERE ID_CLIENTE = " .$id);
    
    header("Location: clients.php");
    */

    $client_list = $_POST["id"];

    for ($i = 0; $i < count($client_list); $i++) {
        $sqlQuery = "DELETE FROM CLIENTES WHERE ID_CLIENTE = " .$client_list[$i];

        $conn->query($sqlQuery);
    }

    header("Location: clients.php");

?>