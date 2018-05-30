<?php

    function isLogged() {
        if(!isset($_SESSION)) {
            session_start();
        }
        
        if (isset($_SESSION['isLogged'])) {
            return $_SESSION['isLogged'] == 'logged';
        }

        return false;
    }

    function getNewClientID(){
        global $conn;

        $result = $conn->query("SELECT * FROM CLIENTES WHERE ID_CLIENTE = (SELECT MAX(ID_CLIENTE) FROM CLIENTES)");

        return $result->fetch_assoc()['id_cliente'] + 1;
    }

?>