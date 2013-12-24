<?php

if (isset($con))
    $con->close();

//$con = new mysqli("localhost", "root", "mysql123", "dtoe");
$con = new mysqli("127.5.63.130", "adminrdTYCLp", "qU65MCpSclmG", "php");

$_SESSION['connection'] = $con;

?>
