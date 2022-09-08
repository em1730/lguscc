<?php include 'includes/session.php'; ?>
 <?php include 'includes/header.php'; ?>
 <?php include ('insert_committee.php'); ?>
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
        Add Committee
        <!-- <small>Version 2.0</small> -->
      </h1>
       
    </section>
    <!-- Main content -->
    <section class="content">

    
    <div class="row">
        <div class="col-md-2"></div>
      <div class="col-md-8">
          <div class="card card-secondary">
            <div class="card-header">
              <h1 class="card-title">Details</h1>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="<?php htmlspecialchars("PHP_SELF"); ?>">
              <div class="box-body">
                <?php echo $alert_msg; ?>
                <br>
                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Code No.</label>
                  </div>
                  <div class="col-md-9">
                      <input type="text" class="form-control" name="code" placeholder="Committee Code No." value="<?php echo
$comID; ?>" required>
                  </div>
                </div><br>
                
                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Committee</label>
                  </div>
                  <div class="col-md-9">
                      <textarea rows="5" class="form-control" name="committee" placeholder="Committee"  required><?php echo
$committee; ?></textarea>
                  </div>
                </div><br>

                <div class="row">
                                            <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                                <!-- <div class="form-group"> -->
                                                <label>Status</label>
                                            </div>
                                            <div class="col-md-9">

                                                <select class="form-control select2" style="width: 100%;" name="status" >
                                                    <option>Please select...</option>
                                                        <option value="Active">Active</option>
                                                        <option value="Inactive">Inactive</option>


<?php 
if (isset($_GET['insert_committee'])) {

        //if $get_author naa value, check nato if equals sa $get_author1['fullname']
        //if equals, put 'selected' sa option
        $selected = $status ? 'selected':'';

 ?>

    <option <?=$selected;?> value="<?php echo $get_status['status']; ?>"><?php echo $get_status['status']; ?></option>
<?php } ?>
              
                                                </select>
                                            </div>
                                        </div><br>
                                          
             <!-- /.card-body -->
             <div class="card-footer">
              <input type="submit"  <?php echo $btnNew; ?> name="add" class="btn btn-primary" value="New">
                <input type="submit"  <?php echo $btnStatus; ?> name="insert_committee" class="btn btn-primary" value="Save">
                <a href="committee.php">
                  <input type="button" name="cancel" class="btn btn-default" value="Cancel">       
                </a>
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
