<?php

/* * * begin our session ** */
session_start();
require 'connectdb.php';
$search_by = filter_var($_POST['search_by'], FILTER_SANITIZE_STRING);
$condition = filter_var($_POST['condition'], FILTER_SANITIZE_STRING);
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
    if ($search_by == "sender_name") {
        search_by_sender_name($con, $condition);
    } elseif ($search_by == "receiver_name") {
        search_by_receiver_name($con, $condition);
    } elseif ($search_by == "id") {
        search_by_id($con, $condition);
    } elseif ($search_by == "location") {
        search_by_location($con, $condition);
    } elseif ($search_by == "amount") {
        search_by_amount($con, $condition);
    } elseif ($search_by == "amount_birr") {
        search_by_amount_birr($con, $condition);
    } elseif ($search_by == "sender_number") {
        search_by_sender_number($con, $condition);
    } elseif ($search_by == "receiver_number") {
        search_by_receiver_number($con, $condition);
    } elseif ($search_by == "date") {
        search_by_date($con, $condition);
    }
}

function search_by_sender_name($con, $condition) {
    $query = "SELECT * FROM transactions WHERE SENDER LIKE '%{$condition}%'";

    $result = $con->query($query);

    display_result($result);

    $con->close();
}

function search_by_receiver_name($con, $condition) {
    $query = "SELECT * FROM transactions WHERE RECEIVER LIKE '%{$condition}%'";

    $result = $con->query($query);

    display_result($result);

    $con->close();
}

function search_by_id($con, $condition) {
    $query = "SELECT * FROM transactions WHERE ID LIKE '%{$condition}%'";

    $result = $con->query($query);

    display_result($result);

    $con->close();
}

function search_by_location($con, $condition) {
    $query = "SELECT * FROM transactions WHERE LOCATION LIKE '%{$condition}%'";

    $result = $con->query($query);

    display_result($result);

    $con->close();
}

function search_by_amount($con, $condition) {
    $query = "SELECT * FROM transactions WHERE AMOUNT LIKE '%{$condition}%'";

    $result = $con->query($query);

    display_result($result);

    $con->close();
}

function search_by_amount_birr($con, $condition) {
    $query = "SELECT * FROM transactions WHERE AMOUNT * RATE LIKE '%{$condition}%'";

    $result = $con->query($query);

    display_result($result);

    $con->close();
}

function search_by_sender_number($con, $condition) {
    $query = "SELECT * FROM transactions WHERE SENDER_NUMBER LIKE '%{$condition}%'";

    $result = $con->query($query);

    display_result($result);

    $con->close();
}

function search_by_receiver_number($con, $condition) {
    $query = "SELECT * FROM transactions WHERE RECEIVER_NUMBER LIKE '%{$condition}%'";

    $result = $con->query($query);

    display_result($result);

    $con->close();
}

function search_by_date($con, $condition) {
    $query = "SELECT * FROM transactions WHERE DATE LIKE '%{$condition}%'";

    $result = $con->query($query);

    display_result($result);

    $con->close();
}

function display_result($result) {
    /*     * * if result is empty ** */
    if ($result->num_rows == 0) {
        $_SESSION['result'][0] = 0;
    }
    /*     * * if result is greater or equal to one ** */ else {
        $i = 1;
        while ($row = $result->fetch_assoc()) {
            $_SESSION['result'][$i] = $row;
            echo $_SESSION['result'][$i]['AMOUNT'];
            $i++;
        }
        $_SESSION['result'][0] = $i;
    }
    if ($_SESSION['user_type'] == 1)
        header("Location: sender_search_transaction.php");
    elseif ($_SESSION['user_type'] == 2)
        header("Location: receiver_search_transaction.php");
}

?>