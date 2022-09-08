<?php

session_start();

if (!isset($_SESSION['id'])) {
  header('location:../index.php');
}

$user_id = $_SESSION['id'];

include('../config/db_config.php');
include('delete.php');

$get_user_sql = "SELECT * FROM tbl_users WHERE user_id = :id";
$get_user_data = $con->prepare($get_user_sql);
$get_user_data->execute([':id'=>$user_id]);
while ($result = $get_user_data->fetch(PDO::FETCH_ASSOC)) {

$user_name = $result['username'];
$GLOBALS['department'] = $result['department'];
$db_first_name = $result['first_name'];
$db_middle_name = $result['middle_name'];
$db_last_name = $result['last_name'];
$db_email_ad = $result['email'];
$db_contact_number = $result['contact_no'];
$db_user_name = $result['username'];
}

if (isset($_GET['objid'])) {
  $objid = $_GET['objid'];
// //select all messages
$get_all_messages_sql = "SELECT * FROM tbl_message where objid = $objid";
$get_all_messages_data = $con->prepare($get_all_messages_sql);
$get_all_messages_data->execute();  
while ($result = $get_all_messages_data->fetch(PDO::FETCH_ASSOC)) {
  $objid = $result['objid'];
  $date = $result['date'];
  $sender = $result['sender']; 
  $subject = $result['subject']; 
  $message= $result['message']; 
}
$update_message_sql = "UPDATE tbl_message SET 
status = :stat
where objid = :objid";

$update_message_data = $con->prepare($update_message_sql);
$update_message_data->execute([
    ':stat'             => 'READ',
       ':objid'             => $objid
   
    ]);

    
// count new messages
$get_all_message_sql = "SELECT count(*) as total FROM tbl_message where receiver = $user_id and status = 'PENDING'";
$get_all_message_data = $con->prepare($get_all_message_sql);
$get_all_message_data->execute();  
while ($result1 = $get_all_message_data->fetch(PDO::FETCH_ASSOC)) {
  $message_count =  $result1['total'];
}

// //select all messages for notification
$get_all_messages_sql = "SELECT * FROM tbl_message where receiver = $user_id and status = 'PENDING' ";
$get_all_messages_data = $con->prepare($get_all_messages_sql);
$get_all_messages_data->execute();  

// //select all messages for email
$get_all_messages1_sql = "SELECT * FROM tbl_message where receiver = $user_id";
$get_all_messages1_data = $con->prepare($get_all_messages1_sql);
$get_all_messages1_data->execute();  

}


?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>LGUSCC DTS | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="../dist/css/ionicons.min.css"> -->
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
  <!-- Morris chart
  <link rel="stylesheet" href="../plugins/morris/morris.css">
  jvectormap -->
  <!-- <link rel="stylesheet" href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css"> -->
  <!-- Date Picker -->
  <link rel="stylesheet" href="../plugins/datepicker/datepicker3.css">
  <!-- Daterange picker
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker-bs3.css"> -->
  <!-- bootstrap wysihtml5 - text editor -->
  <!-- <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"> -->
  <!-- Google Font: Source Sans Pro -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->
   <!-- DataTables -->
   <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap4.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="send_email" class="nav-link">Contact</a>
      </li>
   
    <li class="nav-item d-none d-sm-inline-block">
        <a href="it_support" class="nav-link">IT Support</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-comments-o"></i>
          <span class="badge badge-danger navbar-badge"> <?php echo $message_count ?> </span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        
        <?php while($messages_data = $get_all_messages_data->fetch(PDO::FETCH_ASSOC)){ ?>
        <a href="read-mail.php?objid=<?php echo $messages_data['objid'];?>" class="dropdown-item">
            <!-- Message Start -->

          

            <div class="media">
              <img src="../dist/img/logo.png" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  <?php echo $messages_data['sender']; ?>
                  <span class="float-right text-sm text-danger"><i class="fa fa-star"></i></span>
                </h3>
                <p class="text-sm">  <?php echo $messages_data['subject']; ?></p>
                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i>   <?php echo $messages_data['date']; ?></p>
              </div>
            </div>
            <!-- Message End -->
          </a>

          <?php } ?>

         
          <div class="dropdown-divider"></div>
          <a href="mailbox.php" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-bell-o"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
            class="fa fa-th-large"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="../dist/img/scclogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: ">
      <span class="brand-text font-weight-light">LGUSSC | DTS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="profile.php" class="d-block"><?php echo $db_first_name . " " . $db_middle_name . " " . $db_last_name ?>  </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
         
               <li class="nav-item">
                <a href="index.php" class="nav-link active">
                  <i class="nav-icon fa fa-th"></i>
                  <p>
                    Dashboard
                    <!-- <span class="right badge badge-danger">New</span> -->
                  </p>
                </a>
              </li>
             
              <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-dashboard"></i>
              <p>
                TRANSACTIONS
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            
            <ul class="nav nav-treeview">

            <li class="nav-item">
                <a href="add_outgoing" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Forward</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="receive_incoming_other" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Receive</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="release_document" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Release</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="archive_document" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Archive</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="track_documents" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Track Documents</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="force_receive" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Force Receive</p>
                </a>
              </li>
              </ul>
            
              <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-dashboard"></i>
              <p>
                MASTER LISTS
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="list_document_type" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Document Types</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="list_department" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Departments</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="list_document_type" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Users</p>
                </a>
              </li>
              </ul>

              <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
              <i class="nav-icon fa fa-dashboard"></i>
              <p>
                REPORTS
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="receiving_copy" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Receiving Copy</p>
                </a>
              </li>
              </ul>

              <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
              <i class="nav-icon fa fa-dashboard"></i>
              <p>
                SETTINGS
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="add_document" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Add Document Type</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="add_department" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Add Department</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="add_user " class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Add User</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="add_suppliers " class="nav-link">
                <i class="fa fa-circle-o nav-icon"></i>
                  <p>Add Suppliers</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="add_joborder " class="nav-link">
                <i class="fa fa-circle-o nav-icon"></i>
                  <p>Add Job Order</p>
                </a>
              </li>

             
              </ul>

              <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
              <i class="nav-icon fa fa-dashboard"></i>
              <p>
                SYTEM
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../lockscreen.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>LOCK</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="../logout.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>SIGN OUT</p>
                </a>
              </li>
              </ul>
          
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
        
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <a href="mailbox.php" class="btn btn-primary btn-block mb-3">Back to Inbox</a>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Folders</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body p-0">
                <ul class="nav nav-pills flex-column">
                  <li class="nav-item">
                    <a href="mailbox.php" class="nav-link">
                      <i class="fa fa-inbox"></i> Inbox
                      <span class="badge bg-primary float-right"><?php echo $message_count ?> </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fa fa-envelope-o"></i> Sent
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fa fa-file-text-o"></i> Drafts
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fa fa-filter"></i> Junk
                      <span class="badge bg-warning float-right">65</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fa fa-trash-o"></i> Trash
                    </a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /. box -->
            
            <!-- /.card -->
          </div>
          <!-- /.col -->
        <div class="col-md-9">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Read Mail</h3>

              <div class="card-tools">
                <a href="#" class="btn btn-tool" data-toggle="tooltip" title="Previous"><i class="fa fa-chevron-left"></i></a>
                <a href="#" class="btn btn-tool" data-toggle="tooltip" title="Next"><i class="fa fa-chevron-right"></i></a>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="mailbox-read-info">
                <h5><?php echo $subject ?></h5>
                <h6>From: <?php echo $sender ?>
                  <span class="mailbox-read-time float-right"><?php echo $date ?></span></h6>
              </div>
              <!-- /.mailbox-read-info -->
              <div class="mailbox-controls with-border text-center">
                <div class="btn-group">
                  
                </div>
                <!-- /.btn-group -->
               
              </div>
              <!-- /.mailbox-controls -->

              <div class="col-md-10" style="text-align: right;padding-top: 5px;">
                  </div>
                  <div class="col-md-15">
                      <textarea rows="20" class="form-control" name="particulars" placeholder="Subject/Particulars"  required><?php echo $message ?></textarea>
                  </div>
                </div><br>

      
              <!-- /.mailbox-read-message -->
           
            <!-- /.card-footer -->
            <div class="card-footer">
              <div class="float-right">
              <a href="reply_mail.php?objid=<?php echo $objid;?>">
                <button type="button" class="btn btn-default"><i class="fa fa-reply"></i>  Reply</button>
            </a>
                <button type="button" class="btn btn-default"><i class="fa fa-share"></i> Forward</button>
              </div>
              <button type="button" class="btn btn-default"><i class="fa fa-trash-o"></i> Delete</button>
              <button type="button" class="btn btn-default"><i class="fa fa-print"></i> Print</button>
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.0-alpha
    </div>
    <strong>Copyright &copy; 2014-2018 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
  </footer>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<!-- <script src="../dist/css/jquery-ui.min.js"></script> -->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  // $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Morris.js charts -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script> -->
<!-- <script src="../plugins/morris/morris.min.js"></script> -->
<!-- Sparkline -->
<!-- <script src="../plugins/sparkline/jquery.sparkline.min.js"></script> -->
<!-- jvectormap -->
<!-- <script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script> -->
<!-- <script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script> -->
<!-- jQuery Knob Chart -->
<!-- <script src="../plugins/knob/jquery.knob.js"></script> -->
<!-- daterangepicker -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script> -->
<!-- <script src="../plugins/daterangepicker/daterangepicker.js"></script> -->
<!-- datepicker -->
<script src="../plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.js"></script>
<script src="../plugins/datatables/dataTables.bootstrap4.js"></script>
</body>
</html>
