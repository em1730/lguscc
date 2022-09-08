<?php include 'includes/session.php'; ?>
 <?php include 'includes/header.php'; ?>

<body class="hold-transition sidebar-mini">
 <div class="wrapper">

 <?php include 'includes/navbar.php'; ?>
 <?php include 'includes/sidebar.php'; ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m=o text-dark">
        SP Member 
        <!-- <small>Version 2.0</small> -->
      </h1>
      </div>
      <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right text-xs">
      <li class="breadcrumb-item"><a href="index">Home</a></li>
      <li class="breadcrumb-item active">Member Profile</li>
         </ol>
         </div>
       
    </section>
    <!-- Main content -->
    <section class="content">

    
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
        <div class="card card-secondary">
            <div class="card-header with-border">
              <h3 class="card-title">Details</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->

            <form method="post" action="" enctype="multipart/form-data">
           <div class="box-body">

            
           <!-- Profile Image -->
               <div class="box-profile" align="center">
                 <img class="img-round" src="../dist/pic/<?php echo $location?>" align="center" vspace="10" width="200" height="200">
               </div>  
                                                                                 
                                                                                                        </div>
                                                                                          


            <form role="form" method="post" action="<?php htmlspecialchars("PHP_SELF"); ?>">
              <div class="card-body">
             
                
                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Employee ID No.</label>
                  </div>
                  <div class="col-md-10">
                      <input type="text" class="form-control" name="idno" placeholder="Employee ID No." value="<?php echo
$empID; ?>" disabled>
                  </div>
                </div><br>
                
                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Full Name</label>
                  </div>
                  <div class="col-md-10">
                      <input type="text" class="form-control" name="fullname" placeholder="Full Name" value="<?php echo
$fullName; ?>" disabled>
                  </div>
                </div><br>
                                
                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Email Address</label>
                  </div>
                  <div class="col-md-10">
                      <input type="email" class="form-control" name="email" placeholder="Email Address" value="<?php echo
$email; ?>" disabled>
                  </div>
                </div><br>

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Contact Number</label>
                  </div>
                  <div class="col-md-10">
                      <input type="contactno" class="form-control" name="contact_number" placeholder="Contact Number" value="<?php echo
$contact_number; ?>" disabled>
                  </div>
                </div><br>
                
                <div class="row">
                                            <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                                <!-- <div class="form-group"> -->
                                                <label>Committee</label>
                                            </div>
                                            <div class="col-md-10">

<input type="committee" class="form-control" name="committee" placeholder="Committee" value="<?php echo
$committee; ?>" disabled>
 			</div>
                </div><br>						
</select>
           
      <div class="box-footer">
             <a  href="sp_member">
               <input type="button" name="back" class="btn btn-default" value="Back"> </a>     
             </div>
            </form>
          </div>
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-1"></div>
      </div>
      </select>
                                            </div>
                                        </div><br>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <?php include 'includes/footer.php'; ?>
 
 </div>
 <!-- Wrapper End -->

 <?php include 'includes/scripts.php'; ?>

 
}
</script> 

</body>
</html>
