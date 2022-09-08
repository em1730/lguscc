<?php

include('../config/credentials.php');




if (!isset($_SESSION['id'])) {
    header('location:../index.php');
}


$docno = '';
// include ('includes/head.php');



// count new messages
$get_all_message_sql = "SELECT count(*) as total FROM tbl_message where receiver = $user_id and status = 'PENDING'";
$get_all_message_data = $db_dts->prepare($get_all_message_sql);
$get_all_message_data->execute();
while ($result1 = $get_all_message_data->fetch(PDO::FETCH_ASSOC)) {
    $message_count =  $result1['total'];
}

// //select all messages for notification
$get_all_messages_sql = "SELECT * FROM tbl_message where (receiver = $user_id or receiver = '0') and status = 'PENDING' ";
$get_all_messages_data = $db_dts->prepare($get_all_messages_sql);
$get_all_messages_data->execute();

// //select all messages for email
$get_all_messages1_sql = "SELECT * FROM tbl_message where receiver = $user_id or receiver ='0'";
$get_all_messages1_data = $db_dts->prepare($get_all_messages1_sql);
$get_all_messages1_data->execute();

//select all from settings
$get_all_settings_sql = "SELECT * FROM tbl_settings";
$get_all_settings_data = $db_dts->prepare($get_all_settings_sql);
$get_all_settings_data->execute();
$get_all_settings_data->setFetchMode(PDO::FETCH_ASSOC);
while ($result = $get_all_settings_data->fetch(PDO::FETCH_ASSOC)) {
    $settings_obr =  $result['obrno'];
    $settings_dv = $result['dvno'];
}














?>
<style>
    label {
        font-size: 16px;
        color: black;
    }

    .fas,
    .icons,
    #icons {
        color: black;
    }

    p {
        color: black;
    }

    .sidebar-link:hover,
    #lightgreen:hover {
        background-color: lightskyblue;
    }


    /* .top-link{

  } */
    .top-link:hover {
        background-color: black;
        color: black;
    }

    #label1::after,
    .label3::before,
    .label3::after {
        content: '';
        display: block;
        position: absolute;

        background-color: black;
        width: 200px;
        height: 1px;


        /* bottom: -3px; */
    }

    /* i {
        margin-left: 10px;
        font-size: 20px;
        height: 30px;
        vertical-align: middle;
    } */
</style>

<nav class="main-header navbar navbar-expand bg-dark navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
        </li>

        <li class="nav-item d-none d-sm-inline-block">
            <a href="index.php" class="nav-link">Dashboard </a>
        </li>


        <!-- 
        <li class="nav-item d-none d-sm-inline-block">
            <a href="it_support.php" class="nav-link">IT Support</a>
        </li> -->
    </ul>


    <aside class="control-sidebar control-sidebar-dark">
        <div class="modal-header">
            <h4 class="modal-title">SETTINGS</h4>
        </div>

        <div class="modal-body">
            <div class="box-body">
                <div class="form-group" <?php if ($db_department != 'CBO') { ?> style="display:none" <?php } ?>>
                    <h6 class="modal-title">Update OBR No:</h6>
                    <input type="text" name="update_obr" id="update_obr" class="form-control" value="<?php echo $settings_obr; ?>" required>
                </div>

                <div class="box-body">
                    <div class="form-group" <?php if ($db_department != 'ACCTG') { ?> style="display:none" <?php } ?>>
                        <h6 class="modal-title">Update DV No:</h6>
                        <input type="text" name="update_dv" id="update_dv" class="form-control" value="<?php echo $settings_dv; ?>" required>
                    </div>
                </div>x
            </div>
        </div>
    </aside>



    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item d-none d-sm-inline-block" style="align-items: right;">
            <a href="edit_profile.php" class="nav-link">Username: <?php echo strtoupper($db_first_name . ' ' . substr($db_middle_name, 0, 1) . '. ' . $db_last_name) ?> </a>
        </li>
    </ul>



</nav>
<aside class="main-sidebar sidebar-dark elevation-4">

    <div class="greenBG">

        <div class="sidebar bg-dark">
            <br>
            <img src="../dist/img/scclogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-4">
            <span class="brand-text font-weight-bold" style="font-size: 18px;"> DOCTRACK </span>

            <br><br>


        </div>

    </div>


    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">


                <div>
                    <label id="label1" style="font-size:18px; ">
                        &nbsp;
                        <i class="nav-icon fas fa-home icons"></i>
                        &nbsp;
                        Dashboard
                    </label>

                    <li class="nav-item">
                        <a href="index.php" class="nav-link sidebar-link">
                            &nbsp;
                            <i class="nav-icon fas fa-undo icons"></i>
                            <p> &nbsp; Homepage</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="list_incoming.php" class="nav-link sidebar-link">
                            &nbsp;
                            <i class="nav-icon fa fa-arrow-down icons"></i>
                            <p> &nbsp; Incoming</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="list_received.php" class="nav-link sidebar-link">
                            &nbsp;
                            <i class="nav-icon fa fa-folder-open icons"></i>
                            <p> &nbsp; Received</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="list_outgoing.php" class="nav-link sidebar-link">
                            &nbsp;
                            <i class="nav-icon fa fa-arrow-up icons"></i>
                            <p> &nbsp; Outgoing</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="list_archived.php" class="nav-link sidebar-link">
                            &nbsp;
                            <i class="nav-icon fa fa-archive icons"></i>
                            <p> &nbsp; Archive</p>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a href="track_documents.php" class="nav-link sidebar-link">
                            &nbsp;
                            <i class="fa fa-search nav-icon icons"></i>
                            <p> &nbsp; Track Documents</p>
                        </a>
                    </li>


                </div><br>

                <div>



                    <label id="label1" style="font-size:18px; ">
                        &nbsp;
                        <i class="fa fa-tasks nav-icon icons"></i>
                        &nbsp;
                        TRANSACTION
                    </label>



                    <li class="nav-item">
                        <a href="add_outgoing.php" class="nav-link sidebar-link">
                            &nbsp;
                            <i class="fa fa-share  nav-icon icons  fa-rotate-horizontal-180"></i>
                            <p> &nbsp; Forward</p>
                        </a>
                    </li>

                    <!-- <li class="nav-item">
                        <a href="receive_incoming_other.php" class="nav-link sidebar-link">
                            &nbsp;
                            <i class="fa fa-arrow-right nav-icon icons"></i>
                            <p> &nbsp; Receive</p>
                        </a>
                    </li> -->



                    <!-- <li class="nav-item">
                        <a href="release_document.php" class="nav-link sidebar-link">
                            &nbsp;
                            <i class="fa fa-arrow-right nav-icon icons"></i>
                            <p> &nbsp; Release</p>
                        </a>
                    </li> -->
                    <li class="nav-item">
                        <a href="force_receive.php" class="nav-link sidebar-link">
                            &nbsp;
                            <i class="fa fa-share-square nav-icon icons  fa-flip-horizontal"></i>
                            <p> &nbsp; Force Receive</p>
                        </a>
                    </li>










                </div><br>




                <div>
                    <label id="label1" style="font-size:18px; ">
                        &nbsp;
                        <i class="fa fa-folder-open nav-icon icons"></i>
                        &nbsp;
                        MASTERLIST
                    </label>
                    <?php ?>

                    <?php if ($db_department == 'ITCSO') { ?>

                        <li class="nav-item">
                            <a href="list_users.php" class="nav-link sidebar-link">
                                &nbsp;
                                <i class="fas fa-users nav-icon icons"></i>
                                <p> &nbsp; Users</p>
                            </a>
                        </li>
                    <? } else { ?>
                        <li class="nav-item" hidden>
                            <a href="list_users.php" class="nav-link sidebar-link">
                                &nbsp;
                                <i class="fas fa-users nav-icon icons"></i>
                                <p> &nbsp; Users</p>
                            </a>
                        </li>
                    <?php } ?>

                    <li class="nav-item">
                        <a href="list_suppliers.php" class="nav-link sidebar-link">
                            &nbsp;
                            <i class="nav-icon fas fa-truck-loading icons"></i>
                            <p> &nbsp; Supplier</p>
                        </a>
                    </li>



                </div><br>

                <div>
                    <label id="label1" style="font-size:18px; ">
                        &nbsp;
                        <!-- <i class="fas fa-bars"></i> -->
                        <i class="fas fa-print  nav-icon icons"></i>
                        <!-- <i class="fa fa-tasks nav-icon icons"></i> -->
                        &nbsp;
                        REPORT
                    </label>
                    <li class="nav-item">
                        <a href="#myModal" data-toggle="modal" data-target="#myModal" class="nav-link sidebar-link">
                            &nbsp;
                            <i class="fas fa-print nav-icon icons"></i>
                            <p> &nbsp;Routing Slip</p>
                        </a>
                    </li>


                    <!-- <li class="nav-item">
                        <a href="list_suppliers.php" class="nav-link sidebar-link">
                            &nbsp;
                            <i class="fas fa-print  nav-icon icons"></i>
                            <p> &nbsp; Routing Slip</p>
                        </a>
                    </li> -->




                </div><br>

                <div>

                    <label id="label1" style="font-size:18px; ">
                        &nbsp;
                        <i class="nav-icon fa fa-lock icons"></i>
                        &nbsp;
                        ACCOUNT
                    </label>



                    <li class="nav-item">
                        <a href="edit_profile.php" class="nav-link sidebar-link">
                            &nbsp;
                            <i class="nav-icon fa fa-pencil-square-o icons"></i>
                            <p> &nbsp; Edit Profile</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="../index.php" class="nav-link  sidebar-link">
                            &nbsp;
                            <i class="fa fa-sign-out nav-icon icons"></i>
                            <p> &nbsp; Sign Out</p>
                        </a>
                    </li>



                </div><br>


                <br><br><br><br><br><br><br><br>










            </ul>
        </nav>
    </div>


</aside>

<div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Print Routing Slip</h4>
            </div>
            <form method="POST" action="<?php htmlspecialchars("PHP_SELF") ?>">
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Please enter Document Number:</label>
                            <input type="text" name="modal_docno" id="modal_docno" class="form-control" value="<?php echo $docno; ?>" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default pull-left bg-olive" data-dismiss="modal">No</button>
                    <!-- <button type="submit" name="delete_user" class="btn btn-danger">Yes</button> -->
                    <a href="javascript:;" onclick="this.href='../plugins/TCPDF/User/routing.php?docno=' + document.getElementById('modal_docno').value" target="blank">

                        <input type="button" name="delete_user" class="btn btn-danger" value="Yes">
                    </a>.
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>