<?php include('../config/dbConfig.php'); 

$sql = "SELECT
    employee_payslips.id payslipID,
    employees.id EID,
    employees.first_name name,
    additional_fields.name additional,
    employee_additional_details.additional_info info,
    employee_payslips.total_earnings salary,
    employee_payslips.days_count leaveCount,
    employee_payslips.working_days workingDays,
    employee_payslips.total_deductions deductions,
    payslips_date_ranges.start_date startDate,
    payslips_date_ranges.end_date endDate,
    (
        employee_payslip_categories.amount -(
            employee_payslips.total_deductions / 2
        )
    ) BasicSalary,
    (
        (
            employee_payslips.total_earnings - employee_payslip_categories.amount
        ) -(
            employee_payslips.total_deductions / 2
        )
    ) variableSalary,
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
    employee_payslips.is_approved = 1 AND employee_payslips.is_rejected = 0 AND payroll_categories.id = 1
GROUP BY
    employee_payslips.id";

$result = $conn->query($sql);





if ($result->num_rows > 0) {
    
  
                                 echo       "  <thead><tr>
                                            <th scope=col>Name</th>
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
                                      
                                   
    
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["name"]."</td>";
            
        $sqlID = "SELECT additional_info employee_account from employee_additional_details WHERE additional_field_id = 1 and employee_id = '$row[EID]' ";
        $resultID = $conn->query($sqlID);
        if ($resultID->num_rows > 0) {
            while ($rowID = $resultID->fetch_assoc()) {
                echo "<td>".$rowID["employee_account"]."</td>";
            }
        }
       $sqlID = "SELECT additional_info routing_no from employee_additional_details WHERE additional_field_id = 2 and employee_id = '$row[EID]' ";
        $resultID = $conn->query($sqlID);
        if ($resultID->num_rows > 0) {
            while ($rowID = $resultID->fetch_assoc()) {
                echo "<td>".$rowID["routing_no"]."</td>";
            }
        }
        
        $sqlID = "SELECT additional_info IBAN from employee_additional_details WHERE additional_field_id = 3 and employee_id = '$row[EID]' ";
        $resultID = $conn->query($sqlID);
        if ($resultID->num_rows > 0) {
            while ($rowID = $resultID->fetch_assoc()) {
                echo "<td>".$rowID["IBAN"]."</td>";
            }
        }
        echo "<td>".$row["startDate"]."</td>"
            ."<td>".$row["endDate"]."</td>"
            ."<td>".$row["workingDays"]."</td>"    
            ."<td>".$row["BasicSalary"]."</td>"    
            ."<td>".$row["variableSalary"]."</td>"    
            ."<td>".$row["leaveCount"]."</td></tr>";
    }
    echo  "</tbody>";
}
 else
    echo "Data Not Found, try to import it to DB";

$conn->close();

?>
