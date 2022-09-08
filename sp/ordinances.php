<?php include 'includes/session.php'; ?>
 <?php include 'includes/header.php'; ?>
 <?php include 'delete_ordinance.php'; ?>

<body class="hold-transition sidebar-mini">
 <div class="wrapper">

 <!-- sidebar activity -->
 <?php
$sb_dashboard = "";
$sb_manage_records ="menu-open";
$sb_ordinances = "active";
$sb_resolutions = "";
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
       <h1 class="m-0 text-dark">Ordinances</h1>
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
  
       <!-- <div class="card card-secondary">
         <div class="card-header">
           <h3 class="card-title">Folders</h3>
         </div>
         <div class="btn-group-vertical">
            <button type="button" class="btn btn-default" href="../plugins/TCPDF/User/ordinance" target="blank"><i class="fa fa-envelope-o"></i> Generate PDF</button>
            <button type="button" class="btn btn-default" href="../bower_components/PHPExcel/Examples/blank"><i class="fa fa-envelope-o"></i> Export Data</button>
            <button type="button" class="btn btn-default" href="import_data"><i class="fa fa-file-text-o"></i> Import Data</button>
         </div>
       </div> -->
       
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
               <a role="button" href="add_ordinance" class="btnOUT btn btn-info"><i class="fa fa-plus"></i> Add Ordinance</a>
               <a role="button" href="../plugins/TCPDF/User/ordinance" target="blank" class="btn btn-info"><i class="fa fa-envelope-o"></i> Generate PDF</a>
             </div>
        </div>
        </div>

     
       <div class="col-md-10">
          <div class="card card-outline card-primary">
            <div class="card-header with-border">
              <h3 class="card-title">List of Ordinances</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="get" action="<?php htmlspecialchars("PHP_SELF"); ?>">
              <div class="card-body">
                <table id="maintable" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Ordinance Number</th>
                      <th>Title</th>
                      <th>Date Enacted</th>
                      <th>Author</th>
                      <th width="100">Options</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php while ($ordinances_data = $get_all_ordinances_data-> fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <td><?php echo ($ordinances_data['OrdinanceNumber']) ?></td>
                        <td><?php echo $ordinances_data['OrdinanceTitle']; ?></td>
                        <td><?php echo $ordinances_data['DateEnacted']; ?></td>
                        <td><?php echo $ordinances_data['Author']; ?></td> 
                        <td><?php if(empty($ordinances_data['Filenames'])){ 
                                    $btnhidden="hidden";
                                    $btnhidden2="";
                                  }else{
                                    $btnhidden = "";
                                    $btnhidden2 = "hidden";
                                   } 
                                   ?>
                          <a class="btn btn-outline-success btn-sm" href="update_ordinances.php?orno=<?php echo $ordinances_data['OrdinanceNumber']; ?>" data-toggle="tooltip" data-placement="top" title="Update Ordinance"><i class="fa fa-pencil"></i></a>  
                          <span <?php echo $btnhidden2 ?> style='opacity:0.5'class='btn btn-outline-warning btn-sm' data-toggle='popover' title='Warning!' data-content='no pdf uploaded'><i class='icon fa fa-search'></i></span>
                          <a <?php echo $btnhidden ?> class="btn btn-outline-success btn-sm" href="view_pdf.php?orno=<?php echo $ordinances_data['OrdinanceNumber']; ?>" data-toggle="tooltip" data-placement="top" title="View Scanned Ordinance"><i class="fa fa-search"></i></a>
                          <button <?php echo $disablebutton;?> class="btn btn-outline-danger btn-sm" data-role="confirm_delete" data-id="<?php echo  $ordinances_data["OrdinanceNumber"]; ?>" data-toggle="tooltip" data-placement="top" title="Delete Ordinance"><i class="fa fa-trash-o"></i></button>
                          
                         
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
          <!-- /.box -->
       </div>
        </div>
        <div class="col-md-1"></div>
      </div>
     </div>

 </section>
    <!-- Main Content End -->

       <!-- modals here -->
        <!-- modal here delete -->
        <div class="modal fade" id="deleteordinance_Modal" role="dialog" data-backdrop="static" data-keyboard="false">
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
                  <input type="submit" name="delete_ordinance" class="btn btn-danger" value="Yes">
                </div>
              </form>
            </div> <!-- /.modal-content -->
          </div> <!-- /.modal-dialog -->
         </div> <!-- /.modal -->
       

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
      $('#deleteordinance_Modal').modal('toggle');

   })
 </script>

</body>
</html>


