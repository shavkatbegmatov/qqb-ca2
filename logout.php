<?php

require 'connect/db.php';

session_start();

if (isset($_SESSION['user'])) {
    unset($_SESSION['user']);

    header('Location: http://project.loc/auth.php');
}

?>