<?php

session_start();

include('../config/db_config.php');
//user-account details
include('user_account.php');


// include('update_profile.php');



date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d');
$now = new DateTime();
$time = date('H:i:s');

$btnSave = $btnEdi =  $entity_no = $btn_enabled =
    $get_firstname = $get_middlename = $get_lastname = $get_username  = $get_password =
    $get_department = $get_account = $get_new_password =
    $symptoms = $patient = $person_status = $get_entity_no = $get_time = '';

//fetch user from database










?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>VAMOS | User Credentials Update </title>
    <?php include('heading.php'); ?>

</head>



<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?php include('sidebar.php'); ?>

        <div class="content-wrapper">
            <div class="content-header"></div>


            <section class="content ">
                <div class="card">
                    <div class="card-header text-white bg-success">
                        <h4> Edit Profile </h4>
                    </div>

                    <div class="card-body">
                      
                    </div>
                </div>
            </section> <br><br>
        </div>

        <?php include('footer.php') ?>

    </div>
    


    <?php include('scripts.php') ?>




    <script>
    
        $('.select2').select2();





        function checkUsername() {
            var username = $('#username').val();
            if (username.length >= 3) {
                $("#status").html('<img src="loader.gif" /> Checking availability...');
                $.ajax({
                    type: 'POST',
                    data: {
                        username: username
                    },
                    url: 'check_username.php',
                    success: function(data) {
                        $("#status").html(data);

                    }
                });
            }
        };


    </script>
</body>

</html>