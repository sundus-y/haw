<?php
class GenerateExcel{

    var $content = "";
    public $total_number_of_transactions = 0;
    public $total_value_of_transactions = 0;
    public $total_value_of_exchange = 0;
    var $total_rate = 0;
    public $report_title = "";

    var $result = NIL;
    var $con = NIL;
    
    function __construct($con) {
        $this->con = $con;
    }

    public function setMonthlyReportValue($month, $year){
        $query = "SELECT * FROM transactions 
                WHERE MONTH(DATE) = {$month} AND YEAR(DATE) = {$year}
                ORDER BY DATE DESC, STATUS ASC, ID DESC";
        $this->result = $this->con->query($query);
        
        $this->report_title = "Monthly_{$month}-{$year}_Report";
        $this->content .= "Monthly Transaction Report for {$month}/{$year}\n";
    }

    public function setCustomReportValue($bmonth, $byear, $emonth, $eyear, $status){
        $begining_date = "{$byear}{$bmonth}01";
        if ($emonth == 12) {
            $emonth = 1;
            $eyear += 1;
        }
        $ending_date = "{$eyear}{$emonth}01";
        $query = "SELECT * FROM transactions
                WHERE (DATE >= {$begining_date} AND DATE < {$ending_date})";
        if ($status == 1){
            $status_str = "Active";
            $query .= " AND (STATUS = 1 OR STATUS = 2 OR STATUS = 3 OR STATUS = 6)";
        }
        elseif ($status == 2){
            $status_str = "Completed";
            $query .= " AND (STATUS = 4 OR STATUS = 5)";
        }
        elseif ($status == 99){
            $status_str = "All";
        }

        $query .= " ORDER BY DATE DESC, STATUS ASC, ID DESC";        
        $this->result = $this->con->query($query);
        
        $this->report_title = "Custom_{$bmonth}-{$byear}_{$emonth}-{$eyear}_{$status_str}_Report";
        $this->content .= "Custom Transaction Report between {$bmonth}/{$byear} -- {$emonth}/{$eyear} for {$status_str} Transactions\n";
    }

    public function generateReport(){
        if ($this->result->num_rows == 0) {
            $this->content .= "No Transactions Recorded";
        } else {
            $this->content .= "No \t Transaction ID \t Sender Name \t Receiver Name \t Location \t Amount \t Rate \t Total \t Date \t \n";
            $i = 1;
            while ($row = $this->result->fetch_assoc()) {
                $this->content .= $i;
                $this->content .= "\t" . $row['ID'];
                $this->content .= "\t" . $row['SENDER'];
                $this->content .= "\t" . $row['RECEIVER'];
                $this->content .= "\t" . $row['LOCATION'];
                $this->content .= "\t" . $row['AMOUNT'];
                $this->content .= "\t" . $row['RATE'];
                $this->content .= "\t" . $row['RATE'] * $row['AMOUNT'];
                $this->content .= "\t" . $row['DATE'];
                $this->content .= "\t \n";
                $i++;
                $total_value_of_transactions += $row['AMOUNT'];
                $total_rate += $row['RATE'];
            }
            $total_value_of_exchange = $total_value_of_transactions * $total_rate;
            $this->content .= "\t\t\t\t Grand Total: \t" . $total_value_of_transactions ."\t\t". $total_value_of_exchange  ."\t\n";
        }

        $filename = "{$this->report_title}.xls";
        header('Content-type: application/ms-excel');
        header('Content-Disposition: attachment; filename=' . $filename);
        echo $this->content;
    }
}
?>
