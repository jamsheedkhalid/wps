

<!--<script>
var x = document.getElementById("location");

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
  x.innerHTML = "Latitude: " + position.coords.latitude + 
  "<br>Longitude: " + position.coords.longitude;
}

window.onload = function() {
  getLocation();
  $('#locsubmit').click();
};
</script>-->

<?php
include('config/dbConfig.php');
session_start();
date_default_timezone_set('Asia/Dubai');


    

$user_ip = getUserIP();
$user_loc = '';
$login_time = date("H:i:s");
$login_date = date("d-M-Y");
$login = 0;

if ($_POST['token'] != '') {

    $_SESSION['user'] = $_POST['user'];

    $sql = "select users.id user,users.first_name name from users where users.username = '$_POST[user]';";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $user = $row['user'];
        $_SESSION['name'] = $row['name'];
    }

    $sql = "select * from users where username = '$_POST[user]' and admin = 2;";

    echo $sql;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $login = 1;
        $_SESSION['admin'] = 1;
    } else {
        $sql = "SELECT *  FROM wps_users "
                . "WHERE wps_users.username = '$_SESSION[user]' ;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $login = 1;
        } else {
            $_SESSION['noaccess'] = 1;
            header('Location: index.php');
        }
    }
} else if (isset($_POST['user']) && isset($_POST['pass'])) {

    $_SESSION['user'] = $_POST['user'];


    $sql = "SELECT user_name, name  FROM wps_admin_user "
            . "WHERE user_name = '$_POST[user]' AND user_password = '$_POST[pass]'  ;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $user = $row['user_name'];
            $_SESSION['name'] = $row['name'];
        }
        $login = 1;
        $_SESSION['admin'] = 1;
        $_SESSION['viewadmins'] = 1;
    } else {
        $sql = "SELECT user_name, user_password, name  FROM wps_admin_user "
                . "WHERE user_name = '$_POST[user]';";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if (password_verify($_POST[pass], $row['user_password'])) {
                    $user = $row['user_name'];
                    $_SESSION['name'] = $row['name'];

                    $login = 1;
                    $_SESSION['admin'] = 1;
                }
            }
        }
    }
} else {
// Jump to login page
//    echo "<script>document.getElementById('invalidCredentials').style.display = 'inline'</script>;";
    $_SESSION['invalidpass'] = 1;
    header('Location: index.php');
}

if ($login == 1) {

    $_SESSION['token'] = 1;

    $sql = "INSERT INTO wps_user_timestamps (user_id,user_name,timestamp,datestamp,location, ip,action) VALUES ('$_POST[user]','$_SESSION[name]','$login_time','$login_date','$user_loc','$user_ip','Login')";
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "" . mysqli_error($conn);
    }
    $conn->close();
    header('Location: generateSIF.php');
    $login = 0;
    unset($_SESSION['noaccess']);
} else {
// Jump to login page
    echo "<script>document.getElementById('invalidCredentials').style.display = 'inline'</script>;";
    header('Location: index.php');
}

function getUserIP() {
    //whether ip is from share internet
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
    }
//whether ip is from proxy
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
//whether ip is from remote address
    else {
        $ip_address = $_SERVER['REMOTE_ADDR'];
    }

    return $ip_address;
}
