<?php

include('../config/dbConfig.php');
session_start();

if (isset($_SESSION['employeeName']) && ($_SESSION['employeeName']) != '') {
    $username = $_SESSION['employeeName'];
} else
    $username = '';


$sql = " SELECT DISTINCT  user_id, user_name, timestamp, datestamp, action from wps_user_timestamps ORDER BY id DESC";


if ($username != '')
$sql = " SELECT DISTINCT  user_id, user_name, timestamp, datestamp, action from wps_user_timestamps WHERE user_id LIKE '%$username%' "
        . "OR user_name LIKE '%$username%' ORDER BY id DESC";


$result = $conn->query($sql);

if ($result->num_rows > 0) {


    echo "  <thead class=thead-dark ><tr>
                                            <th scope=col>User ID</th>
                                            <th scope=col>User Name</th>
                                            <th scope=col>Time</th>
                                            <th scope=col>Date</th>
                                            <th scope=col>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["user_id"] . "</td>"
        . "<td>" . $row["user_name"] . "</td>"
        . "<td>" . $row["timestamp"] . "</td>"
        . "<td>" . $row["datestamp"] . "</td>";
                if ($row["action"] == 'Login')
        echo  "<td style='background:darkgreen;color:white' >" . $row["action"] . "</td>";
                else
        echo "<td style='background:darkred; color:white' >" . $row["action"] . "</td>";

                    
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



