 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
         
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
                 <?php echo $archived_count ?>
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
     
        