<?php

    function dbConnect(){
        $host = 'localhost';
        $db = 'taller';
        $user = 'root';
        $pwd = '';

        return new mysqli($host, $user, $pwd, $db);
    }

    $conn = dbConnect();

?>