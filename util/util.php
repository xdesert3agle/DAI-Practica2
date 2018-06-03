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

    function controlAccess(){
        if (!isLogged()) {
            header("Location: login.php");
        }
    }

    function parseDateToYMD($date){
        $splitDate = explode('/', $date);
        return $splitDate[2]. '-' .$splitDate[1]. '-' .$splitDate[0];
    }
?>