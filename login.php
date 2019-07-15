<?php

include('config/dbConfig.php');

session_start();
date_default_timezone_set('Asia/Dubai');

$login_time = date("H:i:s");
$login_date = date("D,d-M-Y");
$login = 0;
if ($_POST['token'] != '') {

    $user_ip = getUserIP();

    $_SESSION['user'] = $_POST['user'];
    $sql = "select users.id user,users.first_name name from users where users.username = '$_POST[user]';";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $user = $row['user'];
        $_SESSION['name'] = $row['name'];
    }


    $sql = "select privilege_id, user_id, users.first_name name from privileges_users"
            . " INNER JOIN users ON users.id = privileges_users.user_id "
            . "where users.id = '$user' and privilege_id = 27;";

    $result = $conn->query($sql);
    if ($result->num_rows > 0)
        $login = 1;

    else {
        $sql = "select * from admin_users where username = '$_POST[user]'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0)
            $login = 1;

        else {
            $_SESSION['noaccess'] = 1;
            header('Location: index.php');
        }
    }
} else {
// Jump to login page
    header('Location: index.php');
}

if ($login == 1) {
    $_SESSION['token'] = 1;



    $sql = "INSERT INTO wps_user_timestamps (user_id,user_name,timestamp,datestamp,ip,action) VALUES ('$_POST[user]','$_SESSION[name]','$login_time','$login_date','$user_ip','Login')";
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "" . mysqli_error($conn);
    }
    $conn->close();
    header('Location: generateSIF.php');
    $login = 0;
    unset($_SESSION['noaccess']);
}

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
