 <?php include 'includes/session.php'; ?>
 <?php include 'includes/header.php'; ?>

<body class="hold-transition sidebar-mini">
 <div class="wrapper">

<!-- sidebar activity -->
<?php
$sb_dashboard = "active";
$sb_manage_records ="";
$sb_ordinances = "";
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
            <h1 class="m-0 text-dark">Dashboard</h1>
           </div>
         </div>
       </div>
     </div>
     <!-- Content Header End -->

     <!-- Main content  -->
     <div class="container-fluid animationOUT">

       <!-- Info boxes -->
       <div class="row" id="dashboard">
        
         <!-- /.col -->
         <div class="col-12 col-sm-6 col-md-3">
           <div class="animationIN info-box bg-info-gradient">

            <a href="ordinances.php" class="btnOUT info-box-icon bg-info elevation-1"><span ><i class="fa fa-file"></i></span></a>
              <div class="info-box-content">
                <span class="info-box-text">Ordinances</span>
                <span class="info-box-number">
                  <?php echo $get_all_ordinances_data->rowCount()?>
                </span>
              </div>
           </div>
         </div>

         <!-- /.col -->
         <div class="col-12 col-sm-6 col-md-3">
           <div class="animationIN info-box bg-danger-gradient">
          
            <a href="resolutions.php" class="btnOUT info-box-icon bg-danger elevation-1"><span ><i class="fa fa-file-text"></i></span></a>

              <div class="info-box-content">
                <span class="info-box-text">Resolutions</span>
                <span class="info-box-number">
                  <?php echo $get_all_resolutions_data->rowCount()?>
                </span>
              </div>
           </div>
         </div>
        
         <!-- fix for small devices only -->
         <div class="clearfix hidden-md-up"></div>

         <!-- /.col -->
         <div class="col-12 col-sm-6 col-md-3">
           <div class="animationIN info-box bg-success-gradient">
          
            <a href="sp_member.php" class="btnOUT info-box-icon bg-success elevation-1"><span ><i class="fa fa-users"></i></span></a>

              <div class="info-box-content">
                <span class="info-box-text">SP Members</span>
                <span class="info-box-number">
                  <?php echo $get_all_spmembers_data->rowCount()?>
                </span>
              </div>
           </div>
         </div>

         <!-- /.col -->
         <div class="col-12 col-sm-6 col-md-3">
           <div class="animationIN info-box bg-warning-gradient">
          
            <a href="committee.php" class="btnOUT info-box-icon bg-warning elevation-1"><span ><i class="fa fa-address-card"></i></span></a>

              <div class="info-box-content">
                <span class="info-box-text">Committees</span>
                <span class="info-box-number">
                  <?php echo $get_all_committee_data->rowCount()?>
                </span>
              </div>
           </div>
         </div>
       </div>


       <!--------------------------------------------------------- Lower Content ------------------------------------------>
         <div class="row">
         
         <div class="col">
           <ul class="animationLFT nav nav-pills">

                 <div class="info-box bg-orange-gradient" data-toggle="tooltip" data-placement="top" title="DASHBOARD">
                    <a role="button"class="info-box-icon bg-orange elevation-1" id="btndashboard"><span ><i class="fa fa-th"></i></span></a>
                 </div>
                       
                 <div class="info-box bg-orange-gradient" data-toggle="tooltip" data-placement="top" title="NOTE">
                    <a role="button"class="info-box-icon bg-orange elevation-1" id="btnnote"><span ><i class="fa fa-book"></i></span></a>
                 </div>
              
                 <div class="info-box bg-white-gradient"  data-toggle="tooltip" data-placement="top" title="QUICK SEARCH">
                    <a role="button"class="info-box-icon bg-orange elevation-1" id="btnquicksearch"><span ><i class="fa fa-search"></i></span></a>
                 </div>
           </ul>
         </div>
        
         </div>
       
             <!-- main card body -->
             <div class="card-body">

                 <!----------------------------------------------------------- Quick Search Panel ------------------------------------------>
                 <div class="collapse" id="quicksearch">
                  <div class="card card-body card-outline card-secondary">
                   <form role="form" method="get" action="<?php htmlspecialchars("PHP_SELF"); ?>">
                     <table id="quicksearchtable" class="table table-bordered table-striped">
                       <thead>
                         <tr>
                          <th width="100">Date Added</th>
                          <th width="250">Ordinances/Resolutions</th>
                          <th>Title</th>
                          <th width="25">View</th>
                         </tr>
                       </thead>
                       <tbody>
                         <?php while ($orres_data = $get_all_orres_data-> fetch(PDO::FETCH_ASSOC)) { ?>
                         <tr>
                         <td><?php echo $orres_data['DateAdded']; ?></td>
                         <td><?php echo $orres_data['OrdinanceNumber']; ?></td>
                         <td><?php echo $orres_data['OrdinanceTitle']; ?></td>
                         <td><?php if(empty($orres_data['Filenames'])){ 
                                    $btnhidden="hidden";
                                    $btnhidden2="";
                                  }else{
                                    $btnhidden = "";
                                    $btnhidden2 = "hidden";
                                   } 
                                   ?>
                                   <span <?php echo $btnhidden2 ?> style='opacity:0.5'class='btn btn-outline-info btn-sm' data-toggle='popover' title='Warning!' data-content='no pdf uploaded'><i class='icon fa fa-eye'></i></span>
                                   <a <?php echo $btnhidden ?> class="btn btn-info btn-sm" href="viewpdforres.php?orresno=<?php echo $orres_data['OrdinanceNumber']; ?>" data-toggle="tooltip" data-placement="top" title="View Scanned Document"><i class="fa fa-eye"></i></a>
                         </td> 
                         </tr>          
                         <?php } ?>
                       </tbody>
                     </table>
                   </form>
                  </div> <!-- card body end -->
                 </div> <!-- quick search end -->

                 <!------------------------------------------- Note Panel --------------------------------------------------------------->
                 <div class="collapse" id="note">
                 <div class="card card-body card-outline card-secondary">
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

                     <ul class="timeline timeline-inverse">

                     <?php
                     $notes = $con->query("SELECT notes.user_id, notes.noteid, notes.title, notes.content, notes.date
                     FROM notes JOIN tbl_users ON notes.user_id = tbl_users.user_id
                     WHERE notes.user_id = $user_id")->fetchall(PDO::FETCH_ASSOC);
                     foreach($notes as $row):?>

                       <li class="time-label">
                         <span class="bg-danger">
                           <?php echo $row['date'];?>
                         </span>
                       </li>
                       <li>
                         <i class="fa fa-warning bg-primary"></i>

                         <div class="timeline-item">

                          <?php
                          $datetime1 = new DateTime($row["date"]);
                          $datetime2 = new DateTime(date("Y/m/d"));
                          $interval = $datetime1->diff($datetime2);
                          ?>
                          

                           <span class="time"><i class="fa fa-clock-o"></i> <?php echo $interval->format('%a'); ?> days left</span>

                           <h3 class="timeline-header"><?php echo $row['title'];?> </h3>

                          <div class="timeline-body">
                          <?php echo $row['content'];?>
                           </div>
                           <div class="timeline-footer">
                           <div class="pull-right">
                            <a href="#" data-id="<?php echo $row["noteid"]; ?>" class="btn btn-success btn-sm edit"><i class='fa fa-pencil'></i></a>
                            <a href="#" data-id="<?php echo $row["noteid"]; ?>" class="btn btn-danger btn-sm delete"><i class='fa fa-trash-o'></i></a>
                           </div>
                           </div>
                         </div>
                       </li>

                       <?php endforeach; ?>

                       <li>
                       <button class='btn btn-warning add btn-xs' data-toggle="modal" href="#addnote"><i class='fa fa-plus'></i></button></i>
                       </li>
                     </ul>
                  </div> <!-- card-body end -->
                 </div> <!-- note end -->

             </div> <!-- main-card-body end -->
            
     </div>
     <!-- Main Content End --> 

   </div> 
   <!-- Content-Wrapper End -->


<!--------------------------- Modals -------------------------->

       <!-- Add -->
<div class="modal fade" id="addnote">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="card-header card-outline card-warning">
            	<h4 class="card-title"><b>Add Note</b></h4>
          	</div>
          	<div class="card-body">
            	<form class="form-horizontal" method="POST" action="insert_note.php">

              <div class="row">
                 <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Date</label>
                 </div>
                 <div class="col-md-10">
                   <div class="form-group">
                     <div class="input-group date mb-3" data-provide="datepicker" >
                       <div class="input-group-addon input-group-prepend">
                         <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                       </div>
                         <input type="text" class="form-control pull-right" id="datepicker" name="date_note" placeholder="Note Date" required>
                     </div>
                   </div>
                 </div>
              </div><br>

              <div class="row">
                    <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                  	<label>Title</label>
                    </div>
                  	<div class="col-md-10">
                    	<input type="text" class="form-control" id="title_note" name="title_note" placeholder="Title" required>
                  	</div>
                </div><br>

                <div class="row">
                    <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                  	<label>Content</label>
                    </div>
                  	<div class="col-md-10">
                    	<textarea type="text" class="form-control" id="content_note" name="content_note" placeholder="Remarks" required> </textarea>
                  	</div>
                </div><br>

          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-warning btn-sm" name="add"><i class="fa fa-save"></i> Save</button>
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
            	<form class="form-horizontal" method="POST" action="insert_update_note.php">
            		<input type="hidden" class="noteid" name="id">
                
              <div class="row">
                 <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Date</label>
                 </div>
                 <div class="col-md-10">
                   <div class="form-group">
                     <div class="input-group date mb-3" data-provide="datepicker" >
                       <div class="input-group-addon input-group-prepend">
                         <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                       </div>
                         <input type="text" class="form-control pull-right" id="edit_date" name="date_note" required>
                     </div>
                   </div>
                 </div>
              </div><br>

              <div class="row">
                    <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                  	<label>Title</label>
                    </div>
                  	<div class="col-md-10">
                    	<input type="text" class="form-control" id="edit_title" name="title_note" required>
                  	</div>
                </div><br>

                <div class="row">
                    <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                  	<label>Content</label>
                    </div>
                  	<div class="col-md-10">
                    	<textarea type="text" class="form-control" id="edit_content" name="content_note" required> </textarea>
                  	</div>
                </div><br>

          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-success btn-sm" name="edit"><i class="fa fa-check"></i> Update</button>
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
            	<form class="form-horizontal" method="POST" action="delete_note.php">
            		<input type="hidden" class="noteid" name="id">
            		<div class="text-center">
	                	<p>DELETE Note</p>
	                	<h2 id="del_title" class="bold"></h2>
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





 <?php include 'includes/footer.php'; ?>
 </div>
 <!-- Wrapper End -->

 <?php include 'includes/scripts.php'; ?>

 <!-- POP UP -->
<script>
$(document).ready(function(){
  $('[data-toggle="popover"]').popover();   
});
</script>

 <script>
$(document).ready(function(){
  $("#btndashboard").click(function(){
    $('#quicksearch').slideUp(250);
    $('#note').slideUp(250); 
    $('#dashboard').slideToggle(250);
  });
});

$(document).ready(function(){
  $("#btnnote").click(function(){
    $('#quicksearch').slideUp(250);
    $('#dashboard').slideUp(250);
    $('#note').slideToggle(250); 
  });
});

$(document).ready(function(){
  $("#btnquicksearch").click(function(){
    $('#note').slideUp(250);
    $('#dashboard').slideUp(250);
    $('#quicksearch').slideToggle(250);
  });
});

 $(function(){
  $('.edit').click(function(e){
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
    url: 'note_fetch.php',
    data: {id:id},
    dataType: 'json',
    success: function(data){
      
      $('.noteid').val(data.noteid);
      $('#noteid').val(data.noteid);
      $('#edit_title').val(data.title);
      $('#edit_content').val(data.content);
      $('#edit_date').val(data.date);
      $('#del_title').html(data.title);
      
    }
  });
};
</script>
 </body>
</html>
