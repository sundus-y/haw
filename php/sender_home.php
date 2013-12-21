<html>
    <head>
        <title>DtoE.com - Home</title>
        <link rel="stylesheet" type="text/css" href="home_style.css"/> 
    </head>
    <body>
        <?php
        session_start();
        require 'connectdb.php';
        if (!(isset($_SESSION['user_id']) && $_SESSION['user_id'] != ''))
            header("Location: logout_process.php");
        if (!($_SESSION['user_type'] == 1))
            header("Location: logout_process.php");
        ?>
        <div id="container">
            <div id="header">
                <h3> Logedin as: <?php echo $_SESSION['user_username'] ?> <i> <u> <a href="logout_process.php"> Logout </a> </u> </i> </h3>
            </div>
            <div id="containt">
                <div id="left_containt">
                    <h3> <a href="sender_home.php" id="current_page"> Home </a></h3>
                    <h3> <a href="new_transaction.php"> Create New Transaction </a></h3>
                    <h3> <a href="sender_search_transaction.php"> Search for Transaction </a></h3>
                    <h3> <a href="sender_generate_report.php"> Generate Report </a></h3>
                </div>
                <div id="right_containt">
                    <?php
                    //$con = new mysqli("mysql1.000webhost.com","a9237023_root","HBugi!123","a9237023_hawala");
                    if ($con->connect_errno) {
                        echo "<h2> Sorry there was error connecting to the Database. </h2>";
                        exit();
                    }
                    if (isset($_GET['error_code'])) {
                        if ($_GET['error_code'] == 101)
                            echo "<span id='error'> Sorry there was error connecting to the Database. </span>";
                        elseif ($_GET['error_code'] == 302)
                            echo "<span id='error'> Sorry update failed please try again. </span>";
                    }
                    ?>
                    <h2 id="table_title">Active Transactions</h2>
                    <table border="1">
                        <tr id="table_header">
                            <td> ID </td>
                            <td> Sender Name </td>
                            <td> Receiver Name </td>
                            <td> Location </td>
                            <td> Amount </td>
                            <td> Rate </td>
                            <td> Amount in Birr </td>
                            <td> Date </td>
                            <td> Status </td>
                        </tr>
<?php
$query = "SELECT * FROM transactions WHERE status = 1 OR status = 2 OR status = 3 OR status = 6 ORDER BY DATE DESC, STATUS ASC, ID DESC";
$result = $con->query($query);

if ($result->num_rows == 0) {
    echo "<tr> <td colspan='9' style='text-align:center'> <h3> No Active Transaction </h3> </td> </tr>";
} else {
    while ($row = $result->fetch_assoc()) {
        if (($row['LAST_UPDATE_BY'] != $_SESSION['user_id']) and ($row['SEEN'] == 0))
            echo "<tr id='unread'>";
        else
            echo "<tr>";
        echo "<td>" . $row['ID'] . "</td>";
        echo "<td>" . $row['SENDER'] . "</td>";
        echo "<td>" . $row['RECEIVER'] . "</td>";
        echo "<td>" . $row['LOCATION'] . "</td>";
        echo "<td>" . $row['AMOUNT'] . "</td>";
        echo "<td>" . $row['RATE'] . "</td>";
        echo "<td>" . $row['RATE'] * $row['AMOUNT'] . "</td>";
        echo "<td>" . $row['DATE'] . "</td>";
        echo "<td>";
        echo "<form action = 'sender_view_transaction.php' method = 'POST'>";
        echo "<input type='hidden' name='trans_id' value='" . $row['ID'] . "'>";
        if ($row['STATUS'] == 1)
            echo "<input type = 'submit' value = 'Active / Not Seen'>";
        else if ($row['STATUS'] == 2)
            echo "<input type = 'submit' value = 'Active / Seen'>";
        else if ($row['STATUS'] == 3)
            echo "<input type = 'submit' value = 'Active / Contacted'>";
        else if ($row['STATUS'] == 6)
            echo "<input type = 'submit' value = 'Active / Error'>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
}
?>
                    </table>
                    <h2 id="table_title">Completed Transactions</h2>
                    <table border="1">
                        <tr id="table_header">
                            <td> ID </td>
                            <td> Sender Name </td>
                            <td> Receiver Name </td>
                            <td> Location </td>
                            <td> Amount </td>
                            <td> Rate </td>
                            <td> Amount in Birr </td>
                            <td> Date </td>
                            <td> Status </td>
                        </tr>
<?php
$query = "SELECT * FROM transactions WHERE status = 4 OR status = 5 ORDER BY DATE DESC, STATUS ASC, ID DESC";
$result = $con->query($query);

if ($result->num_rows == 0) {
    echo "<tr> <td colspan='9' style='text-align:center'> <h3> No Completed Transaction </h3> </td> </tr>";
} else {
    while ($row = $result->fetch_assoc()) {
        if (($row['LAST_UPDATE_BY'] != $_SESSION['user_id']) and ($row['SEEN'] == 0))
            echo "<tr id='unread'>";
        else
            echo "<tr>";
        echo "<td>" . $row['ID'] . "</td>";
        echo "<td>" . $row['SENDER'] . "</td>";
        echo "<td>" . $row['RECEIVER'] . "</td>";
        echo "<td>" . $row['LOCATION'] . "</td>";
        echo "<td>" . $row['AMOUNT'] . "</td>";
        echo "<td>" . $row['RATE'] . "</td>";
        echo "<td>" . $row['RATE'] * $row['AMOUNT'] . "</td>";
        echo "<td>" . $row['DATE'] . "</td>";
        echo "<td>";
        echo "<form action = 'sender_view_transaction.php' method = 'POST'>";
        echo "<input type='hidden' name='trans_id' value='" . $row['ID'] . "'>";
        if ($row['STATUS'] == 4)
            echo "<input type = 'submit' value = 'Finished / Cash'>";
        else if ($row['STATUS'] == 5)
            echo "<input type = 'submit' value = 'Finished / Bank'>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
}
?>
                    </table><br>
                </div>
                <div id="bottom_containt">
                    Designed by: Sundus
                </div>
            </div>
        </div>
    </body>
</html>
