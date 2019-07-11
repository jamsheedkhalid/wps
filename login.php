<?php

session_start();
if ($_POST['token'] != '') {
    $_SESSION['token'] = 1;
    header('Location: generateSIF.php');
} else {
// Jump to login page
    header('Location: index.php');
}


