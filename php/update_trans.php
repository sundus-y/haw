<?php

/* * * begin our session ** */
session_start();
require 'connectdb.php';
ini_set('display_errors',1); 
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

$new_remark = filter_var($_POST['new_remark'], FILTER_SANITIZE_STRING);
$trans_id = filter_var($_POST['trans_id'], FILTER_SANITIZE_STRING);
$status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
$a_file = filter_var($_FILES['a_file']['name'], FILTER_SANITIZE_STRING);
$download_file = filter_var($_POST['uploads'], FILTER_SANITIZE_STRING);

//$con = new mysqli("mysql1.000webhost.com","a9237023_root","HBugi!123","a9237023_hawala");
// Check connection
if ($con->connect_errno) {
    if ($_SESSION['user_type'] == 1)
        header("Location: sender_home.php?error_code=101");
    elseif ($_SESSION['user_type'] == 2)
        header("Location: receiver_home.php?error_code=101");
    exit();
}
else {
    if (isset($_POST['download']))
        header("Location: download.php?file={$download_file}");
    else {
        $query = "UPDATE transactions 
					SET STATUS='{$status}', 
						REMARK=CONCAT(REMARK,'\n" . $_SESSION['user_username'] . "(" . date("Y/m/d") . "): " . $new_remark . "'), 
						LAST_UPDATE='" . date("Y/m/d") . "',
						LAST_UPDATE_BY='{$_SESSION['user_id']}',
						SEEN='0'
					WHERE ID='{$trans_id}'";



        $con->query($query);

        /*         * * if Update fails ** */
        if ($con->affected_rows == 0) {
            $con->close();
            if ($_SESSION['user_type'] == 1)
                header("Location: sender_home.php?error_code=302");
            elseif ($_SESSION['user_type'] == 2)
                header("Location: receiver_home.php?error_code=302");
            exit();
        }
        /*         * * if Update is ok ** */
        else {
            
            if ($a_file != "") {
                $target = dirname(__FILE__) . "/upload/";
                
                $target = $target . basename($_FILES['a_file']['name']);
                
                if (move_uploaded_file($_FILES['a_file']['tmp_name'], $target)) {
                   
                    $query = "INSERT INTO uploads (TRANSACTION_ID,FILE_NAME) VALUES ('{$trans_id}','{$a_file}')";
                    
                    $con->query($query);
                }
            }
            $con->close();
            if ($_SESSION['user_type'] == 1)
                header("Location: sender_home.php");
            elseif ($_SESSION['user_type'] == 2)
                header("Location: receiver_home.php");
        }
    }
}
?>