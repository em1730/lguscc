<?php

  session_start();

  $table_success = $table_error =  '';
  $first_name = $middle_ename = $last_name = $email = $contact_number = $user_name = $user_pass = '';
  $alert_msg = $table_preview_success = $hidden_data_success = $table_preview_error =   '';



  $btnStatus = "disabled";

  if (!isset($_SESSION['id'])) {
    header('location:../index.php'); 
  }

  
  $user_id = $_SESSION['id'];

  include('../config/db_config.php');
  include('import_data_now.php');
  //get session data
  $get_user_sql = "SELECT * FROM tbl_users WHERE user_id = :id";
  $get_user_data = $con->prepare($get_user_sql);
  $get_user_data->execute([':id'=>$user_id]);
  while ($result = $get_user_data->fetch(PDO::FETCH_ASSOC)) {

    $db_user_name = $result['username'];
    $db_first_name = $result['first_name'];
    $db_middle_name = $result['middle_name'];
    $db_last_name = $result['last_name'];
    $db_email_ad = $result['email'];
    $db_contact_number = $result['contact_number'];
      
  }



?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <!-- Custom CSS -->
  <link rel="stylesheet" href="../dist/css/custom.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
  <!-- Pace style -->
  <link rel="stylesheet" href="../bower_components/pace/pace.css">


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b>LTE</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="" class="dropdown-toggle" data-toggle="dropdown">
              <span class="" style="font-size: 2rem;"><i class="fa fa-user"></i></span>

              <span class="hidden-xs">Hello <?php echo $db_user_name;?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="../dist/img/no-photo-icon.png"  class="img-rounded">
                <p>
                  I am Sheena
                  <small>Member since Nov. 2012</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="profile" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                    <a href="logout.php">
                      <input type="submit" class="btn btn-default btn-flat" name="signout" id="signout" value="Sign Out">
                    </a>
                </div>
              </li>
            </ul>
          </li>

          <!-- </form> -->

        </ul>
      </div>

    </nav>
  </header>

  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <!-- <img src="../dist/img/ken.png" class="img-circle" alt="User Image"> -->
          <img src="../dist/img/no-photo-icon.png"  class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Jhon C. Doe</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">ACCOUNT SETTINGS</li>
        <li class="">
          <a href="index">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="">
          <a href="profile">
            <i class="fa fa-envelope"></i> <span>My profile</span>
          </a>
        </li>
        <li class="header">MAIN NAVIGATION</li>
        <li class="active">
          <a href="users">
            <i class="fa fa-envelope"></i> <span>Manage Users</span>
          </a>
        </li>
        <li class="">
          <a href="send_email">
            <i class="fa fa-envelope"></i> <span>Send Email</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Import Users
        <!-- <small>Version 2.0</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="../index"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Import Users Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-body">
                <?php echo $alert_msg; ?>
                <form role="form" method="post" enctype="multipart/form-data" action="<?php htmlspecialchars("PHP_SELF");?>">
                  <div class="row">
                    <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                     <label>Upload File</label>
                    </div>
                    <div class="col-md-10">
                      <div class="form-group">
                        <input type="file" name="user_file" value="">
                        <p class="help-block">Upload .csv file only.</p>
                      </div><br>
                      <input type="submit" name="upload_document" class="btn btn-default" value="Upload">       
                    </div>
                  </div>
                <hr>
                <div class="row">
                  <div class="col-md-12">
                    <?php echo $table_preview_error; ?>
                  </div>
                  <div class="col-md-12">
                    <?php echo $table_error; ?>
                  </div>
                  <div class="col-md-12">
                    <?php echo $hidden_data_success; ?>
                  </div>
                  <div class="col-md-12">
                    <?php echo $table_preview_success; ?>
                  </div>
                  <div class="col-md-12">
                    <?php echo $table_success;?>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <input type="submit" <?php echo $btnStatus; ?> name="import" class="btn btn-primary" value="Import">
                <a href="users">
                  <input type="button" name="cancel" class="btn btn-default" value="Cancel">       
                </a>
              </div>
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

<!-- jQuery 3 -->
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- PACE -->
<script src="../bower_components/pace/pace.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>

<script type="text/javascript">

  $(document).ready(function() {

    $(document).ajaxStart(function () {
      Pace.restart()
    })  

  });


</script>


</body>
</html>