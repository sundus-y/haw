<?php

/* * * begin our session ** */
session_start();
require 'connectdb.php';
$user_name = filter_var($_POST['user_name'], FILTER_SANITIZE_STRING);
$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
$account_type = filter_var($_POST['account_type'], FILTER_SANITIZE_STRING);
$status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);

//$con = new mysqli("mysql1.000webhost.com","a9237023_root","HBugi!123","a9237023_hawala");
// Check connection
if ($con->connect_errno) {
    header("Location: admin_home.php?error_code=101");
    exit();
} else {

    $query = "INSERT INTO users (USERNAME, PASSWORD, TYPE, STATUS)
			VALUES('{$user_name}','{$password}','{$account_type}','{$status}')";

    $result = $con->query($query);

    /*     * * if insertion fails ** */
    if (!($result)) {
        header("Location: admin_home.php?error_code=301");
        exit();
    }
    /*     * * if insertion is ok ** */ else {
        header("Location: admin_home.php");
    }
    $con->close();
}
?>