
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>WPS-InDepth</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="js/menuTrigger.js"></script>
        <script src="js/jquery.min.js"></script>
        <script src="js/moment.min.js"></script>
        <script src="js/bootstrap-datetimepicker.min.js"></script>
        <script src="plugins/bootstrap/js/bootstrap.js"></script>
        <script src="plugins/bootstrap/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="css/style.css">
        <link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">

    </head>

    <body>
        <div  class="animate">
            <nav class="navbar header-top fixed-top navbar-expand-lg  navbar-dark bg-dark">
                <span class="navbar-toggler-icon leftmenutrigger"></span>
                <a class="navbar-brand" href="#">WPS - INDEPTH</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav animate side-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#">SIF Creator
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Employee List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Pay Slips</a>
                        </li>
                    </ul>
                    <ul style="float: right" class="navbar-nav ml-md-auto d-md-flex">
                        <li class="nav-item">
                            <a class="nav-link" href="#">SIF Creator
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Employee List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Pay Slips</a>
                        </li>
                    </ul>
                </div>
            </nav>


            <div class="container-fluid" >
                <div class="row" style="padding: 20px">  
                    <form method="post" action="" >   
                        <div class="container">
                            <div class="col-sm-3">

                                <div class="form-group">
                                    <label>IBAN No.</label>
                                    <input  class="form-control" name="employerBankNo" id="employerBankNo" placeholder="Enter IBAN number">
                                    <small  class="form-text text-muted">Enter your 13 digit school IBAN number.</small>
                                </div>
                            </div>

                            <div class="col-sm-3" >


                                <div class="form-group">
                                    <label>Month & Year</label>
                                    <div class='input-group date' id="divSalaryDate" >
                                        <input type='text' name='salaryDate'  id='salaryDate' placeholder="Select month & year" class="form-control" />

                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar">
                                            </span>
                                        </span>

                                    </div>
                                    <small class="form-text text-muted">Select month & year of salary payment.</small>
                                </div>
                            </div>

                            <div class="col-sm-6" style="margin-top: 25px" >
                                <button  type="submit" style="margin-left: 20px" name='submitSalary'id="submitSalary" class="btn btn-success mb-2">Load Payslips</button>

                            </div>

                        </div>
                    </form>
                </div>



                <div class="row" style="padding: 20px">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="col-sm-6">
                                    <h4 class="card-title" style="text-align: left;  font-weight: bold; color: maroon">
                                        <?php
                                        if (isset($_POST['submitSalary'])) {
                                            echo "Salary Payment For the Month: " . $_POST['salaryDate'];
                                            $_SESSION['salaryDate'] = $_POST['salaryDate'];
                                        } else
                                            echo "Approved Payslips";
                                        ?> 
                                        <br> </h4> <br>
                                </div>
                                <h4 class="card-title" style="text-align: right;  font-weight: bold; color: maroon">
                                    <?php
                                    if (isset($_POST['submitSalary']) && $_POST['employerBankNo'] != '') {
                                        echo "Employer IBAN: " . $_POST['employerBankNo'];
                                    }
                                    ?>  <br> </h4> <br>
                                 <div style="overflow-x:auto;">       
                                <table class="table table-bordered table-hover table-sm" id='payslips'>

                                </table>
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-------------------------------------java scripts------------------------------------>
        <script type="text/javascript">

            var salaryDate = document.getElementById("salaryDate").value;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState === 4)
                    document.getElementById("payslips").innerHTML = this.responseText;
            };
            xmlhttp.open("POST", "sql/payslips.php", false);
            xmlhttp.send();

        </script>

        <script type="text/javascript">

//            $(document).ready(function () {
//                $("#submit").click(function () {
//
//                    // disable button
//                    $(this).prop("disabled", true);
//                    // add spinner to button
//                    $(this).html(
//                            `Fetching...  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`
//                            );
//                });
//            });


            $(function () {
                $('#divSalaryDate').datetimepicker({
                    viewMode: 'years',
                    format: 'MM/YYYY'
                });
            });
        </script>

        <script>
            var input = document.getElementById("salaryDate");
            input.addEventListener("keyup", function (event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                    document.getElementById("submitSalary").click();
                }
            });
        </script>
        <!-------------------------------End of Java Scripts------------------------------------>        

    </body>
</html>
