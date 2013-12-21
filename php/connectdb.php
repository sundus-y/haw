<?php

if (isset($con))
  $con->close();

//$con = new mysqli("localhost", "root", "mysql123", "dtoe");
  $con = new mysqli("localhost", "root", "qU65MCpSclmG", "php");
$_SESSION['connection'] = $con;

?>
