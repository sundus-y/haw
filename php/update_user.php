<?php

/* * * begin our session ** */
session_start();
require 'connectdb.php';
$user_id = filter_var($_POST['user_id'], FILTER_SANITIZE_STRING);
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
    if (isset($_POST['update']))
        $query = "UPDATE users
				SET USERNAME='{$user_name}',
					PASSWORD='{$password}',
					TYPE='{$account_type}',
					STATUS='{$status}'
				WHERE ID='{$user_id}'";
    else if (isset($_POST['delete']))
        $query = "DELETE FROM users WHERE ID='{$user_id}'";

    $con->query($query);

    /*     * * if update/delete fails ** */
    if ($con->affected_rows == 0) {
        header("Location: admin.php?error_code=302");
        exit();
    }
    /*     * * if update/delete is ok ** */ else {
        header("Location: admin_home.php");
    }
    $con->close();
}
?>