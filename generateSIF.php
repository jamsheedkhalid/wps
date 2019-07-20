

<?php
session_start();
include('header.php');
if (!isset($_SESSION['token'])) {
    $_SESSION['login'] = 1;
echo '<script> location.replace("index.php"); </script>';

}
?>
<body>
    <div  class="animate">
        <?php
        include('navBar.php');
        ?>

        <div class="container-fluid" >
            <div class="row" style="padding: 20px">  
                <form id="formPayslip" method="post" action="" >   
                    <div class="container">
                        <div class="col-sm-3">

                            <div class="form-group">
                                <label for="employerBankNo"> Employer Unique No.</label>
                                <input  class="form-control"  name="employerBankNo" id="employerBankNo" placeholder="Enter unique number">
                                <small  class="form-text text-muted">Enter your 13 digit school unique number.</small>
                            </div>
                        </div>

                        <div class="col-sm-3">

                            <div class="form-group">
                                <label for="employerRouting">Employer Bank Routing Code.</label>
                                <input  size="13" class="form-control" name="employerRouting" id="employerRouting" placeholder="Enter routing code">
                                <small  class="form-text text-muted">Enter your 9 digit school bank routing code.</small>
                            </div>
                        </div>

                        <div class="col-sm-3" >


                            <div class="form-group"  >
                                <label for="salaryDate" >Month & Year</label>
                                <div class='input-group date'  id="divSalaryDate" >
                                    <input  type='text' name='salaryDate'  id='salaryDate' placeholder="Select month & year" class="form-control" />

                                    <span  class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar">
                                        </span>
                                    </span>

                                </div>
                                <small class="form-text text-muted">Select month & year of salary payment.</small>
                            </div>
                        </div>

                        <div class="col-sm-1" style="margin-top: 25px;" >
                            <button  href="#payslips" type="submit" style="margin-left: 20px" name='submitSalary'id="submitSalary" class="btn btn-success mb-2">Load Payslips</button>

                        </div>
                        <div class="col-sm-1" style="margin-top: 25px; margin-left: 25px;" >
                            <button  href="#" type="reset" style="margin-left: 20px" name='resetEmployee' id="resetEmployee" class="btn btn-danger mb-2">Clear</button>

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
                                        echo "<br><br><u>WPS Payslips</u>";
                                        $_SESSION['salaryDate'] = $_POST['salaryDate'];
                                    } else
                                        echo "Approved Payslips <br><br><u>WPS Payslips</u>";
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

                            <div class="col-sm-12" >
                                <div  style="overflow-x:auto;overflow-y:auto;height: 50vh;">       
                                    <table class="table table-striped  table-bordered  table-hover table-sm" id='payslips' ></table>
                                </div>
                                <br>

                                <input id="downloadPDFPayslips" value="Download PDF" class="btn btn-primary mb-2" type="button"  onclick="$('#payslips').tableHTMLExport({type: 'pdf', filename: '<?php echo "WPS Payslips:" . $_SESSION['employerNo'] . date('ymdHis') . ".pdf"; ?>'});">
                                <input id="viewSIF" value="Generate SIF" class="btn btn-primary mb-2" type="button" >
                                <input id="downloadSIF" value="Download SIF" class="btn btn-primary mb-2" type="button" style="visibility: hidden" onclick="$('#payslipsSIF').tableToCsv({outputheaders: false, fileName: '<?php echo $_SESSION['employerNo'] . date('ymdHis'); ?>'});">

                            </div>


                            <div class="col-sm-12">
                                <h4 class="card-title" style="text-align: center; float: center;  font-weight: bold; color: maroon">
                                    <?php
                                    echo "<u>Non WPS Payslips</u>";
                                    ?> 
                                </h4> 
                            </div>

                            <div  class="col-sm-12">   
                                <div style="overflow-x:auto;overflow-y:auto;height: 80vh;" >

                                    <table   class="table table-striped  table-bordered  table-hover table-sm" id='nonWpsPayslips'></table>
                                </div><br>
                                <input id="downloadPDF" value="Download PDF" class="btn btn-primary mb-2" type="button"  onclick="$('#nonWpsPayslips').tableHTMLExport({type: 'pdf', filename: '<?php echo "Non WPS Payslips:" . $_SESSION['employerNo'] . date('ymdHis') . ".pdf"; ?>'});">

                            </div>
                            <table class="table" style="visibility: hidden" id='payslipsSIF'></table>



                        </div>
                    </div>


                </div>

            </div>

        </div>
    </div>

</body>


<script type="text/javascript">


    $(document).ready(function () {


        $("#viewSIF").click(function () {

            $(this).prop("disabled", true);
            // add spinner to button
//                    $(this).html(
//                            `Fetching...  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`
//                            );
            document.getElementById("viewSIF").classList.add('btn-danger');


            var $employerNo = "<?php
                                    if (isset($_SESSION['employerNo']) && $_SESSION['employerNo'] != '')
                                        echo $_SESSION['employerNo'];
                                    else
                                        echo "";
                                    ?>";
            var $employerRouting = "<?php
                                    if (isset($_SESSION['employerRouting']) && $_SESSION['employerRouting'] != '')
                                        echo $_SESSION['employerRouting'];
                                    else
                                        echo "";
                                    ?>";
            var $salaryDate = "<?php
                                    if (isset($_SESSION['salaryDate']) && $_SESSION['salaryDate'] != '')
                                        echo $_SESSION['salaryDate'];
                                    else
                                        echo "";
                                    ?>";

            if ($employerNo === "")
                alert("Please Enter Employer Unique Number and reload payslips");
            else if ($employerRouting === "")
                alert("Please Enter Bank Routing code and reload payslips");
            else if ($salaryDate === "")
                alert("Please Enter Month & Year of Salary payment and reload payslips");

            else {
//                        $('#payslipsSIF').table2CSV({header: ['']});
                document.getElementById("downloadSIF").style.visibility = "visible";
            }

        });
    });


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


<!-------------------------------------java scripts------------------------------------>
<script type="text/javascript">

    document.getElementById("navSifCreator").classList.add('active');

    var salaryDate = document.getElementById("salaryDate").value;

    var wpshhtp = new XMLHttpRequest();
    wpshhtp.onreadystatechange = function () {
        if (this.readyState === 4)
            document.getElementById("nonWpsPayslips").innerHTML = this.responseText;
    };
    wpshhtp.open("POST", "sql/payslipsNonWps.php", false);
    wpshhtp.send();


//------------------------------------------------------------------------------------------

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4)
            document.getElementById("payslips").innerHTML = this.responseText;
    };
    xmlhttp.open("POST", "sql/payslips.php", false);
    xmlhttp.send();

//-------------------------------------------------------------------------------------------


    var sifhtttp = new XMLHttpRequest();
    sifhtttp.onreadystatechange = function () {
        if (this.readyState === 4)
            document.getElementById("payslipsSIF").innerHTML = this.responseText;
    };
    sifhtttp.open("POST", "sql/payslipsSIF.php", false);
    sifhtttp.send();


    document.getElementById("employerBankNo").value = '<?php if (isset($_SESSION["employerNo"])) echo $_SESSION["employerNo"]; ?>';
    document.getElementById("employerRouting").value = '<?php if (isset($_SESSION["employerRouting"])) echo $_SESSION["employerRouting"]; ?>';
    document.getElementById("salaryDate").value = '<?php if (isset($_SESSION["salaryDate"])) echo $_SESSION["salaryDate"]; ?>';


</script>

<script >
    var frmvalidator = new Validator("formPayslip");
    frmvalidator.addValidation("employerBankNo", "maxlen=13", "Maximum length for Employer Unique Number  is 13");
    frmvalidator.addValidation("employerBankNo", "num", "Only digits are allowed in Employer Unique Number");


    frmvalidator.addValidation("employerRouting", "maxlen=9", "Maximum length for Bank Routing Code  is 9");
    frmvalidator.addValidation("employerRouting", "num", "Only digits are allowed in Bank Routing Code");

    frmvalidator.addValidation("salaryDate", "regexp=((0-1)?([0-9]){1}\/([0-9]){4})", "Invalid Date Format! Use MM/YYYY ");


</script>



<!-------------------------------End of Java Scripts------------------------------------>        


</html>


