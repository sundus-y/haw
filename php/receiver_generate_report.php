<!DOCTYPE html> <html>
    <head>
        <title>DtoE.com - View Transaction</title>
        <link rel="stylesheet" type="text/css" href="home_style.css"/> 
        <script type="text/javascript">
            function validate()
            {
                if( document.view_form.new_remark.value == "" )
                {
                    document.view_form.new_remark.value = "-";
                }
                return( true );
            }
        </script>
    </head>
    <body>
        <?php
        session_start();
        if (!(isset($_SESSION['user_id']) && $_SESSION['user_id'] != ''))
            header("Location: logout_process.php");
        if (!($_SESSION['user_type'] == 2))
            header("Location: logout_process.php");
        ?>
        <div id="container">
            <div id="header">
                <h3> Logedin as: <?php echo $_SESSION['user_username'] ?> <i> <u> <a href="logout_process.php"> Logout </a> </u> </i> </h3>
            </div>
            <div id="containt">
                <div id="left_containt">
                    <h3> <a href="receiver_home.php"> Home </a></h3>
                    <h3> <a href="receiver_search_transaction.php"> Search for Transaction </a></h3>
                    <h3> <a href="receiver_generate_report.php" id="current_page"> Generate Report </a></h3>
                </div>
                <div id="right_containt">
                    <h2>Generate Report<hr></h2>
                    <form action="generate_report.php" method="POST">
                        <h3>Monthly Report:</h3> 
                        Month:
                        <select name="m_month">
                            <option value="01">Jan</option>
                            <option value="02">Feb</option>
                            <option value="03">Mar</option>
                            <option value="04">Apr</option>
                            <option value="05">May</option>
                            <option value="06">Jun</option>
                            <option value="07">Jul</option>
                            <option value="08">Aug</option>
                            <option value="09">Sep</option>
                            <option value="10">Oct</option>
                            <option value="11">Nov</option>
                            <option value="12">Dec</option>
                        </select>
                        Year: 
                        <select name="m_year">
                            <option value="2013">2013</option>
                            <option value="2014">2014</option>
                            <option value="2015">2015</option>
                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                        </select>
                        <input type="submit" name="monthly_report" value="Generate">
                    </form>
                    <hr>
                    <form action="generate_report.php" method="POST">
                        <h3>Custom Report:</h3> 
                        Beginning Date:
                        <select name="b_month">
                            <option value="01">Jan</option>
                            <option value="02">Feb</option>
                            <option value="03">Mar</option>
                            <option value="04">Apr</option>
                            <option value="05">May</option>
                            <option value="06">Jun</option>
                            <option value="07">Jul</option>
                            <option value="08">Aug</option>
                            <option value="09">Sep</option>
                            <option value="10">Oct</option>
                            <option value="11">Nov</option>
                            <option value="12">Dec</option>
                        </select>
                        <select name="b_year">
                            <option value="2013">2013</option>
                            <option value="2014">2014</option>
                            <option value="2015">2015</option>
                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                        </select> 
                        Ending Date:
                        <select name="e_month">
                            <option value="01">Jan</option>
                            <option value="02">Feb</option>
                            <option value="03">Mar</option>
                            <option value="04">Apr</option>
                            <option value="05">May</option>
                            <option value="06">Jun</option>
                            <option value="07">Jul</option>
                            <option value="08">Aug</option>
                            <option value="09">Sep</option>
                            <option value="10">Oct</option>
                            <option value="11">Nov</option>
                            <option value="12">Dec</option>
                        </select>
                        <select name="e_year">
                            <option value="2013">2013</option>
                            <option value="2014">2014</option>
                            <option value="2015">2015</option>
                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                        </select>
                        Status:
                        <select name="status">
                            <option value="1">Only Active</option>
                            <option value="2">Only Completed</option>
                            <option value="99">All</option>
                        </select>
                        <input type="submit" name="custom_report"value="Generate">
                    </form>
                </div>
                <div id="bottom_containt">
                    Designed by: Sundus
                </div>
            </div>
        </div>
    </body>
</html>
