<?php

include('../config/dbConfig.php');
session_start();

if (isset($_SESSION['employeeName']) && ($_SESSION['employeeName']) != '') {
    $username = $_SESSION['employeeName'];
} else
    $username = '';


$sql = " SELECT DISTINCT  user_id, user_name, timestamp, datestamp,ip, action from wps_user_timestamps ORDER BY datestamp,timestamp DESC";


if ($username != '')
    $sql = " SELECT DISTINCT  user_id, user_name, timestamp, datestamp, ip, action from wps_user_timestamps WHERE user_id LIKE '%$username%' "
            . "OR user_name LIKE '%$username%' ORDER BY datestamp,timestamp DESC";

//echo $sql;
$result = $conn->query($sql);

if ($result->num_rows > 0) {


    echo "  <thead class=thead-dark ><tr>
                                            <th scope=col>User ID</th>
                                            <th scope=col>User Name</th>
                                            <th scope=col>Time</th>
                                            <th scope=col>Date</th>
                                             <th scope=col>IP</th>
                                            <th scope=col>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["user_id"] . "</td>"
        . "<td>" . $row["user_name"] . "</td>"
        . "<td>" . $row["timestamp"] . "</td>"
        . "<td>" . $row["datestamp"] . "</td>"
        . "<td>" . $row["ip"] . "</td>";
        if ($row["action"] == 'Login')
         echo "<td>  <label  class='btn btn-success mb-2' style=width:100%>Logged in</label> </td></tr>";
        else
         echo "<td>  <label  class='btn btn-danger mb-2' style=width:100%>Logged out</label> </td></tr>";
    }
    echo "</tbody>";
} else {

    echo "<div class=alert alert-success>"
    . "<strong style=color:red;>No Users Found!</strong> "
    . "<a href=# class=clos data-dismiss=alert>&times;</a>"
    . "</div>";
}

$_SESSION['employeeName'] = '';
$conn->close();



