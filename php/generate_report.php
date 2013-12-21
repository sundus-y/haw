<?php

    /* * * begin our session ** */
    session_start();
    require 'connectdb.php';
    require 'generate_excel.php';

    if ($con->connect_errno) {
        if ($_SESSION['user_type'] == 1)
            header("Location: sender_generate_report.php?error_code=101");
        elseif ($_SESSION['user_type'] == 2)
            header("Location: receiver_generate_reposrt.php?error_code=101");
        exit();
    }
    else {
        if(isset($_POST['monthly_report'])){
            $m_month = filter_var($_POST['m_month'], FILTER_SANITIZE_STRING);
            $m_year = filter_var($_POST['m_year'], FILTER_SANITIZE_STRING);
            $excelreport = new GenerateExcel($con);
            $excelreport->setMonthlyReportValue($m_month, $m_year);
            $excelreport->generateReport();
            echo "monthly";
            exit();
            $query = "INSERT INTO users (USERNAME, PASSWORD, TYPE, STATUS)
                            VALUES('{$user_name}','{$password}','{$account_type}','{$status}')";

        }
        elseif (isset($_POST['custom_report'])){
            $b_month = filter_var($_POST['b_month'], FILTER_SANITIZE_STRING);
            $b_year = filter_var($_POST['b_year'], FILTER_SANITIZE_STRING);
            $e_month = filter_var($_POST['e_month'], FILTER_SANITIZE_STRING);
            $e_year = filter_var($_POST['e_year'], FILTER_SANITIZE_STRING);
            $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
            $excelreport = new GenerateExcel($con);
            $excelreport->setCustomReportValue($b_month, $b_year, $e_month, $e_year, $status);
            $excelreport->generateReport();
            echo "custom";
            exit();
        } 
            
        $result = $con->query($query);

        /*     * * if insertion fails ** */
        if (!($result)) {
            if ($_SESSION['user_type'] == 1)
                header("Location: sender_generate_report.php?error_code=301");
            elseif ($_SESSION['user_type'] == 2)
                header("Location: receiver_generate_reposrt.php?error_code=301");
            exit();
        }
        /*     * * if insertion is ok ** */ 
        else {
            if ($_SESSION['user_type'] == 1)
                header("Location: sender_generate_report.php");
            elseif ($_SESSION['user_type'] == 2)
                header("Location: receiver_generate_reposrt.php");
            exit();
        }
        $con->close();
    }
?>