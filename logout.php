<?php

include('config/dbConfig.php');

session_start();
$user_ip = getUserIP();
date_default_timezone_set('Asia/Dubai');
$login_time = date("H:i:s");
$login_date = date("D,d-M-Y");

    $sql = "INSERT INTO wps_user_timestamps (user_id,user_name,timestamp,datestamp,ip,action) VALUES ('$_SESSION[user]','$_SESSION[name]','$login_time','$login_date','$user_ip','Logout')";
if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "" . mysqli_error($conn);
}
$conn->close();
session_destroy();
header("Location: index.php"); //use for the redirection to some page  

function getUserIP() {
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote = $_SERVER['REMOTE_ADDR'];

    if (filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }

    return $ip;
}
?>  