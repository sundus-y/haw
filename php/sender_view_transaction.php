<!DOCTYPE html> <html>
    <head>
        <title>DtoE.com - View Transaction</title>
        <link rel="stylesheet" type="text/css" href="home_style.css"/> 
        <script type="text/javascript">
            window.onload = function (){
                var remark = document.getElementById('remark');
                remark.scrollTop = remark.scrollHeight;
            };
			
            function validate()
            {
                if( document.view_form.new_remark.value == "" )
                {
                    document.view_form.new_remark.value = "-";
                }
							
                return( true );
            }
			
            function cancelUpload()
            {
                document.getElementById("a_file").value = "";
            }
        </script>
    </head>
    <body>
        <?php
        session_start();
        require 'connectdb.php';
        require 'view.php';

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
                    <h3> <a href="sender_home.php" class="current_page"> Home </a></h3>
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
                    ?>
                    <h2>Transaction Details</h2>
                    <form enctype="multipart/form-data" action="update_trans.php" method="POST" name="update_form" onsubmit="return(validate())">
                        <?php
                        $trans_id = filter_var($_POST['trans_id'], FILTER_SANITIZE_STRING);
                        $trans_id = mysqli_real_escape_string($con, $trans_id);
                        echo "<input type='hidden' name='trans_id' value='" . $trans_id . "'>";
                        $query = "SELECT * FROM transactions WHERE ID = '" . $trans_id . "'";
                        $result = $con->query($query);

                        if ($result->num_rows == 0) {
                            echo "<h3> Transaction Does not Exist ! </h3>";
                        } else {
                            $row = $result->fetch_assoc();
                            ?>
                            <table border="1" width="100%" id="edit_form">
                                <tr>
                                    <td> <b> SENDER </b> </td>
                                    <td> <b> RECEIVER </b> </td>
                                </tr>
                                <tr valign="baseline">
                                    <td>
                                        Full Name:
                                        <input type="text" name="s_name" disabled="true" value="<?php echo $row['SENDER'] ?>"><br>
                                        Phone Number:
                                        <input type="text" name="s_number" disabled="true" value="<?php echo $row['SENDER_NUMBER'] ?>"><br>
                                        Amount:
                                        <input type="text" name="amount" disabled="true" value="<?php echo $row['AMOUNT'] ?>"><br>
                                        Rate:
                                        <input type="text" name="rate" disabled="true" value="<?php echo $row['RATE'] ?>">
                                    </td>
                                    <td>
                                        Full Name:
                                        <input type="text" name="r_name" disabled="true" value="<?php echo $row['RECEIVER'] ?>"><br>
                                        Phone Number:
                                        <input type="text" name="r_number" disabled="true" value="<?php echo $row['RECEIVER_NUMBER'] ?>"><br>
                                        Location:
                                        <input type="text" name="location" disabled="true" value="<?php echo $row['LOCATION'] ?>"><br>
                                        Amount in Birr:
                                        <input  disabled="true" value="<?php echo $row['AMOUNT'] * $row['RATE'] ?>">
                                    </td>
                                </tr>
                                <tr> 
                                    <td width="47%"> 
                                        <b> Remark </b> <br>
                                        <textarea cols='40' rows='5' id='remark' name="remark" disabled="true"><?php echo $row['REMARK'] ?></textarea>
                                        <br>
                                        <b> Attachments </b> <br>
                                        <?php
                                        $query2 = "SELECT * FROM uploads WHERE TRANSACTION_ID = '" . $trans_id . "'";

                                        $result2 = $con->query($query2);

                                        if ($result2->num_rows == 0) {
                                            echo "<h3> No Attachments for this Transaction ! </h3>";
                                        } else {
                                            ?>
                                            <select name='uploads' size='2'>
                                                <?php
                                                while ($row2 = $result2->fetch_assoc())
                                                    echo "<option>" . $row2['FILE_NAME'] . "</option>";
                                                ?>
                                            </select>
                                            <input type="submit" name="download" value="Download File">
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <b> Status </b> <br>
                                        <?php
                                        if ($row['STATUS'] == 1)
                                            echo "<input  disabled='true' value='Active / Not Seen'>";
                                        if ($row['STATUS'] == 2)
                                            echo "<input  disabled='true' value='Active / Seen'>";
                                        if ($row['STATUS'] == 3)
                                            echo "<input  disabled='true' value='Active / Contacted'>";
                                        if ($row['STATUS'] == 4)
                                            echo "<input  disabled='true' value='Finished / Cash'>";
                                        if ($row['STATUS'] == 5)
                                            echo "<input  disabled='true' value='Finished / Bank'>";
                                        if ($row['STATUS'] == 6)
                                            echo "<input  disabled='true' value='Active / Error'>";
                                        echo "<input name='status' value='{$row['STATUS']}' type='hidden'>";
                                        ?><br>
                                        <b> File Attachment </b> <br>
                                        <input type='file' id='a_file' name='a_file'><input type="button" value="Cancel" onclick="cancelUpload()"><br>
                                        <b> New Remark </b> <br>
                                        <textarea cols='45' rows='3' id='new_remark' name='new_remark' <?php if ($row['STATUS'] == 5 || $row['STATUS'] == 4) echo "disabled='disabled'"; ?> ></textarea>
                                        <input type="submit" value="Update Transaction" <?php if ($row['STATUS'] == 5 || $row['STATUS'] == 4) echo "disabled='disabled'"; ?> >
                                    </td>
                                </tr>
                            </table>
                            <?php
                        }
                        view($trans_id, $_SESSION['user_type']);
                        echo "asdfas";
                        ?>
                        <br>
                        </div>
                        <div id="bottom_containt">
                            Designed by: Sundus
                        </div>
                </div>
            </div>
    </body>
</html>