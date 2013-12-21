<html>
    <head>
        <title>DtoE.com - Home</title>
        <link rel="stylesheet" type="text/css" href="home_style.css"/> 
    </head>
    <body>
        <?php
        session_start();
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
                    <h3> <a href="sender_home.php"> Home </a></h3>
                    <h3> <a href="new_transaction.php"> Create New Transaction </a></h3>
                    <h3> <a href="sender_search_transaction.php" id="current_page"> Search for Transaction </a></h3>
                    <h3> <a href="sender_generate_report.php"> Generate Report </a></h3>
                </div>
                <div id="right_containt">
                    <h2>Search for Transaction<hr></h2>
                    <form action="search.php" method="POST">
                        <h3> 
                            Search by: 
                            <select name="search_by">
                                <option value="id">ID</option>
                                <option selected="true" value="sender_name">Sender Name</option>
                                <option value="receiver_name">Receiver Name</option>
                                <option value="location">Location</option>
                                <option value="date">Date</option>
                                <option value="amount">Amount</option>
                                <option value="amount_birr">Amount in Birr</option>
                                <option value="sender_number">Sender Number</option>
                                <option value="receiver_number">Receiver Number</option>
                            </select>
                            With: 
                            <input type="text" name="condition">
                            <input type="submit" value="Search">
                        </h3>
                    </form>
                    <hr>
                    <br>
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
                        if (isset($_SESSION['result'])) {
                            if ($_SESSION['result'][0] == 0) {
                                echo "<tr> <td colspan='9' style='text-align:center'> <h3> No Transaction Found </h3> </td> </tr>";
                            } else {
                                for ($i = 1; $i < $_SESSION['result'][0]; $i++) {
                                    $row = $_SESSION['result'][$i];
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
                                    else if ($row['STATUS'] == 4)
                                        echo "<input type = 'submit' value = 'Finished / Cash'>";
                                    else if ($row['STATUS'] == 5)
                                        echo "<input type = 'submit' value = 'Finished / Check'>";
                                    else if ($row['STATUS'] == 6)
                                        echo "<input type = 'submit' value = 'Active / Error'>";
                                    echo "</form>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            }
                            unset($_SESSION['result']);
                        }
                        ?>
                    </table>
                </div>
                <div id="bottom_containt">
                    Designed by: Sundus
                </div>
            </div>
        </div>
    </body>
</html>
