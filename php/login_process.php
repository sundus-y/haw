<?php

/* * * begin our session ** */
session_start();

require 'connectdb.php';

$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

// Check connection
if ($con->connect_errno) {
    header("Location: index.php?error_code=101");
    exit();
} else {
    $query = "SELECT * FROM users WHERE username='{$username}' and password='{$password}' and status = 1";
    $result = $con->query($query);

    /*     * * if we have no result then fail boat ** */
    if ($result->num_rows == 0) {
        $message = 'Login Failed';
        header("Location: index.php?error_code=201");
        exit();
    }
    /*     * * if we do have a result ** */ else {
        $row = $result->fetch_assoc();

        /*         * * set the session user_id variable ** */
        $_SESSION['user_id'] = $row['ID'];
        $_SESSION['user_username'] = $row['USERNAME'];
        $_SESSION['user_type'] = $row['TYPE'];

        $result->close();
        if ($_SESSION['user_type'] == 1)
            header("Location: sender_home.php");
        else if ($_SESSION['user_type'] == 2)
            header("Location: receiver_home.php");
        else if ($_SESSION['user_type'] == 11)
            header("Location: admin_home.php");
    }
    $con->close();
}
?>