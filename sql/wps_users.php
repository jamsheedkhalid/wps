<?php

include('../config/dbConfig.php');
session_start();

if (isset($_SESSION['employeeName']) && ($_SESSION['employeeName']) != '') {
    $username = $_SESSION['employeeName'];
} else
    $username = '';


$sql = " SELECT   userid, username, name from wps_users ORDER BY id DESC";


if ($username != '')
    $sql = " SELECT   userid, username, name from wps_users WHERE userid LIKE '%$username%' "
            . "OR username LIKE '%$username%' OR name LIKE '%$username%'  ORDER BY id DESC";


$result = $conn->query($sql);

if ($result->num_rows > 0) {


    echo "  <thead class=thead-dark ><tr>
                                            <th scope=col>User ID</th>
                                            <th scope=col>User Name</th>
                                            <th scope=col>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["user_d"] . "</td>"
        . "<td>" . $row["username"] . "</td>"
        . "<td>" . $row["name"] . "</td>";
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



