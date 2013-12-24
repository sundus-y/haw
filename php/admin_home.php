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
                    <h3> <a href="admin_home.php" class="current_page"> Account Administration </a></h3>
                    <h3> <a href="config_default.php"> Configure Defaults </a></h3>
                </div>
                <div id="right_containt">
                    <?php
                    require 'connectdb.php';
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
                    <h2 id="table_title">Add New User</h2>
                    <table border="1">
                        <tr id="table_header">
                            <td> ID </td>
                            <td> User Name </td>
                            <td> Password </td>
                            <td> Account Type </td>
                            <td> Account Status </td>
                            <td> Action </td>
                        </tr>
                        <tr>
                        <form action = 'create_user.php' method = 'POST'>
                            <td>------</td>
                            <td>
                                <input type='text' name='user_name'>
                            </td>
                            <td>
                                <input type='text' name='password'>
                            </td>
                            <td>
                                <select name='account_type'>
                                    <option value='1'> Sender </option>
                                    <option value='2'> Receiver </option>
                                    <option value='11'> Admin </option>
                                </select>
                            </td>
                            <td>
                                <select name='status'>
                                    <option value='1'> Active </option>
                                    <option value='2'> Disabled </option>
                                </select>
                            </td>
                            <td>
                                <input type = 'submit' value = 'Create User'>
                            </td>
                        </form>
                        </tr>
                    </table>
                    <h2 id="table_title">Accounts currently in the System</h2>
                    <table border="1">
                        <tr id="table_header">
                            <td> ID </td>
                            <td> User Name </td>
                            <td> Password </td>
                            <td> Account Type </td>
                            <td> Account Status </td>
                            <td> Update </td>
                            <td> Delete </td>
                        </tr>
<?php
$query = "SELECT * FROM users";
$result = $con->query($query);

if ($result->num_rows == 0) {
    echo "<tr> <td colspan='9' style='text-align:center'> <h3> No Users Registered </h3> </td> </tr>";
} else {
    while ($row = $result->fetch_assoc()) {
        echo "<tr> <form action = 'update_user.php' method = 'POST' onsubmit='return confirm(\"Are you sure you want to delete this User?\")'>";
        echo "<td>";
        echo "<input type='hidden' name='user_id' value='" . $row['ID'] . "'>";
        echo $row['ID'];
        echo "</td>";
        echo "<td>";
        echo "<input type='text' name='user_name' value='" . $row['USERNAME'] . "'>";
        echo "</td>";
        echo "<td>";
        echo "<input type='text' name='password' value='" . $row['PASSWORD'] . "'>";
        echo "</td>";
        echo "<td>";
        echo "<select name='account_type'>";
        echo "<option value='1'";
        if ($row['TYPE'] == 1)
            echo "selected";
        echo "> Sender </option>";
        echo "<option value='2'";
        if ($row['TYPE'] == 2)
            echo "selected";
        echo "> Receiver </option>";
        echo "<option value='11'";
        if ($row['TYPE'] == 11)
            echo "selected";
        echo "> Admin </option>";
        echo "</select>";
        echo "</td>";
        echo "<td>";
        echo "<select name='status'>";
        echo "<option value='1'";
        if ($row['STATUS'] == 1)
            echo "selected";
        echo "> Active </option>";
        echo "<option value='2'";
        if ($row['STATUS'] == 2)
            echo "selected";
        echo "> Disabled </option>";
        echo "</select>";
        echo "</td>";
        echo "<td> <input type = 'submit' name='update' value = 'Update'> </td>";
        echo "<td> <input class= 'delete' type = 'submit' name='delete' value = 'Delete'> </td>";
        echo "</form> </tr>";
    }
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