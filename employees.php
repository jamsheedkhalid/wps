<?php
include('header.php');


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
                <form id="formPayslip" method="post" action="" autocomplete="off">   
                    <div class="container">
                        <div class="col-sm-3">

                            <div class="form-group">
                                <label for="employeeName"> Employee Name or ID</label>
                                <input list="display" class="form-control"   name="employeeName" id="employeeName" placeholder="Enter Name/ID">
                                <datalist  id="display"></datalist >
                                <small  class="form-text text-muted">Enter employee name or ID to view details</small>
                            </div>

                        </div>



                        <div class="col-sm-2" style="margin-top: 25px;" >
                            <button   type="submit" style="margin-left: 20px"  id="submitEmployee" class="btn btn-success mb-2">Load Employee Details</button>

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
                                <h4 class="card-title" style="text-align: center; float: center;  font-weight: bold; color: maroon"><u>Employee Details</u></h4> 
                            </div>


                            <div  class="col-sm-12"style="overflow-x:auto; padding-top: 20px">       
                                <table class="table table-striped  table-bordered  table-hover table-sm" id='employees'></table>

                            </div>

                        </div>
                    </div>

<!--                    <input id="viewSIF" value="Generate SIF" class="btn btn-primary mb-2" type="button" >
                    <input id="downloadSIF" value="Download SIF" class="btn btn-primary mb-2" type="button" style="visibility: hidden" onclick="$('#payslipsSIF').tableToCsv({outputheaders: false, fileName: '<?php echo $_SESSION['employerNo'] . date('ymdHis'); ?>'});">
                    <table class="table" style="visibility: hidden" id='payslipsSIF'></table>-->

                </div>

            </div>

        </div>
    </div>


    <!-------------------------------------java scripts------------------------------------>
    <script type="text/javascript">

        document.getElementById("navEmployees").classList.add('active');
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState === 4)
                document.getElementById("employees").innerHTML = this.responseText;
        };
        xmlhttp.open("POST", "sql/employeeLists.php", false);
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

    <script type="text/javascript" src="js/autoFill.js"></script>


<!--        <script >

var frmvalidator = new Validator("formPayslip");
frmvalidator.addValidation("employerBankNo","maxlen=13","Maximum length for Employer Unique Number  is 13");
frmvalidator.addValidation("employerBankNo","num","Only digits are allowed in Employer Unique Number");


frmvalidator.addValidation("employerRouting","maxlen=9","Maximum length for Bank Routing Code  is 9");
frmvalidator.addValidation("employerRouting","num","Only digits are allowed in Bank Routing Code");

frmvalidator.addValidation("salaryDate","regexp=((0-1)?([0-9]){1}\/([0-9]){4})","Invalid Date Format! Use MM/YYYY ");


</script>-->




    <!-------------------------------End of Java Scripts------------------------------------>        

</body>
</html>

