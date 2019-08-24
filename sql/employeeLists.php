<?php
include('../config/dbConfig.php');
session_start();
include('../bankinfo.php');


if (isset($_SESSION['employeeName']) && ($_SESSION['employeeName']) != '') {
    $employee = $_SESSION['employeeName'];
} else
    $employee = '';


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
                                    <tfoot class=thead-dark ><tr>
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
                                    </tfoot>
                                    <tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["employee_number"] . "</td>"
        . "<td>" . $row["name"] . "</td>";

        $sqlID = "SELECT additional_info employee_account from employee_additional_details WHERE additional_field_id = '$_SESSION[Emp_Uniq_ID]' and employee_id = '$row[EID]' ";
        $resultID = $conn->query($sqlID);
        if ($resultID->num_rows > 0) {
            while ($rowID = $resultID->fetch_assoc()) {


                echo "<td style='min-width:200px;max-width:500px;'>";
                ?>
                <form method="post" action="">
                    <div class="input-group" style="margin-right: 10px">
                        <input name="employee_account" id='employee_account' type="text" style="width:150px" class="form-control" placeholder="Employees' acc#" value='<?php echo $rowID['employee_account']; ?>'>
                        <div class="input-group-append">
                            <input type="text" display='none' hidden id='accountEID' name='accountEID' value='<?php echo $row['EID']; ?>'>
                            <button style="margin-right: 10px" class="btn btn-outline-success" id="eAccountbtn" name="eAccountbtn" type="submit">&#x2714;</button>

                        </div>

                    </div>  </form>

                <?php
                echo "</td>";
            }
        } else {
            echo "<td style='min-width:200px;max-width:500px;'>";
            ?>
            <form method="post" action="">
                <div class="input-group" >
                    <input type="text" name="employee_account" id='employee_account' style="width:150px" style="width:150px"class="form-control" placeholder="Enter account#" >
                    <div class="input-group-append">
                        <input type="text" display='none' hidden id='accountEID' name='accountEID' value='<?php echo $row['EID']; ?>'>
                        <button style="margin-right: 10px"  id="noAccountbtn" name="noAccountbtn" type="submit" class="btn btn-outline-danger" type="button">&#x2714;</button>
                    </div>
                </div>  
            </form>
            <?php
            echo" </td>";
        }

        $sqlID = "SELECT additional_info routing_no from employee_additional_details WHERE additional_field_id = '$_SESSION[Agent_ID]' and employee_id = '$row[EID]' ";
        $resultID = $conn->query($sqlID);
        if ($resultID->num_rows > 0) {
            while ($rowID = $resultID->fetch_assoc()) {
                echo "<td style='min-width:200px;max-width:500px;'>";
                ?>
                <form method="post" action="">
                    <div class="input-group" style="margin-right: 10px">
                        <input type="text" name="employee_routing" id='employee_routing' style="width:150px" class="form-control" placeholder="Employees' routing#" value='<?php echo $rowID['routing_no']; ?>'>

                        <div class="input-group-append">
                            <input type="text" display='none' hidden id='accountEID' name='accountEID' value='<?php echo $row['EID']; ?>'>
                            <button style="margin-right: 10px" id="routingbtn" name="routingbtn"  class="btn btn-outline-success" type="submit">&#x2714;</button>
                        </div>

                    </div>  
                </form>
                <?php
                echo "</td>";
            }
        } else {
            echo "<td style='min-width:200px;max-width:500px;'>";
            ?>
        <form method="post" action="" >
            <div class="input-group" >
                <input type="text" name="employee_routing" id='employee_routing' style="width:150px" style="width:150px"class="form-control" placeholder="Enter  routing#" >
                <div class="input-group-append">
                    <input type="text" display='none' hidden id='accountEID' name='accountEID' value='<?php echo $row['EID']; ?>'>
                    <button style="margin-right: 10px" id="noroutingbtn" name="noroutingbtn"  class="btn btn-outline-danger" type="submit">&#x2714;</button>
                </div>
            </div>  
        </form>
            <?php
            echo" </td>";
        }

        $sqlID = "SELECT additional_info IBAN from employee_additional_details WHERE additional_field_id = '$_SESSION[Emp_IBAN]' and employee_id = '$row[EID]' ";
        $resultID = $conn->query($sqlID);
        if ($resultID->num_rows > 0) {
            while ($rowID = $resultID->fetch_assoc()) {


                echo "<td style='min-width:200px;max-width:500px;'>";
                ?>
<form method="post" action="" >
                <div class="input-group" style="margin-right: 10px">
                    <input type="text" name="employee_iban" id='employee_iban' style="width:150px" class="form-control" placeholder="Employees' IBAN#" value='<?php echo $rowID['IBAN']; ?>'>
                    <div class="input-group-append">
                        <input type="text" display='none' hidden id='accountEID' name='accountEID' value='<?php echo $row['EID']; ?>'>
                        <button style="margin-right: 10px" id="ibanbtn" name="ibanbtn"  class="btn btn-outline-success" type="submit">&#x2714;</button>
                    </div>

                </div>  
</form>

                <?php
               echo "</td>";
             }
        } else {
            echo "<td style='min-width:200px;max-width:500px;'>";
            ?>
<form method="post" action="" >
            <div class="input-group" >
                <input type="text" name="employee_iban" id='employee_iban'  style="width:150px" style="width:150px"class="form-control" placeholder="Enter IBAN#" >
                <div class="input-group-append">
                    <input type="text" display='none' hidden id='accountEID' name='accountEID' value='<?php echo $row['EID']; ?>'>
                    <button style="margin-right: 10px" id="noibanbtn" name="noibanbtn" class="btn btn-outline-danger" type="submit">&#x2714;</button>
                </div>
            </div>  
</form>
            <?php
            echo "</td>";
        }


        echo "<td>" . $row["gender"] . "</td>";

        if ($row["job_title"] != '')
            echo "<td>" . $row["job_title"] . "</td>";
        else
            echo "<td style=color:red>-NA- </td>";


        echo "<td>" . date("d-M-y", strtotime($row["joining_date"])) . "</td>";

        if ($row["mobile_phone"] != '')
            echo "<td>" . $row["mobile_phone"] . "</td>";

        else if ($row["home_phone"] != '')
            echo "<td>" . $row["home_phone"] . "</td>";

        else if ($row["office_phone1"] != '')
            echo "<td>" . $row["office_phone1"] . "</td>";
        else
            echo "<td style=color:red>-NA- </td>";

        $sqlManager = "SELECT first_name, last_name, middle_name from employees WHERE id = '$row[manager_id]';";
//        echo $sqlManager;
        $resultManager = $conn->query($sqlManager);
        if ($resultManager->num_rows > 0) {
            while ($rowManager = $resultManager->fetch_assoc())
                echo "<td>" . $rowManager["first_name"] . " " . $rowManager["middle_name"] . " " . $rowManager["last_name"] . "</td>";
        } else
            echo "<td style=color:red>-NA- </td>";


        echo "<td>" . $row["department"] . " (" . $row["dept_code"] . ")</td></tr>";
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
?>

