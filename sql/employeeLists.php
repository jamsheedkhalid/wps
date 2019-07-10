<?php

include('../config/dbConfig.php');

session_start();

$employee = $_SESSION['employeeName'];

$sql = "SELECT  employees.id EID, employees.employee_number employee_number, CONCAT(employees.first_name,' ',employees.middle_name,' ',employees.last_name) name,"
        . "  employees.gender  gender,employees.first_name, employees.last_name, employees.middle_name,  "
        . " employees.job_title job_title, employees.joining_date joining_date, "
        . " employees.mobile_phone mobile_phone, employees.home_phone home_phone,"
        . " employees.office_phone1 office_phone1, employees.reporting_manager_id manager_id ,"
        . " employee_departments.name department, employee_departments.code dept_code"
        . " FROM employees"
        . " LEFT JOIN employee_departments ON employees.employee_department_id = employee_departments.id ";
    
if ($employee != '')
    $sql = $sql . "  WHERE employees.employee_number LIKE '$employee%' OR employees.first_name LIKE '%$employee%' OR employees.middle_name LIKE '%$employee%' OR employees.last_name LIKE '%$employee%' ";

$sql = $sql . " ORDER BY name ASC;";
$result = $conn->query($sql);
//echo $sql;




if ($result->num_rows > 0) {


    echo "  <thead class=thead-dark ><tr>
                                            <th scope=col>ID</th>
                                            <th scope=col>Name</th>
                                            <th scope=col>Employee Unique Number</th>
                                            <th scope=col>Agent ID</th>
                                            <th scope=col>Employee Account</th>
                                            <th scope=col>Gender</th>
                                            <th scope=col>Job Title</th>
                                            <th scope=col>Joining Date</th>
                                            <th scope=col>Contact Number</th>  
                                            <th scope=col>Manager</th>
                                            <th scope=col>Department</th>
                                        </tr>
                                    </thead>
                                    <tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["employee_number"] . "</td>"
        . "<td>" . $row["name"] .  "</td>";

        $sqlID = "SELECT additional_info employee_account from employee_additional_details WHERE additional_field_id = 1 and employee_id = '$row[EID]' ";
        $resultID = $conn->query($sqlID);
        if ($resultID->num_rows > 0) {
            while ($rowID = $resultID->fetch_assoc()) {
                echo "<td>" . $rowID["employee_account"] . "</td>";
            }
        }
        else echo "<td style=color:red>-NA- </td>";
        
        $sqlID = "SELECT additional_info routing_no from employee_additional_details WHERE additional_field_id = 2 and employee_id = '$row[EID]' ";
        $resultID = $conn->query($sqlID);
        if ($resultID->num_rows > 0) {
            while ($rowID = $resultID->fetch_assoc()) {
                echo "<td>" . $rowID["routing_no"] . "</td>";
            }
        }
        else echo "<td style=color:red>-NA- </td>";

        $sqlID = "SELECT additional_info IBAN from employee_additional_details WHERE additional_field_id = 3 and employee_id = '$row[EID]' ";
        $resultID = $conn->query($sqlID);
        if ($resultID->num_rows > 0) {
            while ($rowID = $resultID->fetch_assoc()) {
                echo "<td>" . $rowID["IBAN"] . "</td>";
            }
        }
        else echo "<td style=color:red>-NA- </td>";

        echo "<td>" . $row["gender"] . "</td>";
                
        if ($row["job_title"] != '')
        echo  "<td>" . $row["job_title"] . "</td>";
        
        else echo "<td style=color:red>-NA- </td>";
        
        echo "<td>" . $row["joining_date"] . "</td>";
        
        if ($row["mobile_phone"] != '')
        echo "<td>" . $row["mobile_phone"] . "</td>";
        
        else if ($row["home_phone"] != '')
        echo "<td>" . $row["home_phone"] . "</td>";
        
        else  if ($row["office_phone1"] != '')
           echo "<td>" . $row["office_phone1"] . "</td>";
        else echo "<td style=color:red>-NA- </td>";
        
        $sqlManager = "SELECT first_name, last_name, middle_name from employees WHERE id = '$row[manager_id]';";
//        echo $sqlManager;
        $resultManager = $conn->query($sqlManager);
        if ($resultManager->num_rows > 0) {
            while ($rowManager = $resultManager->fetch_assoc()) 
                    echo "<td>" . $rowManager["first_name"] ." ". $rowManager["middle_name"] ." ". $rowManager["last_name"] . "</td>";
        }
        else echo "<td style=color:red>-NA- </td>";
        
        
         echo "<td>" . $row["department"] . " (". $row["dept_code"].")</td></tr>";
 

    }
    echo "</tbody>";
} else {

    echo "<div class=alert alert-success>"
    . "<strong style=color:red;>No Employees Found!</strong> "
    . "<a href=# class=clos data-dismiss=alert>&times;</a>"
    . "</div>";
}
$_SESSION['employeeName'] = '';
$conn->close();



