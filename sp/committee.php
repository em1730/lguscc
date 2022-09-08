<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition sidebar-mini">
 <div class="wrapper">

 <!-- sidebar activity -->
 <?php
$sb_dashboard = "";
$sb_manage_records ="";
$sb_ordinances = "";
$sb_resolutions = "";
$sb_main_navigation = "menu-open";
$sb_sp_members = "";
$sb_committees = "active";
$sb_account_settings = "";
$sb_my_profile = "";
?> 

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
        Committee
        <!-- <small>Version 2.0</small> -->
      </h1>
      </div>      
    </section>

    <!-- Main content -->
    <section class="content">

 
         <div class="row">

           <div class="col-md-2">

            <div class="card card-outline card-secondary">
              <div class="card-header">
                <h3 class="card-title">Options</h3>
                <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-toggle="collapse" data-target="#btngrp"><i class="fa fa-minus"></i></button>
                      </button>
                   </div>
              </div>
              <div id="btngrp" class=" collapse show btn-group-vertical">
                <a href="#addnew" data-toggle="modal" class="btn btn-info btn-xs btn-flat"><i class="fa fa-plus"></i> Add Committee</a>
              </div>
            </div>
           </div>


         <div class="col-md-8">
           <div class="animationIN card card-header card-outline card-info">
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" method="get" action="<?php htmlspecialchars("PHP_SELF");?>">
              <div class="card-body">
                 <?php
                     if(isset($_SESSION['error'])){
                     echo "
                       <div class='alert alert-danger alert-dismissible'>
                         <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                           ".$_SESSION['error']."
                       </div>
                       ";
                     unset($_SESSION['error']);
                     }
                     if(isset($_SESSION['success'])){
                      echo "
                       <div class='alert alert-success alert-dismissible'>
                         <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                           ".$_SESSION['success']."
                       </div>
                       ";
                      unset($_SESSION['success']);
                   }
                 ?>

                <table id="maintable" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th width="50">Code No.</th>
                      <!-- <th>Middlename</th>
                      <th>Lastname</th> -->
                      <th>Committee</th>
                      <th width="75">Status</th>
                      <th width="50">Option</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php while($committee_data = $get_all_committee_data->fetch(PDO::FETCH_ASSOC)){ ?>
                    <tr>
                        <td><?php echo $committee_data['objid'];?></td>
                        <td><?php echo $committee_data['committee'];?></td>
                        <td><?php echo $committee_data['status'];?></td>
                        <td>
                           <button class='btn btn-outline-success edit btn-sm' data-id="<?php echo $committee_data["objid"]; ?>" data-toggle="tooltip" data-placement="top" title="Update Committee"><i class='fa fa-pencil'></i></button>       
                           <button <?php echo $disablebutton;?> class="btn btn-outline-danger delete btn-sm" data-id="<?php echo $committee_data["objid"]; ?>" data-placement="top" title="Delete Committee"><i class="fa fa-trash-o"></i></button>
                        </td>   
                      </tr>
     
                      <div class="form-group">      
           
               
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </form>
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-1"></div>
      </div>

    </section>
    <!-- /.content -->


 <!-------------------- modals here --------------------------------->

    <!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="card-header card-outline card-info">
            	<h4 class="card-title"><b>Add Committee</b></h4>
          	</div>
          	<div class="card-body">
            	<form class="form-horizontal" method="POST" action="insert_committee.php">

              <div class="row">
                    <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                  	<label>Code No.</label>
                    </div>
                  	<div class="col-md-10">
                    	<input type="text" class="form-control" id="codeno" name="codeno" required>
                  	</div>
                </div><br>
                    
          		  <div class="row">
                    <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                  	<label>Committee</label>
                    </div>
                  	<div class="col-md-10">
                    	<input type="text" class="form-control" id="committee" name="committee" required>
                  	</div>
                </div><br>

                <div class="row">
                    <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Status</label>
                    </div>
                    <div class="col-md-10">
                    <select class="form-control select2" style="width: 100%;" name="status">
                       <option>Select..</option>
                       <option value="Active">Active</option>
                       <option value="Inactive">Inactive</option>
                    </select>
                    </div>
                </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-info btn-sm" name="add"><i class="fa fa-save"></i> Save</button>
            	</form>
          	</div>
        </div>
    </div>
</div>
        <!-- Delete -->
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header card-outline card-danger">
            	<h4 class="modal-title"><b>Deleting...</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="delete_committee.php">
            		<input type="hidden" class="objid" name="id">
            		<div class="text-center">
	                	<p>DELETE Committee</p>
	                	<h2 id="del_committee" class="bold"></h2>
	            	</div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-danger btn-sm" name="delete"><i class="fa fa-trash"></i> Delete</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

         <!-- Edit -->
<div class="modal fade" id="edit" role="dialog" data-backdrop="static" data-keyboard="false"  >
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header card-outline card-success">
            	<h4 class="modal-title"><b>Update Committee</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="insert_update_committee.php">
            		<input type="hidden" class="objid" name="id">
                
                <div class="row">
                    <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                       <label>Committee</label>
                    </div>
                    <div class="col-md-10">
                       <input type="text" class="form-control" id="edit_committee" name="committee">
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Status</label>
                    </div>
                    <div class="col-md-10">
                    <select class="form-control" style="width: 100%;" name="status" >
                       <option selected id="edit_status"></option>
                       <option value="Active">Active</option>
                       <option value="Inactive">Inactive</option>

                    </select>
                    </div>
                </div>

          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal" ><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-success btn-sm" name="edit"><i class="fa fa-check"></i> Update</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

  </div>
  <?php include 'includes/footer.php'; ?>
 
 </div>
 <!-- Wrapper End -->

 <?php include 'includes/scripts.php'; ?>

 <script>
 $(function(){
  $(document).on('click', '.edit', function(e) {
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $('.delete').click(function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });
  
});

function getRow(id){
  
  $.ajax({
    
    type: 'POST',
    url: 'committee_fetch.php',
    data: {id:id},
    dataType: 'json',
    success: function(data){
      
      $('.objid').val(data.objid);
      $('#objid').val(data.objid);
      $('#edit_committee').val(data.committee);
      $('#edit_status').val(data.status).html(data.status);
      $('#del_committee').html(data.committee);
      
    }
  });
};

 </script>

</body>
</html>
