<?php
session_start();
include('header.php');
if (isset($_SESSION['token'])){
header("Location: generateSIF.php");}

?>


<script>
    $(function () {
        $("#generate-button").click(function () {
            var instanceurl = $("#instanceurl").val();
            var client_id = $("#client_id").val();
            var client_secret = $("#client_secret").val();
            var redirect_uri = $("#redirect_uri").val();
            var username = $("#username").val();
            var password = $("#password").val();
            if (username === "" || password === "")
                alert("Username or Password can not be empty");
            else
            {
                var token_input = $("#token");
                var result_div = $("#result");
                document.getElementById("iurl").value = document.getElementById("instanceurl").value;
                generate_token(instanceurl, client_id, client_secret, redirect_uri, username, password, token_input, result_div);
            }
        });
    });
</script>

<script>
    function generate_token(instanceurl, client_id, client_secret, redirect_uri, username, password, token_input, result_div) {
        token_input.val("");
        result_div.html("");
        try
        {
            var xmlDoc;
            var xhr = new XMLHttpRequest();
            xhr.open("POST", instanceurl + "/oauth/token", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function (e)
            {
                if (xhr.readyState === 4)
                {
                    var a = JSON.parse(e.target.responseText);
                    token_input.val(a["access_token"]);
                    if (token_input.val() !== "")
                    {
                        document.getElementById('invalidCredentials').style.display = 'none';
                        $('#welcome-modal').modal('show');
                        setTimeout(function () {
                            $('#welcome-modal').modal('hide');
                        }, 3000);
                        document.getElementById("generate-payslip").click();
                    } else
                        document.getElementById('invalidCredentials').style.display = 'inline';


                    result_div.html(show_response(e.target.responseText));
                    xmlDoc = this.responseText;
                    txt = "";
                }
            };
            xhr.send("client_id=" + client_id + "&client_secret=" + client_secret + "&grant_type=password&username=" + username + "&password=" + password + "&redirect_uri=" + redirect_uri);
        } catch (err)
        {
            alert(err.message);
        }
    }
    ;

    function show_response(str) {
        str = vkbeautify.xml(str, 4);
        return str.replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/\n/g, "<br />");
    }
    ;

    function validateForm() {
        var x = document.forms["frm"]["token"].value;
        if (x === "") {
            alert("Generate an access token first");
            return false;
        }
    }
    ;
</script>



<body>

    <!--API Connecting with Demo--> 
    <input  id="instanceurl" type="hidden" name="instanceurl" value="http://demo.indepth.ae"/>
    <input  id="client_id" type="hidden" value="5fd097a24816229cf3052578e4ea61c07c81c8c0ad287d9ec42b458848fa34c5"/>
    <input  id="client_secret" type="hidden" value="a79cd490f8b429d3bfcd84aeb67da1a25ae3562d82fe4e6acc0e3f6322e8511c"/>
    <input  id="redirect_uri" type="hidden" value="http://wps.demo.indepth.ae"/>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
                <form class="login100-form validate-form flex-sb flex-w"  onsubmit = "event.preventDefault();"  >
                    <span class="login100-form-title p-b-32">
                        WPS Login
                    </span>

                    <?php if (isset($_SESSION['login'])) { ?>

                        <div id='loginFirst' class="alert alert-warning wrap-input100  m-b-12">
                            <strong>Not Logged-in!</strong> Please Login First.
                        </div>

                        <?php
                        unset($_SESSION['login']);
                    }

                    if (isset($_SESSION['noaccess'])) {
                        ?>

                        <div id='noaccess' class="alert alert-danger wrap-input100  m-b-12">
                            <strong>Unauthorized!</strong> You are unauthorized to use this system. Please contact system administrator.
                        </div>

                        <?php
                        unset($_SESSION['noaccess']);
                    }
                    ?>  



                    <div id='invalidCredentials' class="alert alert-danger wrap-input100  m-b-12" style="display: none;">
                        <strong>Invalid!</strong> Username/Password is inavlid.
                    </div>

                    <span class="txt1 p-b-11">
                        Username
                    </span>
                    <div class="wrap-input100 validate-input m-b-36" data-validate = "Username is required">
                        <input class="input100" type="text" name="username" id='username' >
                        <span class="focus-input100"></span>
                    </div>

                    <span class="txt1 p-b-11">
                        Password
                    </span>
                    <div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
                        <span class="btn-show-pass">
                            <i class="fa fa-eye"></i>
                        </span>
                        <input class="input100" type="password" name="password" id='password'>
                        <span class="focus-input100"></span>
                    </div>

                    <div class="flex-sb-m w-full p-b-48">
                        <div class="contact100-form-checkbox">
                            <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                            <label class="label-checkbox100" for="ckb1">
                                Remember me
                            </label>
                        </div>

                        <div >
                            <a href="#" onclick=" $('#forget_modal').modal('show');" id='forget_password' class="txt3">
                                Forgot Password?
                            </a>
                        </div>
                    </div>

                    <div class="container-login100-form-btn">
                        <button type= "submit" id="generate-button"  class="login100-form-btn">
                            Login
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <form name="frm" onsubmit="return validateForm()" action="login.php" method="POST" style="display: none">
        <input id="token" type="hidden" name="token">
        <input id="iurl" type="hidden" name="iurl">
        <input id="user" type="hidden" name="user">
       <!--<input id="key" type="hidden" name="key" value='1'>-->

        <input type= "submit" id="generate-payslip" value ="Generate Payslips">
    </form>


    <div id="dropDownSelect1"></div>

    <div id="welcome-modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p style="text-align: center"><strong> Successfully Logged in. </strong></p>
                </div>
            </div>
        </div>
    </div>

    <div id="forget_modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p style="text-align: center; color:red"><strong> Please contact you system administrator at <b>support@indepth.ae</b>  to reset password. </strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>


        </div>
    </div>


    <!--===============================================================================================-->
    <script src="vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="js/main.js"></script>


    <script>



        var input = document.getElementById("password");
        input.addEventListener("keyup", function (event) {
            document.getElementById("user").value = document.getElementById("username").value;
            if (event.keyCode === 13)
                document.getElementById("generate-button").click();
        });
    </script>


</body>
</html>
