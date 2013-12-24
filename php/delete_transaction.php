<?php

session_start();
require 'connectdb.php';
$transaction_id = filter_var($_POST['trans_id'], FILTER_SANITIZE_STRING);

// Check connection
if ($con->connect_errno) {
    header("Location: sender_home.php?error_code=101");
    exit();
} 
else {
    $query = "DELETE FROM transactions WHERE ID='{$transaction_id}'";

    $con->query($query);

    /*     * * if update/delete fails ** */
    if ($con->affected_rows == 0) {
        header("Location: sender_home.php?error_code=302");
        exit();
    }
    /*     * * if update/delete is ok ** */ else {
        header("Location: sender_home.php");
    }
    $con->close();
}
?>
