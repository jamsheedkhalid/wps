<?php

include('config/dbConfig.php');

session_start();
if ($_POST['token'] != '') {


    $sql = "select users.id user from users where users.username = '$_POST[user]';";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc())
        $user = $row['user'];
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
        $_SESSION['token'] = 1;
        header('Location: generateSIF.php');
//        unset($_SESSION['noaccess']);
    }
//  
} 

    else {
        $_SESSION['token'] = 1;
        header('Location: generateSIF.php');
//        unset($_SESSION['noaccess']);
    }

}else {
// Jump to login page
    header('Location: index.php');
}


