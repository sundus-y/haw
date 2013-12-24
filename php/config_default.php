<!DOCTYPE html> <html>
    <head>
        <title>Hawala.com - Admin</title>
        <link rel="stylesheet" type="text/css" href="home_style.css"/> 
    </head>
    <body>
        <?php
        session_start();
        if (!(isset($_SESSION['user_id']) && $_SESSION['user_id'] != ''))
            header("Location: logout_process.php");
        if (!($_SESSION['user_type'] == 11))
            header("Location: logout_process.php");
        ?>
        <div id="container">
            <div id="header">
                <h3> Logedin as: Administrator <i> <u> <a href="logout_process.php"> Logout </a> </u> </i> </h3>
            </div>
            <div id="containt">
                <div id="left_containt">
                    <h3> <a href="admin_home.php"> Account Administration </a></h3>
                    <h3> <a href="config_default.php" class="current_page"> Configure Defaults </a></h3>
                </div>
                <div id="right_containt">
                    <?php
                    require 'connectdb.php';
                    if (isset($_GET['error_code'])) {
                        if ($_GET['error_code'] == 101)
                            echo "<span id='error'> Sorry there was error connecting to the Database. </span>";
                        elseif ($_GET['error_code'] == 302)
                            echo "<span id='error'> Sorry update failed please try again. </span>";
                        elseif ($_GET['error_code'] == 312)
                            echo "<span id='error'> Defaults Updated Successfuly. </span>";
                        elseif ($_GET['error_code'] == 311)
                            echo "<span id='error'> New Default Added Successfuly. </span>";
                    }
                    if ($con->connect_errno) {
                        echo "<h2> Sorry there was error connecting to the Database. </h2>";
                        exit();
                    }
                    else{
                        $query = "SELECT * FROM defaults";
                        $result = $con->query($query); 
                        if ($result->num_rows == 0) {
                            $defaults['rate'] = "0.0";
                        } else {
                            while ($row = $result->fetch_assoc()) {
                                $defaults[$row['NAME']] = $row['VALUE'];
                            }
                        }
                    }
                    ?>
                    <h2 id="table_title">Configure Defaults</h2>
                    <h3>Default Rate:</h3>
                    <form action = 'update_defaults.php' method = 'POST'>
                        <input type="hidden" name="name" value="rate">
                        Exchange Rate: <?php echo "<input type='text' name='value' value='{$defaults['rate']}'>"; ?>
                        <input type = 'submit' name="update" value = 'Update Rate'>
                    </form>
                    <h3>Default Urgent Message:</h3>
                    <form action = 'update_defaults.php' method = 'POST'>
                        <input type="hidden" name="name" value="urgent">
                        Urgent Message: <?php echo "<input class='extra_wide' type='text' name='value' value='{$defaults['urgent']}'>"; ?>
                        <input type = 'submit' name="update" value = 'Update Urgent'>
                    </form>
                    <h3>Location:</h3>
                    <form action = 'update_defaults.php' method = 'POST'>
                        New Location: <input type='text' name='location'>
                        <input type = 'submit' name="insert" value = 'Add Location'>
                    </form>
                </div>
                <div id="bottom_containt">
                    Designed by: Sundus
                </div>
            </div>
        </div>
    </body>
</html>