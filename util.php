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

?>