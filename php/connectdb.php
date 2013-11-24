<?php

if (isset($con))
    $con->close();

$con = new mysqli("localhost", "adminrdTYCLp", "qU65MCpSclmG", "php");
$_SESSION['connection'] = $con;

//$con = new mysqli("mysql1.000webhost.com", "a9237023_root", "HBugi!123", "a9237023_hawala");
?>
