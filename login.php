<?php

include('config/dbConfig.php');

session_start();
$login_time = date("H:i:s");
$login_date = date("D,d-M-Y");
$login = 0;
if ($_POST['token'] != '') {



    $sql = "select users.id user,users.first_name name from users where users.username = '$_POST[user]';";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $user = $row['user'];
        $name = $row['name'];
    }
//        echo $user;


    $sql = "select privilege_id, user_id, users.first_name name from privileges_users"
            . " INNER JOIN users ON users.id = privileges_users.user_id "
            . "where users.id = '$user' and privilege_id = 27;";
//        echo $sql;
    $result = $conn->query($sql);
    if ($result->num_rows <= 0) {

        $sql = "select * from admin_users where username = '$_POST[user]'";
        $result = $conn->query($sql);
        if ($result->num_rows <= 0) {
            $_SESSION['noaccess'] = 1;
            header('Location: index.php');
        }

//        
        else {
            $login = 1;
        }
    } else {
        $login = 1;
    }
} else {
// Jump to login page
    header('Location: index.php');
}

if ($login == 1) {
    $_SESSION['token'] = 1;
    header('Location: generateSIF.php');


    $sql = "INSERT INTO wps_user_timestamps (user_id,user_name,timestamp,datestamp,action) VALUES ('$_POST[user]','$name','$login_time','$login_date','Login')";
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "" . mysqli_error($conn);
    }
    $conn->close();
}

