<?php

function view($trans_id, $user_type) {
    // Check connection
    //$con = new mysqli("mysql1.000webhost.com", "a9237023_root", "HBugi!123", "a9237023_hawala");
    $con = $_SESSION['connection'];
    if ($con->connect_errno) {
        if ($user_type == 1)
            header("Location: sender_home.php?error_code=101");
        elseif ($user_type == 2)
            header("Location: receiver_home.php?error_code=101");
        exit();
    }
    else {
        $query = "UPDATE transactions SET SEEN='1' WHERE ID='{$trans_id}' AND LAST_UPDATE_BY != '{$_SESSION['user_id']}'";
        
        $result = $con->query($query);

        $con->close();
    }
}

?>