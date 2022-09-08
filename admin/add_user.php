<?php

session_start();

include('../config/credentials.php');

// session_start();





date_default_timezone_set('Asia/Manila');
// $date = date('Y-m-d');
$now = new DateTime();


$btnSave = $btnEdit = $user_name = $entity_no = $btn_enabled =
    $firstname = $middlename = $lastname =
    $symptoms = $patient = $person_status = $entity_no = '';








?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>VAMOS | User Credentials Form </title>
    <?php include('heading.php'); ?>



</head>



<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?php include('sidebar.php'); ?>

        <div class="content-wrapper">
            <div class="content-header"></div>


            <section class="content ">
                <div class="card">
                    <div class="card-header text-white bg-dark">
                        <h4> User Credentials Forms </h4>
                    </div>

                    <div class="card-body">
                        <form role="form" enctype="multipart/form-data" method="post" id="input-form" action="">
                            <div class="box-body">
                                <!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
                                <div class="card ">
                                    <div class="card-header">
                                        <h6>USERS INFORMATION</h6>
                                    </div>
                                    <div class="box-body">
                                        <br>

                                        <div class="row">
                                            <div class="col-md-3" style="text-align: right;">
                                                <label>Username : </label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" id="username" name="username" style=" text-transform: uppercase;" placeholder="Username" onblur="checkUsername()" value="<?php echo $user_name; ?>" required>
                                                <div id="status"></div>
                                            </div>
                                        </div><br>


                                        <div class="row">
                                            <div class="col-md-3" style="text-align: right;">
                                                <label>Password : </label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" id="userpass" name="userpass" placeholder="PASSWORD" value="" required>
                                            </div>
                                        </div><br>


                                        <div class="row">
                                            <div class="col-md-3" style="text-align: right;">
                                                <label>Department/Office:</label>
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-control select2" id="department" name="department" value="<?php echo $brgy; ?>">
                                                    <option selected="selected">Select Department/Office</option>
                                                </select>
                                            </div>
                                        </div></br>


                                        <div class="row">
                                            <div class="col-md-3" style="text-align: right;">
                                                <label>First Name: </label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="first_name" style=" text-transform: uppercase;" id="first_name" placeholder="First Name" value="<?php echo $firstname; ?>" required>
                                            </div>
                                        </div><br>

                                        <div class="row">
                                            <div class="col-md-3" style="text-align: right;">
                                                <label>Middle Name: </label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="middle_name" style=" text-transform: uppercase;" id="middle_name" placeholder="Middle Name (Ex: 'A')" value="<?php echo $middlename; ?>" required>
                                            </div>
                                        </div><br>


                                        <div class="row">
                                            <div class="col-md-3" style="text-align: right;">
                                                <label>Last Name: </label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="last_name" style=" text-transform: uppercase;" id="last_name" placeholder="Last Name" value="<?php echo $lastname; ?>" required>
                                            </div>
                                        </div><br>


                                        <div class="row">
                                            <div class="col-md-3" style="text-align: right;">
                                                <label>Account Type: </label>
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-control select2" id="type" name="account_type" value="<?php echo $account; ?>">
                                                    <option selected="selected">Select Account Type</option>


                                                </select>
                                            </div>
                                        </div><br>



                                        <div class=" box-footer" align="center">
                                            <button type="submit" name="insert_user" id="btnSubmit" class="btn btn-success">
                                                <i class="fa fa-check fa-fw"> </i> </button>

                                            <a href="list_users">
                                                <button type="button" name="cancel" class="btn btn-danger">
                                                    <i class="fa fa-close fa-fw"> </i> </button>
                                            </a>

                                            <!-- <a href="../plugins/jasperreport/entity_id.php?entity_no=<?php echo $entity_no; ?>">
                                                <button type="button" name="print" class="btn btn-primary">
                                                    <i class="nav-icon fa fa-print"> </i> </button>
                                            </a> -->


                                        </div><br>





                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </section>
            <br><br>
        </div>

        <?php include('footer.php') ?>

    </div>


    <?php include('scripts.php') ?>



    <script>
        $('.select2').select2();

        function checkUsername() {
            var username = $('#username').val();
            if (username.length >= 0) {
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





        // $("#insert_user").click(function(e) {
        //     e.preventDefault();
        //     var name = $("#name").val();
        //     var last_name = $("#last_name").val();
        //     var 
        //     var dataString = 'name=' + name + '&last_name=' + last_name;
        //     $.ajax({
        //         type: 'POST',
        //         data: dataString,
        //         url: 'insert_user.php',
        //         success: function(data) {
        //             alert(data);
        //         }
        //     });
        // });
    </script>
</body>

</html>