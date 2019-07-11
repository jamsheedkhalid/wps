<?php
include('header.php');
session_start();
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
                            alert("Welcome, Login Successful.");
                            document.getElementById("generate-report").click();
                        }
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
        <input  id="redirect_uri" type="hidden" value="http://wps.demo.indepth.ae/"/>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
                <form class="login100-form validate-form flex-sb flex-w" method="POST" action="genera"  >
                    <span class="login100-form-title p-b-32">
                        WPS Login
                    </span>

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

                        <div>
                            <a href="#" class="txt3">
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
    
        <form name="frm" onsubmit="return validateForm()" action="generateSIF.php" method="POST" style="display: none">
            <input id="token" type="hidden" name="token">
            <input id="iurl" type="hidden" name="iurl">
            <input type= "submit" id="generate-report" value ="Generate Reports">
        </form>


    <div id="dropDownSelect1"></div>

    
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
            if (event.keyCode === 13)
                document.getElementById("generate-button").click();
        });
    </script>
    

</body>
</html>