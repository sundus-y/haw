<?php

/* * * begin our session ** */
session_start();
require 'connectdb.php';
$s_name = filter_var($_POST['s_name'], FILTER_SANITIZE_STRING);
$s_number = filter_var($_POST['s_number'], FILTER_SANITIZE_STRING);
$amount = filter_var($_POST['amount'], FILTER_SANITIZE_STRING);
$rate = filter_var($_POST['rate'], FILTER_SANITIZE_STRING);
$r_name = filter_var($_POST['r_name'], FILTER_SANITIZE_STRING);
$r_number = filter_var($_POST['r_number'], FILTER_SANITIZE_STRING);
$location = filter_var($_POST['location'], FILTER_SANITIZE_STRING);
$remark = filter_var($_POST['remark'], FILTER_SANITIZE_STRING);

//$con = new mysqli("mysql1.000webhost.com","a9237023_root","HBugi!123","a9237023_hawala");
// Check connection
if ($con->connect_errno) {
    header("Location: new_transaction.php?error_code=101");
    exit();
} else {

    $query = "INSERT INTO transactions (USER_ID,SENDER, SENDER_NUMBER, RECEIVER, RECEIVER_NUMBER, LOCATION, AMOUNT, RATE, DATE, REMARK, LAST_UPDATE, LAST_UPDATE_BY)
						VALUES('{$_SESSION['user_id']}','{$s_name}','{$s_number}','{$r_name}','{$r_number}','{$location}','{$amount}','{$rate}',
						'" . date('Y/m/d') . "','" . $_SESSION['user_username'] . "(" . date('Y/m/d') . "): " . $remark . "','" . date('Y/m/d') . "','{$_SESSION['user_id']}')";
    $result = $con->query($query);

    /*     * * if insertion fails ** */
    if (!($result)) {
        header("Location: new_transaction.php?error_code=301");
        exit();
    }
    /*     * * if insertion is ok ** */ else {
        header("Location: sender_home.php");
    }
    $con->close();
}
?>