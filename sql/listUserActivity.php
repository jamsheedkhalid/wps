<?php

include('../config/dbConfig.php');
session_start();


$sql = " SELECT * from wps_user_timestamps ";

$result = $conn->query($sql);
//echo $sql;

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
        . "<td>" . $row["datestamp"] . "</td>"
        . "<td>" . $row["action"] . "</td>";
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



