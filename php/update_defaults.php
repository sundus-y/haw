<?php
session_start();
require 'connectdb.php';
$default_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
$default_value = filter_var($_POST['value'], FILTER_SANITIZE_STRING);
$location = filter_var($_POST['location'], FILTER_SANITIZE_STRING);

// Check connection
if ($con->connect_errno) {
    header("Location: config_default.php?error_code=101");
    exit();
} 
else {
    if (isset($_POST['update']))
        $query = "UPDATE defaults SET VALUE='{$default_value}' WHERE NAME='{$default_name}'";
    else if (isset($_POST['insert']))
        $query = "INSERT INTO locations (NAME) VALUES('${location}')";

    $con->query($query);

    /*     * * if update fails ** */
    if ($con->affected_rows == 0) {
        header("Location: config_default.php?error_code=302");
        exit();
    }
    /*     * * if update/insert is ok ** */ else {
        if(isset($_POST['update']))
            header("Location: config_default.php?error_code=312");
        elseif(isset ($_POST['insert']))
            header("Location: config_default.php?error_code=311");
    }
    $con->close();
}
?>
