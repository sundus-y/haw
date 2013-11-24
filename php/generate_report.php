<?php

require 'connectdb.php';

$content = "No \t Transaction ID \t Sender Name \t Receiver Name \t Location \t Amount \t Rate \t Total \t Date \t \n";
$total_amount = 0;
$total_rate = 0;
$query = "SELECT * FROM transactions ORDER BY DATE DESC, STATUS ASC, ID DESC";
$result = $con->query($query);

if ($result->num_rows == 0) {
    $content .= "No Transactions Recorded";
} else {
    $i = 1;
    while ($row = $result->fetch_assoc()) {
        $content .= $i;
        $content .= "\t" . $row['ID'];
        $content .= "\t" . $row['SENDER'];
        $content .= "\t" . $row['RECEIVER'];
        $content .= "\t" . $row['LOCATION'];
        $content .= "\t" . $row['AMOUNT'];
        $content .= "\t" . $row['RATE'];
        $content .= "\t" . $row['RATE'] * $row['AMOUNT'];
        $content .= "\t" . $row['DATE'];
        $content .= "\t \n";
        $i++;
        $total_amount += $row['AMOUNT'];
        $total_rate += $row['RATE'];
    }
    $content .= "\t\t\t\t Grand Total: \t" . $total_amount ."\t\t".$total_amount * $total_rate ."\t\n";
}

$filename = "excelreport.xls";
header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename=' . $filename);
echo $content;
?>
