<?php
    include "util/util.php";

    if (isLogged()) {
        session_destroy();
    }

    header("Location: login.php");

