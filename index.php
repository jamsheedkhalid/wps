<?php
include('header.php');
?>

<body>
    <div  class="animate">
        <?php
        include('navBar.php');
        ?>

        <div class="container-fluid" >
            <div class="row" style="padding: 20px">  
                <form method="post" action="" >   
                    <div class="container">
                        <div class="col-sm-3">

                            <div class="form-group">
                                <label>Employer Unique No.</label>
                                <input  class="form-control"  name="employerBankNo" id="employerBankNo" placeholder="Enter unique number">
                                <small  class="form-text text-muted">Enter your 13 digit school unique number.</small>
                            </div>
                        </div>

                        <div class="col-sm-3">

                            <div class="form-group">
                                <label>Employer Bank Routing Code.</label>
                                <input  class="form-control" name="employerRouting" id="employerRouting" placeholder="Enter routing code">
                                <small  class="form-text text-muted">Enter your 9 digit school bank routing code.</small>
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

                        <div class="col-sm-3" style="margin-top: 25px" >
                            <button  type="submit" style="margin-left: 20px" name='submitSalary'id="submitSalary" class="btn btn-success mb-2">Load Payslips</button>

                        </div>

                    </div>
                </form>
            </div>



            <div class="row" style="padding: 20px">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-sm-12">
                                <h4 class="card-title" style="text-align: center; float: center;  font-weight: bold; color: maroon">
                                    <?php
                                    if (isset($_POST['submitSalary']) && $_POST['salaryDate'] != '') {
                                        echo "Salary Payment For the Month: " . $_POST['salaryDate'];
                                        $_SESSION['salaryDate'] = $_POST['salaryDate'];
                                    } else
                                        echo "<u>Approved Payslips</u>";
                                    ?> 
                                </h4> 
                            </div>
                            <div style="padding: 20px">
                                <h4 class="card-title" style="text-align: right; float: right;  font-weight: bold; color: maroon">
                                    <?php
                                    if (isset($_POST['submitSalary']) && $_POST['employerBankNo'] != '') {
                                        echo "Employer No.: " . $_POST['employerBankNo'];
                                        $_SESSION["employerNo"] = $_POST['employerBankNo'];
                                    }
                                    ?> 

                                </h4> 

                                <h4 class="card-title" style="text-align: left; float: left; font-weight: bold; color: maroon">
                                    <?php
                                    if (isset($_POST['submitSalary']) && $_POST['employerRouting'] != '') {
                                        echo "Routing Code: " . $_POST['employerRouting'];
                                        $_SESSION["employerRouting"] = $_POST['employerRouting'];
                                    }
                                    ?> 

                                </h4> 
                            </div>


                            <div  class="col-sm-12"style="overflow-x:auto; padding-top: 20px">       
                                <table class="table table-striped  table-hover table-sm" id='payslips'></table>

                            </div>

                        </div>
                    </div>

                    <input value="View SIF" class="btn btn-primary mb-2" type="button" onclick="$('#payslipsSIF').table2CSV({header: ['']});">
                    <input value="Download SIF" class="btn btn-primary mb-2" type="button" onclick=" $('#payslipsSIF').tableToCsv({outputheaders: false, fileName: '<?php echo $_SESSION['employerNo'] . date('ymdHis'); ?>'});">
                    <table class="table" style="visibility: hidden" id='payslipsSIF'></table>

                </div>

            </div>

        </div>
    </div>


    <!-------------------------------------java scripts------------------------------------>
    <script type="text/javascript">
        
        document.getElementById("navSifCreator").classList.add('active');

        var salaryDate = document.getElementById("salaryDate").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState === 4)
                document.getElementById("payslips").innerHTML = this.responseText;
        };
        xmlhttp.open("POST", "sql/payslips.php", false);
        xmlhttp.send();

        var sifhtttp = new XMLHttpRequest();
        sifhtttp.onreadystatechange = function () {
            if (this.readyState === 4)
                document.getElementById("payslipsSIF").innerHTML = this.responseText;
        };
        sifhtttp.open("POST", "sql/payslipsSIF.php", false);
        sifhtttp.send();
        
        document.getElementById("employerBankNo").value = '<?php if(isset($_SESSION["employerNo"])) echo $_SESSION["employerNo"]; ?>';
        document.getElementById("employerRouting").value = '<?php if(isset($_SESSION["employerRouting"])) echo $_SESSION["employerRouting"]; ?>';
        document.getElementById("salaryDate").value = '<?php if(isset($_SESSION["salaryDate"])) echo $_SESSION["salaryDate"]; ?>';


    </script>

    <script type="text/javascript">

//            $(document).ready(function () {
//                $("#submitSalary").click(function () {
//                    
//
//                    // disable button
//                    $(this).prop("disabled", true);
//                    // add spinner to button
//                    $(this).html(
//                            `Fetching...  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`
//                            );
//
//
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
