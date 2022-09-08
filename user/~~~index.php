
<?php

include ('../config/db_config.php');
session_start();
$user_id = $_SESSION['id'];
$docno ='';
if (!isset($_SESSION['id'])) {
    header('location:../index.php');
} else {

}



//fetch user from database
$get_user_sql = "SELECT * FROM tbl_users where user_id = :id";
$user_data = $con->prepare($get_user_sql);
$user_data->execute([':id' => $user_id]);
while ($result = $user_data->fetch(PDO::FETCH_ASSOC)) {


    $db_first_name = $result['first_name'];
    $db_middle_name = $result['middle_name'];
    $db_last_name = $result['last_name'];
    $db_email_ad = $result['email'];
    $db_contact_number = $result['contact_no'];
    $db_user_name = $result['username'];
    $department = $result['department'];

}



// $get_all_document_sql = "SELECT * FROM tbl_ledger";
// $get_all_document_data = $con->prepare($get_all_document_sql);
// $get_all_document_data->execute();  

//count incoming documents
$get_noofdocs_sql= "SELECT COUNT(`docno`) as total FROM `tbl_documents` WHERE status in ('CREATED','FORWARDED') and destination = '$department'";
$get_noofdocs_data = $con->prepare($get_noofdocs_sql);
$get_noofdocs_data->execute();
$get_noofdocs_data->setFetchMode(PDO::FETCH_ASSOC);
while ($result1 = $get_noofdocs_data->fetch(PDO::FETCH_ASSOC)) {
  $incoming_count =  $result1['total'];
}

//count incoming documents
$get_noofdocs_sql= "SELECT COUNT(`docno`) as total FROM `tbl_documents` WHERE status in ('CREATED','FORWARDED') and destination = '$department'";
$get_noofdocs_data = $con->prepare($get_noofdocs_sql);
$get_noofdocs_data->execute();
$get_noofdocs_data->setFetchMode(PDO::FETCH_ASSOC);
while ($result1 = $get_noofdocs_data->fetch(PDO::FETCH_ASSOC)) {
  $incoming_count =  $result1['total'];
}


//count incoming documents
$get_noofdocs_sql= "SELECT COUNT(`docno`) as total FROM `tbl_documents` WHERE status = 'RECEIVED' and destination = '$department'";
$get_noofdocs_data = $con->prepare($get_noofdocs_sql);
$get_noofdocs_data->execute();
$get_noofdocs_data->setFetchMode(PDO::FETCH_ASSOC);
while ($result1 = $get_noofdocs_data->fetch(PDO::FETCH_ASSOC)) {
  $received_count =  $result1['total'];
}

$get_noofdocs_sql= "SELECT COUNT(`docno`) as total FROM `tbl_documents` where origin = '$department'";
$get_noofdocs_data = $con->prepare($get_noofdocs_sql);
$get_noofdocs_data->execute();
$get_noofdocs_data->setFetchMode(PDO::FETCH_ASSOC);
while ($result1 = $get_noofdocs_data->fetch(PDO::FETCH_ASSOC)) {
  $outgoing_count =  $result1['total'];
}


// count new messages
$get_all_message_sql = "SELECT count(*) as total FROM tbl_message where receiver = $user_id and status = 'PENDING'";
$get_all_message_data = $con->prepare($get_all_message_sql);
$get_all_message_data->execute();  
while ($result1 = $get_all_message_data->fetch(PDO::FETCH_ASSOC)) {
  $message_count =  $result1['total'];
}

// //select all messages for notification
$get_all_messages_sql = "SELECT * FROM tbl_message where (receiver = $user_id or receiver = '0') and status = 'PENDING' ";
$get_all_messages_data = $con->prepare($get_all_messages_sql);
$get_all_messages_data->execute();  

// //select all messages for email
$get_all_messages1_sql = "SELECT * FROM tbl_message where receiver = $user_id or receiver ='0'";
$get_all_messages1_data = $con->prepare($get_all_messages1_sql);
$get_all_messages1_data->execute();  
 
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
   <style>
         .blinking{
            animation:blinkingText 1.2s infinite;

         }
         @keyframes blinkingText{
           0%{ color: yellow; }
           49%{ color: yellow;}
           60%{ color: transparent;}
           99%{ color: transparent;}
           100%{ color: yellow;}
         }
   </style>
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

    <form class="form-inline ml-3">
                <button class="btn btn-navbar" type="submit" data-role="scan_receive">
            <i class="fa fa-search"></i>
          </button>
        
     
    </form>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-comments-o"></i>
          <?php if ($message_count != 0) { ?>
          <span class="badge badge-danger navbar-badge"><?php echo $message_count ?> </span>
          <?php } ?>
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

         
            <!-- Message End -->
          </a>
          
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
          <img src="../dist/img/logo.png" class="img-circle elevation-2" alt="User Image">
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
              <li class="nav-item" >
                <a href="#myModal" data-toggle="modal" data-target="#myModal"  class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Routing Slip</p>
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
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              
         
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
     <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">

          <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box bg-info-gradient">
        
          <span class="info-box-icon bg-info elevation-1">   <a href="list_incoming.php"> <i class="fa fa-arrow-circle-down"></i></a></span>
          
              <div class="info-box-content">
              
                <span class="info-box-text">Incoming</span>
                <span class="info-box-number">
                <?php echo $incoming_count ?>
             
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box bg-danger-gradient">
              <span class="info-box-icon bg-danger elevation-1"> <a href="list_received.php">  <i class="fa fa-folder-open"></i></a></span>

              <div class="info-box-content">
                <span class="info-box-text">Received</span>
                <span class="info-box-number">
                <?php echo $received_count ?>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box bg-success-gradient">
              <span class="info-box-icon bg-success elevation-1"><a href="list_outgoing.php"> <i class="fa fa-arrow-circle-up"></i></a></span>

              <div class="info-box-content">
                <span class="info-box-text">Outgoing</span>
                <?php echo $outgoing_count ?>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box bg-warning-gradient">
              <span class="info-box-icon bg-warning elevation-1"> <a href="list_archived.php"> <i class="fa fa-archive"></i></a></span>

              <div class="info-box-content">
                <span class="info-box-text">Archive</span>
                 <?php echo $received_count ?>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- /.row -->
        <!-- Main row -->
       
          <!-- /.box -->
        </div>
      <!-- TO DO List -->
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
      
         
            <!-- /.card-body -->
          </div>
          <!-- /. box -->
        
            <!-- /.card-body -->
        
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-20">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Inbox</h3>

              <div class="card-tools">
                <div class="input-group input-group-sm">
                  <input type="text" class="form-control" placeholder="Search Mail">
                  <div class="input-group-append">
                    <div class="btn btn-primary">
                      <i class="fa fa-search"></i>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="mailbox-controls">
                <!-- Check all button -->
                
                <!-- /.btn-group -->
                
                <div class="float-right">
                
                  <div class="btn-group">
                    
                  </div>
                  <!-- /.btn-group -->
                </div>
                <!-- /.float-right -->
              </div>
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                  <?php while($messages_data = $get_all_messages1_data->fetch(PDO::FETCH_ASSOC)){ ?>
                  <tr>
                    <td><input type="checkbox"></td>
                    <td class="mailbox-star"><a href="#"><i class="fa fa-star text-warning"></i></a></td>
                    <td class="mailbox-name"><a href="read-mail.php?objid=<?php echo $messages_data['objid'];?>"><?php echo $messages_data['sender'];?></a></td>
                    <td class="mailbox-subject"><?php echo $messages_data['subject'];?>
                    </td>
                    <td class="mailbox-attachment"></td>
                    <td class="mailbox-date"><?php echo $messages_data['date'];?></td>
                  </tr>
                 
                  <?php } ?>
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer p-0">
              <div class="mailbox-controls">
                <!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                </div>
                <!-- /.btn-group -->
                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                <div class="float-right">
                  1-50/200
                  <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                  </div>
                  <!-- /.btn-group -->
                </div>
                <!-- /.float-right -->
              </div>
            </div>
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

    
   
    <!-- modals here -->
        <!-- modal here delete -->
        <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Print Routing Slip</h4>
              </div>
              <form method="POST" action="<?php htmlspecialchars("PHP_SELF")?>">
                <div class="modal-body">  
                  <div class="box-body">
                    <div class="form-group">
                    <label>Please enter Document Number:</label>
                    <input type="text" name="modal_docno" id="modal_docno" class="form-control" value="<?php echo
$docno; ?>" required>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                    
                  <button type="button" class="btn btn-default pull-left bg-olive" data-dismiss="modal">No</button>
                  <!-- <button type="submit" name="delete_user" class="btn btn-danger">Yes</button> -->
                  <a href= "javascript:;" onclick ="this.href='../plugins/TCPDF/User/routing.php?docno=' + document.getElementById('modal_docno').value" target="blank">
                  <input type="button" name="delete_user" class="btn btn-danger" value="Yes">
                </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->


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
  <div class="modal-header">
                <h4 class="modal-title">TRACK DOCUMENT</h4>
              </div>
          
                <div class="modal-body">  
                  <div class="box-body">
                    <div class="form-group">
                    <h6 class="modal-title">Please scan/enter barcode:</h6>
                    <input type="text" name="scan_track" id="scan_track" class="form-control">
                    </div>

                    <div class="form-group">
                    <label>Date:</label>
                    <label id="lblDate"></label>
                    </div>
                    <div class="form-group">
                    <label>Time:</label>
                    <label id="lblTime"></label>
                    </div>
                    <div class="form-group">
                    <label>Type:</label>
                    <label id="lblType"></label>
                    </div>
                    <div class="form-group">
                    <label>Particulars:</label>
                    <label id="lblParticulars"></label>
                    </div>                   
                    <div class="form-group">
                    <label>Origin:</label>
                    <label id="lblOrigin"></label>
                    </div>
                    <div class="form-group">
                    <label>Destination:</label>
                    <label id="lblDestination"></label>
                    </div>
                    <div class="form-group">
                    <label>Remarks:</label>
                    <label id="lblRemarks"></label>
                    </div>

                    <div class="form-group">
                    <h5 class="blinking"  id="lblMessage"> </h5>
                    </div>

                  </div>
                </div>
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
<!-- <script src="../dist/js/demo.js"></script> -->
<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.js"></script>
<script src="../plugins/datatables/dataTables.bootstrap4.js"></script>

<script>
$('#users').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true,
      'autoHeight'  : true
    })
    // $(document).on('click', 'button[data-role=routing_slip]', function(event){
    //   event.preventDefault();

    //   // var user_id = ($(this).data('id'));

    //   // $('#user_id').val(user_id);
    //   $('#routing-slip_Modal').modal('toggle');

    // })

  
    $('#scan_track').on('change',function(){
  
  // function receive(){
             var docno = document.getElementById("scan_track").value;
           
            //  alert (docno);
         
            $.ajax({
              type:'POST',
              data:{docno:docno},
              url:'scan_track.php',
               success:function(data){
                var result = $.parseJSON(data);
                // alert(result.type)
                 document.getElementById('lblDate').innerHTML = result.date;
                 document.getElementById('lblTime').innerHTML = result.time;
                 document.getElementById('lblType').innerHTML = result.type;
                 document.getElementById('lblParticulars').innerHTML = result.particulars;
                 document.getElementById('lblOrigin').innerHTML = result.origin;
                 document.getElementById('lblDestination').innerHTML = result.destination;
                 document.getElementById('lblRemarks').innerHTML = result.remarks;
                 document.getElementById('lblMessage').innerHTML = result.message;

               }
            
                });   
              
                document.getElementById('scan_track').focus();
                document.getElementById('scan_track').select();
               
                //
              
              
    });
          
              
  

        
                     
 </script>

</body>
</html>
