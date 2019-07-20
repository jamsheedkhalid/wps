

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
                                        echo "<br><br><u>payslips</u>";
                                        $_SESSION['salaryDate'] = $_POST['salaryDate'];
                                    } else
                                        echo "<u>Payslips</u>";
                                    ?> 
                                </h4> 
                            </div>
 <div  class="col-sm-12 table-wrapper-scroll-y my-custom-scrollbar "style="overflow-x:auto;overflow-y:auto;height: 80vh; padding-top: 20px"> 

         <table class="table table-striped table-hover table-sm" id='payslips'>
             
         </table>

                            </div>



                        </div>
                    </div>


                </div>
    
            </div>

        </div>
    </div>
    
    
    


<!-- Modal -->
<div class="modal fade" id="payslipModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">You selection</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id='modalBody'>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
    

</body>


<script type="text/javascript">

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

    document.getElementById("pay").classList.add('active');

    var salaryDate = document.getElementById("salaryDate").value;



    var http = new XMLHttpRequest();
    http.onreadystatechange = function () {
        if (this.readyState === 4)
            document.getElementById("payslips").innerHTML = this.responseText;
    };
    http.open("POST", "sql/viewPayslips.php", false);
    http.send();
    document.getElementById("salaryDate").value = '<?php if (isset($_SESSION["salaryDate"])) echo $_SESSION["salaryDate"]; ?>';


</script>

<script >
    var frmvalidator = new Validator("formPayslip");
    frmvalidator.addValidation("salaryDate", "regexp=((0-1)?([0-9]){1}\/([0-9]){4})", "Invalid Date Format! Use MM/YYYY ");


</script>

<script>
    function highlight_row() {
    var table = document.getElementById('payslips');
    var cells = table.getElementsByTagName('td');

    for (var i = 0; i < cells.length; i++) {
        // Take each cell
        var cell = cells[i];
        // do something on onclick event for cell
        cell.onclick = function () {
            // Get the row id where the cell exists
            var rowId = this.parentNode.rowIndex;

            var rowsNotSelected = table.getElementsByTagName('tr');
            for (var row = 0; row < rowsNotSelected.length; row++) {
                rowsNotSelected[row].style.backgroundColor = "";
                rowsNotSelected[row].style.color = "";
                rowsNotSelected[row].classList.remove('selected');
            }
            var rowSelected = table.getElementsByTagName('tr')[rowId+1];
            rowSelected.style.backgroundColor = "#27a17c";
            rowSelected.style.color = "white";
            rowSelected.className += " selected";

            msg = 'Employee ID: ' + rowSelected.cells[0].innerHTML;
            msg += '\n Employee Name: ' + rowSelected.cells[1].innerHTML;
            msg += '\n Cell value: ' + this.innerHTML;
//            alert(msg);
            $("#payslipModal .modal-body").text(msg);
            $('#payslipModal').modal('show');
        }
    }

} //end of function

window.onload = highlight_row;

</script>


<!-------------------------------End of Java Scripts------------------------------------>        


</html>


