<?php

include('config/dbConfig.php');

session_start();
date_default_timezone_set('Asia/Dubai');
$login_time = date("H:i:s");
$login_date = date("D,d-M-Y");

$sql = "INSERT INTO wps_user_timestamps (user_id,user_name,timestamp,datestamp,action) VALUES ('$_SESSION[user]','$_SESSION[name]','$login_time','$login_date','Logout')";
if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "" . mysqli_error($conn);
}
$conn->close();
session_destroy();
header("Location: index.php"); //use for the redirection to some page  
?>  