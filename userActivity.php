<?php
session_start();
include('header.php');


if (!isset($_SESSION['token'])) {
    $_SESSION['login'] = 1;
     header("Location: index.php");
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
                <form id="formPayslip" method="post" action="" autocomplete="off">   
                    <div class="container">
                        <div class="col-sm-3">

                            <div class="form-group">
                                <label for="employeeName"> User Name or ID</label>
                                <input list="display" class="form-control"   name="employeeName" id="employeeName" placeholder="Enter User Name/ID">
                                <datalist  id="display"></datalist >
                                <small  class="form-text text-muted">Enter user name or ID to view details</small>
                            </div>

                        </div>



                        <div class="col-sm-2" style="margin-top: 25px;" >
                            <button   type="submit" style="margin-left: 20px"  id="submitEmployee" class="btn btn-success mb-2">Load Activities</button>

                        </div>
                        <div class="col-sm-2" style="margin-top: 25px;" >
                            <button   type="reset" style="margin-left: 20px" name='resetEmployee' id="resetEmployee" class="btn btn-danger mb-2">Clear</button>

                        </div>

                    </div>

                </form>
            </div>



            <div class="row" style="padding: 20px">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-sm-12">
                                <h4 class="card-title" style="text-align: center; float: center;  font-weight: bold; color: maroon"><u>User Activities</u></h4> 
                            </div>


                            <div  class="col-sm-12" style="overflow-x:auto;overflow-y:auto;height: 80vh;padding-top: 20px">       
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
        document.getElementById("navUserActivity").style.background= 'black';
                document.getElementById("navUserActivity").style.color= 'whitesmoke';


        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState === 4)
                document.getElementById("employees").innerHTML = this.responseText;
        };
        xmlhttp.open("POST", "sql/listUserActivity.php", false);
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

