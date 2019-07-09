<?php

include('../config/dbConfig.php');

session_start();

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
    additional_fields.name additional,
    employee_additional_details.additional_info info,
    employee_payslips.total_earnings salary,
    employee_payslips.days_count leaveCount,
    (payslips_date_ranges.end_date - payslips_date_ranges.start_date) + 1    workingDays,
    employee_payslips.total_deductions deductions,
    payslips_date_ranges.start_date startDate,
    payslips_date_ranges.end_date endDate,
    ROUND((
        employee_payslip_categories.amount -(
            employee_payslips.total_deductions / 2
        )
    ),2) BasicSalary,
    ROUND((
        (
            employee_payslips.total_earnings - employee_payslip_categories.amount
        ) -(
            employee_payslips.total_deductions / 2
        )
    ),2) variableSalary,
    payroll_categories.name payrollCategory
FROM
    employees
INNER JOIN employee_additional_details ON employees.id = employee_additional_details.employee_id
INNER  JOIN additional_fields ON employee_additional_details.additional_field_id = additional_fields.id
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
                                        </tr>
                                    </thead>
                                    <tbody>";




    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["empID"] . "</td>"
        . "<td>" . $row["first_name"] . " " . $row["middle_name"] . " " . $row["last_name"] . "</td>";

        $sqlID = "SELECT additional_info employee_account from employee_additional_details WHERE additional_field_id = 1 and employee_id = '$row[EID]' ";
        $resultID = $conn->query($sqlID);
        if ($resultID->num_rows > 0) {
            while ($rowID = $resultID->fetch_assoc()) {
                echo "<td>" . $rowID["employee_account"] . "</td>";
            }
        }
        $sqlID = "SELECT additional_info routing_no from employee_additional_details WHERE additional_field_id = 2 and employee_id = '$row[EID]' ";
        $resultID = $conn->query($sqlID);
        if ($resultID->num_rows > 0) {
            while ($rowID = $resultID->fetch_assoc()) {
                echo "<td>" . $rowID["routing_no"] . "</td>";
            }
        }

        $sqlID = "SELECT additional_info IBAN from employee_additional_details WHERE additional_field_id = 3 and employee_id = '$row[EID]' ";
        $resultID = $conn->query($sqlID);
        if ($resultID->num_rows > 0) {
            while ($rowID = $resultID->fetch_assoc()) {
                echo "<td>" . $rowID["IBAN"] . "</td>";
            }
        }

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
            echo "<td> 0 </td></tr>";
    }
    echo "</tbody>";
} else {

    echo "<div class=alert alert-success>"
    . "<strong style=color:red;>No Payslips Found!</strong> Please try to change the date or approve pending payslips.  "
    . "<a href=# class=clos data-dismiss=alert>&times;</a>"
    . "</div>";
}
$conn->close();



