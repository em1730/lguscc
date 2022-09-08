<?php


session_start();




if (!isset($_SESSION['id'])) {
  header('location:../index.php');
}

$user_id = $_SESSION['id'];



$alert_msg = '';
$docno = $prevyear = $pr_no = $etal =  $po_no =  $date = $type= $particulars = $origin = $destination = $obr_no = $account = $dv_no = $cheque_no =$acct_no = $payee=  $status = $date_received = $remarks = $user_name = '';
$amount  = '0.00';
$btnNew = 'disabled';
$btnPrint = 'disabled';
$btnStatus = '';
$type1 = $_GET['type'];
//$origin1 = $_GET['orig'];

$now = new DateTime();


include('../config/db_config.php');
include('insert_received_dv1.php'); //insert to tbl_ledger
include('update_settings.php');

//select user
$get_user_sql = "SELECT * FROM tbl_users WHERE user_id = :id";
$user_data = $con->prepare($get_user_sql);
$user_data->execute([':id' => $user_id]);
while ($result = $user_data->fetch(PDO::FETCH_ASSOC)) {
    $db_first_name = $result['first_name'];
    $db_middle_name = $result['middle_name'];
    $db_last_name = $result['last_name'];
    $db_email_ad = $result['email'];
    $db_contact_number = $result['contact_no'];
    $user_name = $result['username'];
    $department= $result['department'];
}

if (isset($_GET['docno'])) {
  $docno = $_GET['docno'];
//select all incoming documents
$get_all_incoming_sql = "SELECT * FROM tbl_dv where docno = :doc";// and destination = '$department'";
$get_all_incoming_data = $con->prepare($get_all_incoming_sql);
$get_all_incoming_data->execute([':doc' => $docno]);  
while ($result = $get_all_incoming_data->fetch(PDO::FETCH_ASSOC)) {
  $docno = $result['docno'];
  $date = $result['date'];
  $type = $result['type']; 
  $prevyear = $result['prevyear'];
  $obr_no = $result['obrno'];
  $account = $result['acctype'];
  $dv_no = $result['dvno'];
  $account_no = $result['acctno'];
  $cheque_no = $result['chequeno'];
  $payee = $result['payee'];
  $particulars = $result['particulars']; 
  $origin= $result['origin']; 
  $amount= $result['amount'];
  $status = $result['status'];
  $remarks = $result['remarks'];

}
}


//select all incoming documents
$get_all_doctype_sql = "SELECT * FROM document_type";
$get_all_doctype_data = $con->prepare($get_all_doctype_sql);
$get_all_doctype_data->execute();  
  



//select all departments
$get_all_dept_sql = "SELECT * FROM tbl_department";
$get_all_dept_data = $con->prepare($get_all_dept_sql);
$get_all_dept_data->execute();  

//select all payee
$get_all_payee_sql = "SELECT code, name_supplier from tbl_suppliers 
UNION
select objid, CONCAT(firstname, ' ', middlename, ' ', lastname) from tbl_joborder 
UNION
select employeeno, CONCAT(firstname, ' ', middlename, ' ', lastname) from tbl_employee
ORDER BY name_supplier";
$get_all_payee_data = $con->prepare($get_all_payee_sql);
$get_all_payee_data->execute();  

//select all account type
$get_all_account_sql = "SELECT * FROM tbl_accounts";
$get_all_account_data = $con->prepare($get_all_account_sql);
$get_all_account_data->execute();  
  
?>

  

<!DOCTYPE html>
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
     <!-- Select2 -->
  <link rel="stylesheet" href="../plugins/select2/select2.min.css">

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
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
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
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fa fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fa fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fa fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
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
              </ul>
          
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
      <div class="container-fluid">
     <div class="col-sm-6">
            <h1></h1>
          </div>
        <div class="row">
          <!-- left column -->
          <div class="col-md-12 ">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Receive Documents</h3>
              </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="<?php htmlspecialchars("PHP_SELF"); ?>">
              <div class="box-body">
              <div class="col-sm-6">
            <h1></h1>
          </div>
                <?php echo $alert_msg; ?>
                
                <!-- form document no & date -->
        <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
             
                   <label>Document No.:</label>
                  </div>
                  <div class="col-md-4">
                      <input type="text" readonly  class="form-control" id="doc_no" name="doc_no"  placeholder="Document Number" value="<?php echo
$docno; ?>" required>
                  </div>

                  <div class="col-md-1" style="text-align: right;padding-top: 5px;">
                                                <label>Date:</label>
                                            </div>
                                            <div class="col-md-4">
                                                <!-- Date -->
                                                <div class="form-group">
                                                    <!-- <label>Date:</label> -->
                                                    <div class="input-group date" data-provide="datepicker" >
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control pull-right" id="datepicker" name="date" placeholder="Date Created" value="<?php echo
$now->format('m/d/Y');; ?>">
                                                    </div>
                                                </div>
                                            </div>
                </div><br>
<!-- form document no & date -->

                <div class="row">
                                            <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                                <!-- <div class="form-group"> -->
                                                <label>Originating Office:</label>
                                            </div>
                                                                                     
                                            <div class="col-md-9">
                                                <select class="form-control select2" readonly style="width: 100%;"  id="origin_office" name="origin" value="<?php echo $creator; ?>">
                                                   <option>Please select...</option>
                                                    <?php while ($get_dept = $get_all_dept_data->fetch(PDO::FETCH_ASSOC)) { ?>

<?php
    //if $get_author naa value, check nato if equals sa $get_author1['fullname']
    //if equals, put 'selected' sa option
    $selected = ($creator == $get_dept['objid'])? 'selected':'';

?>

<option <?=$selected;?> value="<?php echo $get_dept['objid']; ?>"><?php echo $get_dept['department']; ?></option>
<?php } ?>
                                            </select>
                                        </div>
                                    </div><br>

                                   
                                        
                                      
<!-- form doctype -->
<div class="row">
                                            <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                                <!-- <div class="form-group"> -->
                                                <label>Document Type:</label>
                                            </div>
                                                                                     
                                            <div class="col-md-4">
                                                <select readonly class="form-control select2" id="select_type" style="width: 100%;" name="type" value="<?php echo
$type; ?>">
                        
                                                        <?php if ($type1 == "DV") { ?>
                                                          <option value="<?php echo 'DV'; ?>"><?php echo "Disbursement Voucher"; ?></option>
                                                             <?php } else if ($type1 == "PYL"){ ?>
                                                               <option value="<?php echo 'PYL'; ?>"><?php echo "Payroll"; ?></option>
                                                                  <?php } else if ($type1 == "DWP"){ ?>
                                                                    <option value="<?php echo 'DWP'; ?>"><?php echo "Daily Wage Payroll"; ?></option>
                                                                      <?php } else if ($type1 == "OBR"){ ?>
                                                                          <option value="<?php echo 'OBR'; ?>"><?php echo "Obligation Request"; ?></option>
                                                                            <?php } else if ($type1 == "LR") { ?>
                                                                                <option value="<?php echo 'LR'; ?>"><?php echo "Liquidation Report"; ?></option>
                                                                                <?php } else if ($type1 == "RIS") { ?>
                                                                                <option value="<?php echo 'RIS'; ?>"><?php echo "Requisition & Issue Slip"; ?></option>
                                                                                <?php } else if ($type1 == "PO") { ?>
                                                                                <option value="<?php echo 'PO'; ?>"><?php echo "Purchase Order"; ?></option>
                                                                                <?php } else if ($type1 == "PR") { ?>
                                                                                <option value="<?php echo 'PR'; ?>"><?php echo "Purchase Request"; ?></option>
                                                         <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                        <div class="form-check">           
                    &nbsp; &nbsp;<input  <?php if ($prevyear == 1) echo 'checked="checked"'; ?> type="checkbox" class="form-check-input" id="prev_year" name="prev_year" value="prevyear">
                    <label class="form-check-label" for="prev_year">Previous Year?</label>             
                    </div>    
                                                    </div>           
                                    </div><br>
                                        </div>
<!-- form doctype -->
                         <!-- for PR & PO -->
                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>PR No.:</label>
                  </div>
                  <div class="col-md-4">
                      <input type="text" <?php if ($type1 != 'PR'){?> <?php } ?>  class="form-control" id="pr_no" name="pr_number"  placeholder="PR Number" value="<?php echo
$pr_no; ?>" >
                  </div>

                  <div class="col-md-1" style="text-align: right;padding-top: 5px;">
                   <label>PO No.:</label>
                  </div>
                  <div class="col-md-4">
                      <input type="text" <?php if ($type1 != 'PO'){?>  <?php } ?>    class="form-control" id="po_no" name="po_number"  placeholder="PO Number" value="<?php echo
$po_no; ?>">
                  </div>
                </div><br>

<!-- for PR & PO -->

<!-- OBR -->

                                        <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>OBR No.:</label>
                  </div>
                  <div class="col-md-4">
                      <input type="text" readonly  class="form-control" id="obr_no" name="obr_number"  placeholder="OBR Number" value="<?php echo
$obr_no; ?>" required>
                  </div>
                </div><br>

<!-- OBR -->


<!-- Fund and DV No-->
                <div class="row">
                
                <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                                <!-- <div class="form-group"> -->
                                                <label>Fund:</label>
                                            </div>
                                                                                     
                                            <div class="col-md-4">
                                                <select  class="form-control select2" style="width: 100%;" id="select_account" name="account"  value="<?php echo $account; ?>">
                                                   <option>Please select...</option>
                                                    <?php while ($get_account = $get_all_account_data->fetch(PDO::FETCH_ASSOC)) { ?>

<?php
    //if $get_author naa value, check nato if equals sa $get_author1['fullname']
    //if equals, put 'selected' sa option
    $selected = ($account == $get_account['code'])? 'selected':'';

?>

<option <?=$selected;?> value="<?php echo $get_account['code']; ?>"><?php echo $get_account['account']; ?></option>
<?php } ?>
                                            </select>
                                        </div>

                                        <div class="col-md-1" style="text-align: right;padding-top: 5px;">
                   <label>DV No.:</label>
                  </div>
                  <div class="col-md-4">
                      <input type="text"   class="form-control" id="dv_no" name="dv_number"  placeholder="DV Number" value="<?php echo
$dv_no; ?>" >
                  </div>
                                    </div><br>

<!-- OBR -->

               
<!-- Account Number & Cheque No. -->
<div class="row">
                <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Account No.:</label>
                  </div>
                  <div class="col-md-4">
                      <input type="text" readonly  class="form-control" id="dv_no" name="acct_number"  placeholder="DV Number" value="<?php echo
$acct_no; ?>" required>
                  </div>

                  <div class="col-md-1" style="text-align: right;padding-top: 5px;">
                   <label>Cheque No.:</label>
                  </div>
                  <div class="col-md-4">
                      <input type="text" readonly  class="form-control" id="cheque_no" name="cheque_number"  placeholder="Cheque Number" value="<?php echo
$cheque_no; ?>" required>
                  </div>
                </div><br>

<!-- Account Number & Cheque No. -->

                         
<!-- For payee -->
<div class="row">
                  
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                      <!-- <div class="form-group"> -->
                        
                      <label>Payee:</label>
                  </div>
                      

<div class="col-md-7">

<select class="form-control select2" readonly required style="width: 100%;" id="payee" name="payee" value="<?php echo $payee; ?>">
      <option>Please select...</option>
              <?php while ($get_payee = $get_all_payee_data->fetch(PDO::FETCH_ASSOC)) { ?>

<?php
//if $get_author naa value, check nato if equals sa $get_author1['fullname']
//if equals, put 'selected' sa option
$selected = ($payee == $get_payee['name_supplier'])? 'selected':'';

?>

<option <?=$selected;?> value="<?php echo $get_payee['name_supplier']; ?>"><?php echo ucwords(strtolower($get_payee['name_supplier'])); ?></option>
<?php } ?>
                    </select>
                    <p>NOTE: <code>Search first the name of payee. If "No Results Found", Click the ADD Button</code>
                    <code> to register NEW payee and click REFRESH once done. Check the et Al. for multiple payees. </code>
                  </p>               
                    
                    </div>
                   
<div class="col-md-.1">
<div class="input-group input-group-sm">
<span class="input-group-append">
<button type="button"  class="btn btn-warning dropdown-toggle" data-toggle="dropdown"> ADD </button>
<ul class="dropdown-menu">
<li class="dropdown-item"><a href="add_suppliers" target="_blank">Supplier</a></li>
<li class="dropdown-item"><a href="add_joborder" target="_blank" >Job Order</a></li>
<li class="dropdown-item"><a href="add_joborder" target="_blank" >Regular Employee</a></li>
<li class="dropdown-divider"></li>
<li class="dropdown-item" id="refresh">Refresh</li>
</ul>
</span>
</div>
</div>
<div class="form-check">           
&nbsp; &nbsp;<input <?php if ($etal == 1) echo 'checked="checked"'; ?> type="checkbox" class="form-check-input" id="exampleCheck1" name="etc" value="etal">
<label class="form-check-label" for="exampleCheck1">et Al.</label>             
</div>               
          </div>

<!-- For payee -->            



                  <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Particulars:</label>
                  </div>
                  <div class="col-md-9">
                      <textarea rows="3" class="form-control" name="particulars" placeholder="Subject/Particulars"  required><?php echo
$particulars; ?></textarea>
                  </div>
                </div><br>

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Amount:</label>
                  </div>
                  <div class="col-md-4">
                      <input required type="text" class="form-control" id="amount" name="amount"  placeholder="Amount" value="<?php echo
number_format($amount,2); ?>" required>
                  </div>
                  <p>NOTE: <code>Numbers & decimal point only, do not use comma (,)</code></p>
                </div><br>

            
                                            <div class="row">
                                            <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                                <label>Date Received:</label>
                                            </div>
                                            <div class="col-md-9">
                                                <!-- Date -->
                                                <div class="form-group">
                                                    <!-- <label>Date:</label> -->
                                                    <div class="input-group date" data-provide="datepicker" >
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control pull-right" id="datepicker" name="date" placeholder="Date Created" value="<?php echo
$now->format('m/d/Y');; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div><br>

                                        <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Remarks:</label>
                  </div>
                  <div class="col-md-9">
               
                      <input type="text" required  class="form-control" name="remarks" placeholder="Remarks"  value="<?php echo
$remarks; ?>">
                  </div>
                </div><br>        
                <div class="box-footer" align="center">
                <input type="submit"  <?php echo $btnNew; ?> name="add" class="btn btn-primary" value="New">
          <input type="submit"  <?php echo $btnStatus; ?> name="insert_received" class="btn btn-primary" value="Receive">
          <a href="../plugins/TCPDF/User/routing.php?docno=<?php echo $docno;?> " target="blank">
            <input type="button" <?php echo $btnPrint; ?> name="print" class="btn btn-primary" value="Print">       
          </a>
          <a href="list_incoming">
            <input type="button" name="close" class="btn btn-default" value="close">       
          </a>
        </div>

        <div class="col-sm-6">
            <h1></h1>
          </div>

                  <div class="col-md-10">
                      <input type="hidden" readonly id="department" class="form-control" name="department" placeholder="Department" value="<?php echo
$department; ?>" required>
                  </div>
                </div><br>

                <div class="col-md-10">
                      <input type="hidden" readonly class="form-control" id = "username" name="username" placeholder="username" value="<?php echo
$user_name; ?>" required>
                  </div>
                </div><br>
             
              <!-- /.box-body -->
             
            </form>
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-1"></div>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- footer here -->
    <footer class="main-footer">
      <div class="pull-right hidden-xs">
      <b>Version</b> 1.0
      </div>
      <strong>Copyright &copy; <?php echo 2018; ?>.</strong> All rights
      reserved.
    </footer>
</div>
<!-- ./wrapper -->

   
<!
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
<!-- Select2 -->
<script src="../plugins/select2/select2.full.min.js"></script>
<!-- Page script -->

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
  </script>
        <script type="text/javascript">

            $(document).ready(function() {
                $(document).ajaxStart(function() {
                    Pace.restart()
                })


       

            });

           
   } 
                 
  });       

        </script>


        <script>

$('#refresh').on('click',function(){
 location.reload();

});

$('#prev_year').click(function(){
  var office = $('#department').val();

  if (this.checked && office =='CBO'){
   checkPrevYear();
  }else if (!this.checked && office == 'CBO'){
    checkCurrentYear();
  }
});

$('#new_obr').click(function(){
  if (this.checked){
    generateNewOBR();
  }else{
    location.reload();
  }
});


$('#select_account').on('change',function(){
  var checkBox = document.getElementById("prev_year"); 

 if (checkBox.checked == true) {
  var account = $(this).val();
  var type = $('#select_type').val();
  var office = $('#department').val();
  var dvno = $('#dv_no').val();
  var user = $('#username').val();
         
            $.ajax({
              type:'POST',
              data:{account:account, office:office, type:type, dv:dvno, user:user  },
              url:'generate_prevdv.php',
               success:function(data){
            $('#dv_no').val(data);
           }   
                });   
 }else{
  var account = $(this).val();
  var type = $('#select_type').val();
  var office = $('#department').val();
  var dvno = $('#dv_no').val();
  var user = $('#username').val();
         
            $.ajax({
              type:'POST',
              data:{account:account, office:office, type:type, dv:dvno, user:user },
              url:'generate_dv.php',
               success:function(data){
            $('#dv_no').val(data);


            } 
                 
                });    

                } 
                      });



        $('#origin_office').on('change',function(){
          var type = $('#select_type').val();
             var office = $('#orig').val();
            
    
    //    if (type=="DV"){
    //    window.open("receive_incoming_other_dv.php", '_parent');
    //  }else{
         $.ajax({
              type:'POST',
              data:{type:type, office:office},
              url:'generate_serial.php',
               success:function(data){
              // $('#doc_no').val(data); 
              $('#doc_no').val(data);
            
               
               }
            
                 
                });   
                      });

function checkYear(){
  var checkBox = document.getElementById("prev_year");
 
 if (checkBox.checked == true) {
   
  var type = $('#select_type').val();
  var docno = $('#doc_no').val();
  var office = $('#department').val();
  var obr = $('#obr_no').val();
  var dvno = $('#dv_no').val();
 // document.getElementById('obr_no').value="";
  
 

    $.ajax({
    type:'POST',
    data:{type:type,office:office,obr:obr,dv:dvno,docno:docno},
    url:'generate_prevobr.php',
    success:function(data){
      // var result = $.parseJSON(data);
     // $('#doc_no').val(result.docno);
   
      $('#obr_no').val(data);
    
    }
  
 
  });

  
                    
} else if (checkBox.checked == false)  {

  var type = $('#select_type').val();
  var docno = $('#doc_no').val();
  var office = $('#department').val();
  var obr = $('#obr_no').val();
  var dvno = $('#dv_no').val();
  
  
 

    $.ajax({
    type:'POST',
    data:{type:type,office:office,obr:obr,dv:dvno,docno:docno},
    url:'generate_obr.php',
    success:function(data){
      // var result = $.parseJSON(data);
     // $('#doc_no').val(result.docno);
   
      $('#obr_no').val(data);
     
    }
  
 
  });

  var account = $(this).val();
  var type = $('#select_type').val();
  var office = $('#department').val();
  var dvno = $('#dv_no').val();
 
         
            $.ajax({
              type:'POST',
              data:{account:account, office:office, type:type, dv:dvno },
              url:'generate_dv.php',
               success:function(data){
            $('#dv_no').val(data);


            } 
                 
                });           
                        


}
}

function checkPrevYear(){

  var type = $('#select_type').val();
  var docno = $('#doc_no').val();
  var office = $('#department').val();
  var obr = $('#obr_no').val();
  var dvno = $('#dv_no').val();
 // document.getElementById('obr_no').value="";
  
 

    $.ajax({
    type:'POST',
    data:{type:type,office:office,obr:obr,dv:dvno,docno:docno},
    url:'generate_prevobr.php',
    success:function(data){
      // var result = $.parseJSON(data);
     // $('#doc_no').val(result.docno);
   
      $('#obr_no').val(data);
      ;
    }
  });
}

function checkCurrentYear(){

var type = $('#select_type').val();
var docno = $('#doc_no').val();
var office = $('#department').val();
var obr = "";
var dvno = $('#dv_no').val();
// document.getElementById('obr_no').value="";



  $.ajax({
  type:'POST',
  data:{type:type,office:office,obr:obr,dv:dvno,docno:docno},
  url:'generate_obr.php',
  success:function(data){
    // var result = $.parseJSON(data);
   // $('#doc_no').val(result.docno);
 
    $('#obr_no').val(data);
    
  }
});
}

function generateNewOBR(){

var type = $('#select_type').val();
var docno = $('#doc_no').val();
var office = $('#department').val();
var obr = "";
var dvno = $('#dv_no').val();
// document.getElementById('obr_no').value="";



  $.ajax({
  type:'POST',
  data:{type:type,office:office,obr:obr,dv:dvno,docno:docno},
  url:'generate_newobr.php',
  success:function(data){
    // var result = $.parseJSON(data);
   // $('#doc_no').val(result.docno);
 
    $('#obr_no').val(data);
    
  }
});
}






   
                      

                     
                      
              
  
              
$(function(){
  //$('#orig').val(sessionStorage.getItem("orig"));
            var type = $('#select_type').val();
             var office = $('#orig').val();
             var department = $('#department').val();
             var obr = $('#obr_no').val();
             var docno = $('#doc_no').val();
    
    //    if (type=="DV"){
    //    window.open("receive_incoming_other_dv.php", '_parent');
    //  }else{
        //  $.ajax({
        //       type:'POST',
        //       data:{type:type, office:office},
        //       url:'generate_serial.php',
        //        success:function(data){
        //       // $('#doc_no').val(data); 
        //       $('#doc_no').val(data);
            
               
        //        }
            
                 
        //         });

       $.ajax({
    type:'POST',
    data:{type:type,office:department,obr:obr, docno:docno},
    url:'generate_obr.php',
    success:function(data){
     
      // var result = $.parseJSON(data);
     // $('#doc_no').val(result.docno);
      $('#obr_no').val(data);
  
    }
  });
  

  // var type = $('#select_type').val();
  // var office = $('#select_office').val();
  // var obr = $('#obr_no').val();

  // $.ajax({
  //   type:'POST',
  //   data:{type:type,office:office,obr:obr},
  //   url:'generate_obr.php',
  //   success:function(data){
  //     // var result = $.parseJSON(data);
  //    // $('#doc_no').val(result.docno);
  //     $('#obr_no').val(data);
    
  //   }
  // });
                //Initialize Select2 Elements
                $('.select2').select2()

                //Datemask dd/mm/yyyy
                $('#datemask').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'})
                //Datemask2 mm/dd/yyyy
                $('#datemask2').inputmask('mm/dd/yyyy', {'placeholder': 'mm/dd/yyyy'})
                //Money Euro
                $('[data-mask]').inputmask()

                //Date range picker
                $('#reservation').daterangepicker()
                //Date range picker with time picker
                $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'})
                //Date range as a button
                $('#daterange-btn').daterangepicker(
                        {
                            ranges: {
                                'Today': [moment(), moment()],
                                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                                'This Month': [moment().startOf('month'), moment().endOf('month')],
                                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                            },
                            startDate: moment().subtract(29, 'days'),
                            endDate: moment()
                        },
                function(start, end) {
                    $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
                )

                //Date picker
                $('#datepicker').datepicker({
                    autoclose: true
                })

                //iCheck for checkbox and radio inputs
                $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                    checkboxClass: 'icheckbox_minimal-blue',
                    radioClass: 'iradio_minimal-blue'
                })
                //Red color scheme for iCheck
                $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                    checkboxClass: 'icheckbox_minimal-red',
                    radioClass: 'iradio_minimal-red'
                })
                //Flat red color scheme for iCheck
                $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass: 'iradio_flat-green'
                })

                //Colorpicker
                $('.my-colorpicker1').colorpicker()
                //color picker with addon
                $('.my-colorpicker2').colorpicker()

                //Timepicker
                $('.timepicker').timepicker({
                    showInputs: false
                })
            })
        </script>

    </body>
</html>