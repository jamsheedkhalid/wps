
<?php
//session_cache_limiter('private');
///* set the cache expire to 30 minutes */
//session_cache_expire(1);
session_start();
date_default_timezone_set('Asia/Dubai');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>WPS-InDepth</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--===============================================================================================-->	
        <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
        <!--===============================================================================================-->	
        <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">

        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
        <!--===============================================================================================-->	
        <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="css/util.css">
        <link rel="stylesheet" type="text/css" href="css/main.css">

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

        <script src="https://s3.amazonaws.com/api_play/src/js/vkbeautify.0.99.00.beta.js"></script>

        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!--        <script src="js/menuTrigger.js"></script>-->
        <script src="js/jquery.js"></script>
        <script src="js/jquery.min.js"></script>
        <script src="js/moment.min.js"></script>
        <script src="js/bootstrap-datetimepicker.min.js"></script>
        <script src="plugins/bootstrap/js/bootstrap.js"></script>
        <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="js/html2CSV.js" ></script>
        <script src="js/jquery.tabletocsv.js"></script>
        <script src="js/gen_validatorv4.js"></script>
        <script src="js/autoFill.js"></script>
        <script src="js/tableHTMLExport.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.5/jspdf.plugin.autotable.min.js"></script>
        
  
        <link href='https://fonts.googleapis.com/css' rel='stylesheet'>
        <link rel="stylesheet" href="css/style.css">
        <link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">

        <style>
            body {
                font-family: 'Arvo'; 
            }
            #navWpsIndepth {
                font-family: 'Barrio';font-size: 22px;
            }

            @media(max-width:992px) {
                #timeBar {
                    visibility: hidden;
                }}

            .dropdown:hover .dropdown-menu {
                display: block;
                margin-top: 0; // remove the gap so it doesn't close
            }
   
         
            
td {
 min-width:100px;
    max-width:300px;
 
}


        </style>
    </head>