<?php

include('../config/dbConfig.php');

session_start();
$flag = 0;
$thead = 1;
if (isset($_SESSION['salaryDate']) && ($_SESSION['salaryDate']) != '') {
    $salaryDate = $_SESSION['salaryDate'];
    $salaryDate = explode('/', $salaryDate);
    $salaryDate = $salaryDate[1] . '-' . $salaryDate[0] . '-01';
} else
    $salaryDate = '';
//echo $salaryDate;

$sql = "SELECT
    employees.employee_number empID,
    employee_payslips.id payslipID,
    employees.id EID,
    employees.first_name first_name,
    employees.middle_name middle_name,
    employees.last_name last_name,
     employee_payslips.is_approved approve,
      employee_payslips.is_rejected rejected,
       employee_payslips.reason reason,
    employee_payslips.total_earnings salary,
    employee_payslips.days_count leaveCount,
    (payslips_date_ranges.end_date - payslips_date_ranges.start_date) + 1    workingDays,
   ROUND(ROUND( employee_payslips.total_deductions,0),2) deductions,
    payslips_date_ranges.start_date startDate,
    payslips_date_ranges.end_date endDate,
    ROUND(ROUND((
        employee_payslip_categories.amount -(
            employee_payslips.total_deductions / 2
        )
    ),0),2) BasicSalary,
    ROUND(ROUND((
        (
            employee_payslips.total_earnings - employee_payslip_categories.amount
        ) -(
            employee_payslips.total_deductions / 2
        )
    ),0),2) variableSalary,
    payroll_categories.name payrollCategory
FROM
    employees
LEFT JOIN employee_payslips ON employees.id = employee_payslips.employee_id
LEFT JOIN payslips_date_ranges ON employee_payslips.payslips_date_range_id = payslips_date_ranges.id
INNER JOIN employee_payslip_categories ON employee_payslips.id = employee_payslip_categories.employee_payslip_id
INNER JOIN payroll_categories ON employee_payslip_categories.payroll_category_id = payroll_categories.id
WHERE
     payroll_categories.id = 1 ";

if ($salaryDate != '')
    $sql = $sql . "AND payslips_date_ranges.start_date = '$salaryDate' ";

$sql = $sql . "GROUP BY
    employee_payslips.id ORDER BY payslips_date_ranges.start_date DESC";

$result = $conn->query($sql);
//echo $sql;



if ($result->num_rows > 0) {




    while ($row = $result->fetch_assoc()) {
        $iban = $routing_no = $employee_account = '';
        $sqlID = "SELECT additional_info employee_account from employee_additional_details WHERE additional_field_id = 1 and employee_id = '$row[EID]' ";
        $resultID = $conn->query($sqlID);
        if ($resultID->num_rows > 0) {
            while ($rowID = $resultID->fetch_assoc()) {
                $employee_account = $rowID["employee_account"];
            }
        }


        $sqlID = "SELECT additional_info routing_no from employee_additional_details WHERE additional_field_id = 2 and employee_id = '$row[EID]' ";
        $resultID = $conn->query($sqlID);
        if ($resultID->num_rows > 0) {
            while ($rowID = $resultID->fetch_assoc()) {
                $routing_no = $rowID["routing_no"];
            }
        }


        $sqlID = "SELECT additional_info IBAN from employee_additional_details WHERE additional_field_id = 3 and employee_id = '$row[EID]' ";
        $resultID = $conn->query($sqlID);
        if ($resultID->num_rows > 0) {
            while ($rowID = $resultID->fetch_assoc()) {
                $iban = $rowID["IBAN"];
            }
        } {

            if ($thead == 1) {

                echo " <thead style=position:relate id=tablehead class=thead-dark ><tr>
                                            <th scope=col>ID</th>
                                            <th scope=col>Name</th>
                                            <th scope=col>Employee Unique Number</th>
                                            <th scope=col>Agent ID</th>
                                            <th scope=col>Employee Account</th>
                                            <th scope=col>Pay Start Date</th>
                                            <th scope=col>Pay End Date</th>
                                            <th scope=col>Days Paid</th>
                                            <th scope=col>Fixed Salary</th>  
                                            <th scope=col>Variable Salary</th>
                                            <th scope=col>Deduction</th>
                                            <th scope=col>Days on Leave</th>
                                            <th scope=col>Reason</th>
                                            <th scope=col>Status</th>
                                        </tr> 
                                    </thead>
                                    <tfoot style=position:relate id=tablehead class=thead-dark ><tr>
                                            <th scope=col>ID</th>
                                            <th scope=col>Name</th>
                                            <th scope=col>Employee Unique Number</th>
                                            <th scope=col>Agent ID</th>
                                            <th scope=col>Employee Account</th>
                                            <th scope=col>Pay Start Date</th>
                                            <th scope=col>Pay End Date</th>
                                            <th scope=col>Days Paid</th>
                                            <th scope=col>Fixed Salary</th>  
                                            <th scope=col>Variable Salary</th>
                                            <th scope=col>Deduction</th>
                                            <th scope=col>Days on Leave</th>
                                            <th scope=col>Reason</th>
                                            <th scope=col>Status</th>
                                        </tr> 
                                    </tfoot>
                                    <tbody>";

                $thead++;
            }
            echo "<tr><td>" . $row["empID"] . "</td>"
            . "<td>" . $row["first_name"] . " " . $row["middle_name"] . " " . $row["last_name"] . "</td>";

             if($employee_account != '')
            echo "<td>" . $employee_account . "</td>";
             else
                 echo "<td style=color:red> -NA- </td>";
             if($routing_no != '')
            echo "<td>" . $routing_no . "</td>";
             else
                 echo "<td style=color:red> -NA- </td>";
             if($iban !='')
            echo "<td>" . $iban . "</td>";
             else
                 echo "<td style=color:red> -NA- </td>";

            echo "<td>" . $row["startDate"] . "</td>"
            . "<td>" . $row["endDate"] . "</td>"
            . "<td>" . $row["workingDays"] . "</td>";

            if ($row["BasicSalary"] != NULL)
                echo "<td>" . $row["BasicSalary"] . "</td>";
            else
                echo "<td> 0.00 </td>";

            if ($row["variableSalary"] != NULL)
                echo "<td>" . $row["variableSalary"] . "</td>";
            else
                echo "<td> 0.00 </td>";

            echo "<td>" . $row["deductions"] . "</td>";

            if ($row["leaveCount"] != NULL)
                echo "<td>" . $row["leaveCount"] . "</td>";
            else
                echo "<td> 0 </td>";
            
               if ($row["reason"] != '')
                echo "<td>" . $row["reason"] . "</td>";
            else
                echo "<td style=color:red> -NA- </td>";
            
            if($row['rejected'] == 1)
                echo "<td>  <label  class='btn btn-danger mb-2' style=width:100%>Rejected</label> </td></tr>";
            else if ($row['approve'] == 1)
                echo "<td>  <label  class='btn btn-success mb-2' style=width:100%>Approved</label> </td></tr>";
            else
                echo "<td>  <label  class='btn btn-warning mb-2' style=width:100%>Pending</label> </td></tr>";
                
                

            echo "</tbody>";
            unset($_SESSION['salaryDate']);
            $salaryDate = '';
        }
    }
} else {

    $flag = 1;
}


if ($flag == 1) {
    echo "<div class=alert alert-success>"
    . "<strong style=color:red;>No Payslips Found!</strong> Please try to change the date or approve pending payslips.  "
    . "<a href=# class=clos data-dismiss=alert>&times;</a>"
    . "</div>";
}
$conn->close();

?>
