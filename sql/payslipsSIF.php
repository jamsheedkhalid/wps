<?php

include('../config/dbConfig.php');
date_default_timezone_set('Asia/Dubai');

session_start();
include('../bankinfo.php');

if (isset($_SESSION['salaryDate']) && ($_SESSION['salaryDate']) != '') {
    $salaryDate = $_SESSION['salaryDate'];
    $salaryDate = explode('/', $salaryDate);
    $_SESSION['salaryDate'] = $salaryDate[0] . $salaryDate[1];
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
    ROUND(ROUND(employee_payslips.total_earnings,0),2) salary,
    employee_payslips.days_count leaveCount,
    (payslips_date_ranges.end_date - payslips_date_ranges.start_date) + 1    workingDays,
    ROUND(ROUND(employee_payslips.total_deductions,0),2) deductions,
    payslips_date_ranges.start_date startDate,
    payslips_date_ranges.end_date endDate,
    ROUND(ROUND(employee_payslip_categories.amount,0),2)  BasicSalary,
    ROUND(ROUND(employee_payslips.total_earnings - employee_payslip_categories.amount,0),2) variableSalary,
    ROUND(ROUND(employee_payslips.lop,0),2) lopAmount,
    payroll_categories.name payrollCategory
FROM
    employees
INNER JOIN employee_payslips ON employees.id = employee_payslips.employee_id
INNER JOIN payslips_date_ranges ON employee_payslips.payslips_date_range_id = payslips_date_ranges.id
INNER JOIN employee_payslip_categories ON employee_payslips.id = employee_payslip_categories.employee_payslip_id
INNER JOIN payroll_categories ON employee_payslip_categories.payroll_category_id = payroll_categories.id
WHERE
    employee_payslips.is_approved = 1 AND employee_payslips.is_rejected = 0 AND payroll_categories.id = 1 ";

if ($salaryDate != '')
    $sql = $sql . "AND payslips_date_ranges.start_date = '$salaryDate' ";

$sql = $sql . "GROUP BY
    employee_payslips.id ORDER BY payslips_date_ranges.start_date DESC";

$result = $conn->query($sql);
//echo $sql;




if ($result->num_rows > 0) {


    echo "  <thead class=thead-dark ><tr>
                                            <th scope=col>EDR</th>
                                            <th scope=col>Emp. ID</th>
                                            <th scope=col>Routing No.</th>
                                            <th scope=col>Employee Account</th>
                                            <th scope=col>Pay Start Date</th>
                                            <th scope=col>Pay End Date</th>
                                            <th scope=col>Days Paid</th>
                                            <th scope=col>Fixed Salary</th>  
                                            <th scope=col>Variable Salary</th>
                                            <th scope=col>Days on Leave</th>
                                        </tr>
                                    </thead>
                                    <tbody>";



    $edrCount = 0;
    $totalSalary = 0.00;
    while ($row = $result->fetch_assoc()) {
        $iban = $routing_no = $employee_account = '';



        $sqlID = "SELECT additional_info employee_account from employee_additional_details WHERE additional_field_id = '$_SESSION[Emp_Uniq_ID]' and employee_id = '$row[EID]' ";
        $resultID = $conn->query($sqlID);
        if ($resultID->num_rows > 0) {
            while ($rowID = $resultID->fetch_assoc()) {
                $employee_account = $rowID["employee_account"];
            }
        }
        $sqlID = "SELECT additional_info routing_no from employee_additional_details WHERE additional_field_id = '$_SESSION[Agent_ID]' and employee_id = '$row[EID]' ";
        $resultID = $conn->query($sqlID);
        if ($resultID->num_rows > 0) {
            while ($rowID = $resultID->fetch_assoc()) {
                $routing_no = $rowID["routing_no"];
            }
        }

        $sqlID = "SELECT additional_info IBAN from employee_additional_details WHERE additional_field_id = '$_SESSION[Emp_IBAN]' and employee_id = '$row[EID]' ";
        $resultID = $conn->query($sqlID);
        if ($resultID->num_rows > 0) {
            while ($rowID = $resultID->fetch_assoc()) {
                $iban = $rowID["IBAN"];
            }
        }

        if ($iban != '' && $routing_no != '' && $employee_account != '') {
            $edrCount++;
            echo "<tr><td>EDR</td>";


            echo "<td>" . $employee_account . "</td>";
            echo "<td>" . $routing_no . "</td>";
            echo "<td>" . $iban . "</td>";



            echo "<td>" . $row["startDate"] . "</td>"
            . "<td>" . $row["endDate"] . "</td>"
            . "<td>" . $row["workingDays"] . "</td>";
            
                  if ($row["BasicSalary"] != NULL) {
                if ($row["leaveCount"] != NULL) {
                    $deduct = round(($row["BasicSalary"] * $row["leaveCount"]) / 30);
                    $row["BasicSalary"] = $row["BasicSalary"] - $deduct;
                }

                if ($row["deductions"] != 0.00){
                    $deduction = round(($row["deductions"] - $row["lopAmount"]) / 2);

                $row["BasicSalary"] = $row["BasicSalary"] - $deduction;}


//                echo "<td>" . $row["BasicSalary"] . "</td>";
//                $grant_total += $row["BasicSalary"];
//                $basic_total += $row["BasicSalary"];
            }

//            else
//                echo "<td> 0.00 </td>";

            if ($row["variableSalary"] != NULL) {
                
                if ($row["leaveCount"] != NULL) {
                    
                    $deduct =  round(($row["variableSalary"] * $row["leaveCount"]) / 30);
                    $row["variableSalary"] = $row["variableSalary"] - $deduct;
                }
                if ($row["deductions"] != 0.00){
                    $deduction = round(($row["deductions"] - $row["lopAmount"]) / 2);

                $row["variableSalary"] = $row["variableSalary"] - $deduction;}

//                echo "<td>" . $row["variableSalary"] . "</td>";
//                 $grant_total += $row["variableSalary"];
//                $variable_total += $row["variableSalary"];
            }
//            else
//                echo "<td> 0.00 </td>";
            if ($row["BasicSalary"] < 0) {
                $row["variableSalary"] = $row["variableSalary"] + $row["BasicSalary"];
                $row["BasicSalary"]  = 0.00;
            } else if ($row["variableSalary"] < 0) {
                $row["BasicSalary"] = $row["BasicSalary"] + $row["variableSalary"];
                $row["variableSalary"]  = 0.00;
            }

            if ($row["BasicSalary"] != NULL) {
                $row["BasicSalary"] = sprintf("%.2f", $row["BasicSalary"]);
                echo "<td>" .$row["BasicSalary"]. "</td>";
                $totalSalary += $row["BasicSalary"];
    
            } else
                echo "<td> 0.00 </td>";
            
            if ($row["variableSalary"] != NULL) {
                $row["variableSalary"] = sprintf("%.2f", $row["variableSalary"]);
                echo "<td>" .$row["variableSalary"]. "</td>";
                $totalSalary += $row["variableSalary"];
                
            } else
                echo "<td> 0.00 </td>";


            
//
//            if ($row["BasicSalary"] != NULL) {
//                echo "<td>" . $row["BasicSalary"] . "</td>";
//                $totalSalary += $row["BasicSalary"];
//            } else
//                echo "<td> 0.00 </td>";
//
//            if ($row["variableSalary"] != NULL) {
//                echo "<td>" . $row["variableSalary"] . "</td>";
//                $totalSalary += $row["variableSalary"];
//            } else
//                echo "<td> 0.00 </td>";


            if ($row["leaveCount"] != NULL)
                echo "<td>" . $row["leaveCount"] . "</td>";
            else
                echo "<td> 0 </td></tr>";
        }
    }
    echo "<tr><td>SCR</td>"
    . "<td>" . $_SESSION["employerNo"] . "</td>"
    . "<td>" . $_SESSION["employerRouting"] . "</td>"
    . "<td>" . date("Y-m-d") . "</td>"
    . "<td>" . date('Hi') . "</td>"
    . "<td>" . $_SESSION['salaryDate'] . "</td>"
    . "<td>" . $edrCount . "</td>"
    . "<td>" . $totalSalary . "</td>"
    . "<td>AED</td>"
    . "<td>Salary</td>";

    echo "</tbody>";
} else {

    echo "<div class=alert alert-success>"
    . "<strong style=color:red;>No Payslips Found!</strong> Please try to change the date or approve pending payslips.  "
    . "<a href=# class=close data-dismiss=alert>&times;</a>"
    . "</div>";
}
$conn->close();
$_SESSION['salaryDate'] = '';


