<?php
error_reporting(E_ALL);

        if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }

        if (!isset($_SESSION["user"])) {  
        header("location:../user-login/login.php");
}
