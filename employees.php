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


                            <div  class="col-sm-12"style="overflow-x:auto;overflow-y:auto;height: 80vh; padding-top: 20px">       
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
    
    <!-- Modal -->
<div class="modal fade" id="employeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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


     

<script>
    function highlight_row() {
    var table = document.getElementById('employees');
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
            $("#employeeModal .modal-body").text(msg);
            $('#employeeModal').modal('show');
        
        }
    }

} //end of function

window.onload = highlight_row;


</script>




    <!-------------------------------End of Java Scripts------------------------------------>        

</body>
</html>

