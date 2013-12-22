<!DOCTYPE html> <html>
    <head>
        <title>DtoE.com - New Transaction</title>
        <link rel="stylesheet" type="text/css" href="home_style.css"/>
        <script type="text/javascript">

            function validate()
            {
		 
                if( document.new_form.s_name.value == "" )
                {
                    alert( "Please provide Sender Name!" );
                    document.new_form.s_name.focus() ;
                    return false;
                }
                if( document.new_form.amount.value == "" )
                {
                    alert( "Please provide Amount!" );
                    document.new_form.amount.focus() ;
                    return false;
                }
                if( document.new_form.rate.value == "" )
                {
                    alert( "Please provide Rate!" );
                    document.new_form.rate.focus() ;
                    return false;
                }
                if( document.new_form.r_name.value == "" )
                {
                    alert( "Please provide Reciver Name!" );
                    document.new_form.r_name.focus() ;
                    return false;
                }
                if( document.new_form.r_number.value == "" )
                {
                    alert( "Please provide Reciver Number!" );
                    document.new_form.r_number.focus() ;
                    return false;
                }
                if( document.new_form.location.value == "" )
                {
                    alert( "Please provide Location!" );
                    document.new_form.location.focus() ;
                    return false;
                }
                var amount_str = document.new_form.amount.value;
                var amount_num = +amount_str;
                if(isNaN(amount_num))
                {
                    alert( "Please provide valid Amount!" );
                    document.new_form.amount.focus();
                    return false;
                }
                var rate_str = document.new_form.rate.value;
                var rate_num = +rate_str;
                if(isNaN(rate_num))
                {
                    alert( "Please provide valid Rate!" );
                    document.new_form.rate.focus();
                    return false;
                }
                if( document.new_form.remark.value == "" )
                {
                    document.new_form.remark.value = "-";
                }
                return( true );
            }
			
            function calc()
            {
                if( document.new_form.amount.value == "" )
                {
                    alert( "Please provide Amount!" );
                    document.new_form.amount.focus() ;
                    return false;
                }
                var amount_str = document.new_form.amount.value;
                var amount_num = +amount_str;
                if(isNaN(amount_num))
                {
                    alert( "Please provide valid Amount!" );
                    document.new_form.amount.focus();
                    return false;
                }
                if( document.new_form.rate.value == "" )
                {
                    alert( "Please provide Rate!" );
                    document.new_form.rate.focus() ;
                    return false;
                }
                var rate_str = document.new_form.rate.value;
                var rate_num = +rate_str;
                if(isNaN(rate_num))
                {
                    alert( "Please provide valid Rate!" );
                    document.new_form.rate.focus();
                    return false;
                }
                document.new_form.exchange.value = rate_num * amount_num;
            }
        </script>		
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
                <h3> Logedin as: <?php echo $_SESSION['user_username']; ?> <i> <u> <a href="logout_process.php"> Logout </a> </u> </i> </h3>
            </div>
            <div id="containt">
                <div id="left_containt">
                    <h3> <a href="sender_home.php"> Home </a></h3>
                    <h3> <a href="new_transaction.php" id="current_page"> Create New Transaction </a></h3>
                    <h3> <a href="sender_search_transaction.php"> Search for Transaction </a></h3>
                    <h3> <a href="sender_generate_report.php"> Generate Report </a></h3>
                </div>
                <div id="right_containt">
                    <?php
                    if ($con->connect_errno) {
                        echo "<h2> Sorry there was error connecting to the Database. </h2>";
                        exit();
                    }
                    ?>
                    <h2>Create New Transactions<hr></h2>
                    <div align="left" id="error"> 
                        <?php
                        if (isset($_GET['error_code']))
                            if ($_GET['error_code'] == 101)
                                echo "Sorry there was error connecting to the Database.";
                            elseif ($_GET['error_code'] == 301)
                                echo "Sorry there was error writing to the Database. Please try again";
                        ?>
                    </div>
                    <form action="create_trans.php" method="POST" name="new_form" onsubmit="return(validate())">
                        <table border="1" width="100%" id="new_form">
                            <tr>
                                <td> <b> SENDER </b> </td>
                                <td> <b> RECEIVER </b> </td>
                            </tr>
                            <tr valign="baseline">
                                <td>
                                    Full Name:
                                    <input type="text" name="s_name"><br>
                                    Phone Number:
                                    <input type="text" name="s_number"><br>
                                    Amount:
                                    <input type="text" name="amount"><br>
                                    Rate:
                                    <input type="text" name="rate">
                                </td>
                                <td>
                                    Full Name:
                                    <input type="text" name="r_name"><br>
                                    Phone Number:
                                    <input type="text" name="r_number"><br>
                                    Location:
                                    <input list="location" type="text" name="location" placeholder="e.g: Addis Ababa, Hawassa, . . ." style="width:42%"><br>
                                    <datalist id="location">
                                        <?php
                                            $query = "SELECT * FROM location";
                                            $result = $con->query($query);
                                            if (!($result->num_rows == 0)) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value='{$row["NAME"]}'>{$row['NAME']}";
                                                }
                                            }
                                        ?>
                                    </datalist>
                                    Amount in Birr:
                                    <input disabled="true" name="exchange">
                                    <input type="button" value="Update" onclick="calc();" >
                                </td>
                            </tr>
                            <tr> 
                                <td colspan="2"> 
                                    <b> Remark </b> <br>
                                    <textarea cols='88' rows='8' name="remark"></textarea>
                                    <br>
                                    <input type="submit" value="Create Transaction">
                                </td>
                            </tr>
                        </table>
                        <br>
                        </div>
                        <div id="bottom_containt">
                            Designed by: Sundus
                        </div>
                </div>
            </div>
    </body>
</html>
