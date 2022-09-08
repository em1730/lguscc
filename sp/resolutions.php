 <?php include 'includes/session.php'; ?>
 <?php include 'includes/header.php'; ?>
 <?php include 'delete_resolution.php'; ?>
 
 <body class="hold-transition sidebar-mini">
 <div class="wrapper">

 <!-- sidebar activity -->
 <?php
$sb_dashboard = "";
$sb_manage_records ="menu-open";
$sb_ordinances = "";
$sb_resolutions = "active";
$sb_main_navigation = "";
$sb_sp_members = "";
$sb_committees = "";
$sb_account_settings = "";
$sb_my_profile = "";
?>

 <?php include 'includes/navbar.php'; ?>
 <?php include 'includes/sidebar.php'; ?>



   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">

     <!-- Content Header (Page header) -->
     <div class="content-header">
       <div class="container-fluid">
         <div class="row mb-2">
           <div class="col-sm-6">
            <h1 class="m-0 text-dark">Resolutions</h1>
           </div>
           <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             </ol>
           </div>
         </div>
       </div>
     </div>
     <!-- Content Header End -->

    <!-- Main content -->
    <section class="content animationIN">

       <div class="row animationOUT">
           <div class="col-md-2">

             <div class="card card-outline card-secondary">
               <div class="card-header">
                 <h3 class="card-title">Options</h3>
                   <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-toggle="collapse" data-target="#btngrp"><i class="fa fa-minus"></i></button>
                      </button>
                   </div>
               </div>
               <div id="btngrp" class="collapse show btn-group-vertical">
                 <a role="button" href="add_resolution" class="btnOUT btn btn-info"><i class="fa fa-plus"></i> Add Resolution</a>
                 <a role="button" href="../plugins/TCPDF/User/resolution" class="btn btn-info" target="blank"><i class="fa fa-envelope-o"></i> Generate PDF</a>
               </div>
             </div>
           </div>
        
           <div class="col-md-10">      
            <div class="card card-outline card-primary">
            <div class="card-header with-border">
              <h3 class="card-title">List of Resolutions</h3>
            </div>

            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="get" action="<?php htmlspecialchars("PHP_SELF"); ?>">
              <div class="card-body">
                <table id="maintable" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Resolution Number</th>
                      <!-- <th>Middlename</th>
                      <th>Lastname</th> -->
                      <th>Title</th>
                      <th>Date Approved</th>
                      <th>Author</th>
                      <th width="100">Options</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php while ($resolutions_data = $get_all_resolutions_data-> fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <td><?php echo $resolutions_data['ResolutionNumber'] ?></td>
                       
                        <td><?php echo $resolutions_data['resolutionTitle']; ?></td>
                        <td><?php echo $resolutions_data['DateApprovedLCE']; ?></td>
                        <td><?php echo $resolutions_data['Author']; ?></td>
                        <td><?php if(empty($resolutions_data['Filenames'])){ 
                                    $btnhidden="hidden";
                                    $btnhidden2="";
                                  }else{
                                    $btnhidden = "";
                                    $btnhidden2 = "hidden";
                                   } 
                                   ?>
                          <a class="btn btn-outline-success btn-sm" href="update_resolutions.php?resno=<?php echo $resolutions_data['ResolutionNumber']; ?>" data-toggle="tooltip" data-placement="top" title="Update Resolution"><i class="fa fa-pencil"></i></a>
                          <span <?php echo $btnhidden2 ?> style='opacity:0.5'class='btn btn-outline-warning btn-sm' data-toggle='popover' title='Warning!' data-content='no pdf uploaded'><i class='icon fa fa-search'></i></span>
                          <a <?php echo $btnhidden ?> class="btn btn-outline-success btn-sm" href="viewpdf.php?resno=<?php echo $resolutions_data['ResolutionNumber']; ?>" data-toggle="tooltip" data-placement="top" title="View Scanned Resolution"><i class="fa fa-search"></i></a>
                          <button <?php echo $disablebutton;?> class="btn btn-outline-danger btn-sm" data-role="confirm_delete" data-id="<?php echo $resolutions_data["ResolutionNumber"]; ?>" data-toggle="tooltip" data-placement="top" title="Delete Resolution"><i class="fa fa-trash-o"></i></button>
                        </td>
                      </tr>
                      <div class="form-group">
                
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <!-- /.box-body -->
            </form>
           </div>
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-1"></div>
       </div>

    </section>
    <!-- /.content -->

       <!-- modals here -->
        <!-- modal here delete -->
        <div class="modal fade" id="deleteresolution_Modal" role="dialog" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Confirm Delete</h4>
              </div>
              <form method="POST" action="<?php htmlspecialchars("PHP_SELF")?>">
                <div class="modal-body">  
                  <div class="box-body">
                    <div class="form-group">
                    <label>Delete Record?</label>
                    <input readonly="true" type="text" name="user_id" id="user_id" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">

                  <button type="button" class="btn btn-default pull-left bg-olive" data-dismiss="modal">No</button>
                  <!-- <button type="submit" name="delete_user" class="btn btn-danger">Yes</button> -->
                  <input type="submit" name="delete_resolution" class="btn btn-danger" value="Yes">
                </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
         </div>
        <!-- /.modal -->
    


    </div> 
   <!-- Content-Wrapper End -->


 <?php include 'includes/footer.php'; ?>
 </div>
 <!-- Wrapper End -->

 <?php include 'includes/scripts.php'; ?>

 <script>
$(document).ready(function(){
  $('[data-toggle="popover"]').popover();   
});
</script>

 <script>
   $(document).on('click', 'button[data-role=confirm_delete]', function(event){
      event.preventDefault();

      var user_id = ($(this).data('id'));

      $('#user_id').val(user_id);
      $('#deleteresolution_Modal').modal('toggle');

   })
 </script>

</body>
</html>
