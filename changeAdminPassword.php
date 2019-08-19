<?php
session_start();
include('header.php');
include('config/dbConfig.php');

$success = $fail = 0;

if (!isset($_SESSION['token']) || !isset($_SESSION['admin'])) {
    $_SESSION['login'] = 1;
    echo '<script> location.replace("index.php"); </script>';
}

if (!isset($_SESSION['token'])) {
    header("Location: index.php"); //redirect to login page to secure the welcome page without login access.  
    $_SESSION['login'] = 1;
}


if (isset($_POST['passChangeSubmit'])) {
    $newpassword = $_POST['newPass'];
    $userpassword = password_hash($newpassword, PASSWORD_BCRYPT);

    $sql = "UPDATE wps_admin_user SET user_password = '$userpassword' WHERE user_name = '$_SESSION[user]';";
//    echo $sql;
    if (mysqli_query($conn, $sql)) {
        $success = 1;
    } else {
        echo "<script>document.getElementById('failedalert').style.display = 'inline';</script>";
        $fail = 1;
    }
}
?>



<body>
    <div  class="animate">
        <?php
        include('navBar.php');
        ?>

        <div class="container">
            <div class="row">
                <div class="col"></div>
                <div class="col">

                    <form data-toggle="validator" method='post'>
                        <?php if ($success == 1) { ?>
                            <div id='successalert'  class="alert alert-success" role="alert">
                                Password Changed Successfully!<br>
                                Please use new password for your next login.
                            </div>  
                            <?php $success = 0;
                        } else if ($fail == 1) { ?>
                            <div id='failedalert' class="alert alert-danger" role="alert">
                                Password Change Failed!
                            </div> 
    <?php $fail = 0;
} ?>
                        <div class="form-group">
                            <label for="newPass">New Password</label>
                            <input type="password" data-minlength="6" required class="form-control" id="newPass" name="newPass" aria-describedby="emailHelp" placeholder="Enter New password">
                            <small id="emailHelp" class="form-text text-muted help-block">Minimum of 6 characters</small>
                        </div>
                        <div class="form-group">
                            <label for="conNewpass">Password</label>
                            <input type="password" data-match="#newPass" data-match-error="Whoops, these don't match" required class="form-control" id="conNewpass" placeholder="Confirm Password">
                            <div class="help-block with-errors"></div>
                        </div>

                        <button type="submit" name="passChangeSubmit" class="btn btn-primary">Change Password</button>
                    </form>
                </div>
                <div class="col"></div>
            </div>
        </div>




    </div>



    <!-------------------------------------java scripts------------------------------------>
    <script type="text/javascript">

        document.getElementById("navchangePassword").classList.add('active');

    </script>











    <!-------------------------------End of Java Scripts------------------------------------>        

</body>
</html>

