<?php
    session_start();
    if (!isset($_SESSION["login"])) {
        header("Location: login.php");
        exit;
    }
    require 'functions.php';

    $id = $_GET['n'];

    if(delete($id) > 0){
        header("Location: table.php");
        die();
    }else{
        header("Location: table.php");
        die();
    }

?>