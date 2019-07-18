<?php
session_start();
include('header.php');
include('config/dbConfig.php');

if (isset($_POST['grantAccess']) && isset($_POST['user'])) {
    $sql = "SELECT id, username, CONCAT (first_name,' ',last_name) name FROM users WHERE username = '$_POST[user]' ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sql = "SELECT * FROM wps_users WHERE username = '$_POST[user]'";
            $resultsql = $conn->query($sql);
            if ($resultsql->num_rows <= 0) {
                $sql = "INSERT INTO wps_users VALUES ('','$row[id]','$row[username]','$row[name]')";
                if (mysqli_query($conn, $sql)) {
//                    echo "New record created successfully";
                } else {
//                    echo "Error: " . $sql . "" . mysqli_error($conn);
                }
            }
        }
    }
}

if (isset($_POST['denyAccess'])) {
    $sql = "DELETE FROM wps_users WHERE username = '$_POST[denyuser]' ";
    mysqli_query($conn, $sql);
}



if (!isset($_SESSION['token'])) {
    header("Location: index.php"); //redirect to login page to secure the welcome page without login access.  
    $_SESSION['login'] = 1;
}

if (isset($_POST['employeeName']) && $_POST['employeeName'] != '') {
    $_SESSION['employeeName'] = $_POST['employeeName'];
}
?>



<body>
    <div  class="animate">
        <?php
        include('navBar.php');
        ?>

        <div class="container-fluid" >
            <div class="row" style="padding: 20px">  
                <div class="container">
                    <form id="formPayslip" method="post" action="" autocomplete="off">   

                        <div class="col-sm-3">

                            <div class="form-group">
                                <label for="employeeName"> User Name or ID</label>
                                <input list="display" class="form-control"   name="employeeName" id="employeeName" placeholder="Enter User Name/ID">
                                <datalist  id="display"></datalist >
                                <small  class="form-text text-muted">Enter user name or ID to view details</small>
                            </div>

                        </div>



                        <div class="col-sm-1" style="margin-top: 25px;" >
                            <button   type="submit" style="margin-left: 20px"  id="submitEmployee" class="btn btn-success mb-2">Search Users</button>

                        </div>
                        <div class="col-sm-1" style="margin-top: 25px;" >
                            <button   type="reset" style="margin-left: 20px" name='resetEmployee' id="resetEmployee" class="btn btn-danger mb-3">Clear</button>

                        </div>


                    </form>
                    <div class="col-sm-2" style="margin-top: 25px;" >
                        <form action="" method="POST"  autocomplete="off">
                            <input  type=text style="display: none" value="true" name="aUser" id ="aUser">
                            <button   type="submit" style="margin-left: 20px" name='accessUsers' id="accessUsers" class="btn btn-primary mb-2">View WPS Users</button>
                        </form>
                    </div>
                </div>



            </div>



            <div class="row" style="padding: 20px">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-sm-12">
                                <h4 class="card-title" style="text-align: center; float: center;  font-weight: bold; color: maroon"><u>User Management</u></h4> 
                            </div>


                            <div  class="col-sm-12"style="overflow-x:auto;overflow-y:auto;height: 80vh;padding-top: 20px">       
                                <table class="table table-striped   table-hover table-sm" id='employees'></table>

                            </div>

                        </div>
                    </div>



                </div>

            </div>

        </div>
    </div>


    <!-------------------------------------java scripts------------------------------------>
    <script type="text/javascript">

        document.getElementById("navAccess").classList.add('active');
        document.getElementById("navUserActivity").style.background = 'black';
        document.getElementById("navUserActivity").style.color = 'whitesmoke';


        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState === 4)
                document.getElementById("employees").innerHTML = this.responseText;
        };
        xmlhttp.open("POST", "sql/wps_users.php", false);
        xmlhttp.send();
    </script>



    <script>
        var input = document.getElementById("employeeName");
        input.addEventListener("keyup", function (event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                document.getElementById("submitEmployee").click();
            }
        });



    </script>

    <script type="text/javascript" src="js/autoFillUsers.js"></script>







    <!-------------------------------End of Java Scripts------------------------------------>        

</body>
</html>

