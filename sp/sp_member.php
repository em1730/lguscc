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
$sb_sp_members = "active";
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
       <h1 class="m-0 text-dark">SP Members</h1>
      </div>
      <div class="col-sm-6">
       <ol class="breadcrumb float-sm-right">
     
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
           
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- Content Header End -->

    <!-- Main content -->
 <section class="content">
         <div class="col-md-2">
             <div class="card card-secondary">
                 <div class="btn-group-vertical">
                     <!-- <button type="button" class="btn btn-info" ><a href="add_sp_member" style="color:white"><i class="fa fa-plus"></i> Add SP Member</button></a> -->
                     <a href="#addnew" data-toggle="modal" class="btn btn-info btn-xs btn-flat"><i class="fa fa-plus"></i> Add SP Member</a>
                 </div>
             </div>
         </div>
      <!-- Default box -->
     <div class="card card-solid">
           
         <div class="card-body pb-0">
             <div class="row d-flex align-items-stretch">


     <?php
     $spmember = $con->query("SELECT * FROM sp_members ORDER BY fullname")->fetchall(PDO::FETCH_ASSOC);
     foreach($spmember as $row):?>

         <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
             <div class="animationZOOM card card-outline card-info">
                 <div class="card-header text-muted border-bottom-0">
                  SP Member
                 </div>
                 <div class="card-body pt-0">
                     <div class="row">
                         <div class="col-7">
                             <h2 class="lead" style="font-weight: bold; font-size: x-large;"><?php echo $row['fullname'];?></h2>
                             <p class="text-muted text-sm"><b>Committee: </b> <br><?php echo $row['committee'];?> </p>
                             <p class="text-muted text-sm"><b>Sub-Committee: </b> <br><?php echo $row['subcommittee'];?> </p>
                             <ul class="ml-4 mb-0 fa-ul text-muted">
                                 <li class="small"><span class="fa-li"><i class="fa fa-envelope"></i></span> Email: <?php echo $row['email'];?></li>
                                 <li class="small"><span class="fa-li"><i class="fa fa-phone"></i></span> Contact #: <?php echo $row['contactno'];?></li>
                             </ul>
                         </div>
                         <div class="col-5 text-center">
                             <img src="<?php echo (empty($row['location'])) ? '../dist/pic/defaultphoto.jpg' : '../dist/pic/'.$row['location'] ; ?>" alt="" class="img-thumbnail img-fluid">
                         </div>
                     </div>
                 </div>
                 <div class="card-footer">
                     <div class="text-right">
                         <!-- <a href="#" class="btn btn-sm bg-info">
                             <i class="fa fa-pencil"></i>
                         </a> -->
                         <button class="btn btn-sm edit btn-outline-secondary" data-id="<?php echo $row["objid"]; ?>">
                             <i class="fa fa-pencil"></i> Edit Profile
                         </button>
                         <button <?php echo $disablebutton;?> class="btn btn-outline-danger delete btn-sm" data-id="<?php echo $row["objid"]; ?>"><i class="fa fa-trash-o"></i></button>
                     </div>
                 </div>
             </div>
         </div>

     <?php endforeach; ?>

          <!-------------------- modals here --------------------------------->

    <!-- Add -->
    <div class="modal fade" id="addnew">
     <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
             <div class="modal-header text-muted border-bottom-0 card-outline card-info">
                  Add SP Member 
             </div>
             <div class="modal-body pt-0">
               <form class="form-horizontal" method="POST" action="insert_sp_member.php" enctype="multipart/form-data">
                     <br>
                     <div class="row">
                         <div class="col-7">
                             <h2 class="lead"><input type="text" style="font-weight: bold; font-size: x-large;" class="form-control" id="fullname" name="fullname" placeholder="Fullname" required></h2>
                             <p class="text-muted text-sm"><b>Committee: </b>                  
                                <div class="form-group">
                                  <select class="form-control select2"  style="width: 100%" multiple="" name="committee[]" >
                                  <?php while ($get_committee = $get_committee_data->fetch(PDO::FETCH_ASSOC)) { ?>
                                  <option value="<?php echo $get_committee['committee']; ?>"><?php echo $get_committee['committee']; ?></option><?php } ?>
                                  </select>
                                </div> 
                             </p>
                             <p class="text-muted text-sm"><b>Sub-Committee: </b>
                                <div class="form-group">
                                   <select class="form-control select2"  style="width: 100%" multiple="" name="subcommittee[]" >
                                    <?php while ($get_committee = $get_committee_data2->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <option value="<?php echo $get_committee['committee']; ?>"><?php echo $get_committee['committee']; ?></option><?php } ?>
                                   </select>
                                </div>
                             </p>
                             <br>
                             <ul class="ml-4 mb-0 fa-ul text-muted">

                               <div class="row">
                                  <div class="col-md-2" style="padding-top: 5px;">
                                  <li class="small"><span class="fa-li"><i class="fa fa-envelope"></i></span> Email:
                                  </div>
                                  <div class="col-md-10">
                                  <input type="email" class="form-control" id="email" name="email" placeholder="Email" required></li>
                                  </div>
                                </div><br>

                                <div class="row">
                                  <div class="col-md-2" style="padding-top: 5px;">
                                  <li class="small"><span class="fa-li"><i class="fa fa-phone"></i></span> Contact #:
                                  </div>
                                  <div class="col-md-10">
                                  <input type="number" class="form-control" id="contact_number" name="contact_number" placeholder="Contact Number" required></li>
                                  </div>
                                </div><br>
                             </ul>

                             <input type="text" style="font-weight: bold; font-size: large;" class="form-control" id="idno" name="idno"  placeholder="ID Number" required>
                            </div><!-- col-7 -->

                         <div class="col-5 text-center">
                             <img src="../dist/pic/defaultphoto.jpg" alt="" class="img-thumbnail img-fluid" id="addimage">
                             <div class="custom-file">
                             <input type="file" class="custom-file-input" name="myFiles" id="addfileToUpload" onchange = "loadImage()">
                             <label class="custom-file-label">Choose Picture</label>
                             </div>
                         </div><!-- col-5 -->
           
                     </div><!-- row -->
             </div><!-- modal-body -->
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-info btn-sm" name="add"><i class="fa fa-save"></i> Save</button>
            	</form>
          	</div><!-- modal-footer -->
        </div><!-- modal-content -->
     </div>
    </div>

   <!-- Edit -->
   <div class="modal fade" id="editspmember">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
             <div class="modal-header text-muted border-bottom-0 card-outline card-info">
                  Update SP Member 
             </div>
             <div class="modal-body pt-0">
               <form class="form-horizontal" method="POST" action="insert_update_sp_member.php" enctype="multipart/form-data">
                     <br>
                     <div class="row">
                         <div class="col-7">
                         <input type="hidden" class="objid" name="id">
                             <h2 class="lead"><input type="text" style="font-weight: bold; font-size: x-large;" class="form-control" id="edit_fullname" name="fullname" placeholder="Fullname" required></h2>
                             <p class="text-muted text-sm"><b>Committee: </b>                  
                                <div class="form-group">
                                  <select class="form-control select2"  style="width: 100%" multiple="" name="committee[]" id="edit_committee" >
                                        <?php while ($get_committee = $get_committee_data3->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <option value="<?php echo $get_committee['committee']; ?>"><?php echo $get_committee['committee']; ?></option>
                                        <?php } ?>
                                  </select>
                                </div> 
                             </p>
                             <p class="text-muted text-sm"><b>Sub-Committee: </b>
                                <div class="form-group">
                                  <select class="form-control select2"  style="width: 100%" multiple="" name="subcommittee[]" id="edit_subcommittee" >
                                        <?php while ($get_committee = $get_committee_data4->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <option value="<?php echo $get_committee['committee']; ?>"><?php echo $get_committee['committee']; ?></option>
                                        <?php } ?>
                                  </select>
                                </div>
                             </p>
                             <br>
                             <ul class="ml-4 mb-0 fa-ul text-muted">

                               <div class="row">
                                  <div class="col-md-2" style="padding-top: 5px;">
                                  <li class="small"><span class="fa-li"><i class="fa fa-envelope"></i></span> Email:
                                  </div>
                                  <div class="col-md-10">
                                  <input type="email" class="form-control" id="edit_email" name="email" placeholder="Email" required></li>
                                  </div>
                                </div><br>

                                <div class="row">
                                  <div class="col-md-2" style="padding-top: 5px;">
                                  <li class="small"><span class="fa-li"><i class="fa fa-phone"></i></span> Contact #:
                                  </div>
                                  <div class="col-md-10">
                                  <input type="number" class="form-control" id="edit_contactno" name="contact_number" placeholder="Contact Number" required></li>
                                  </div>
                                </div><br>
                             </ul>

                             <input type="text" style="font-weight: bold; font-size: large;" class="form-control objid" id="idno" name="idno"  placeholder="ID Number" required>
                            </div><!-- col-7 -->

                         <div class="col-5 text-center">
                             <img src="../dist/pic/defaultphoto.jpg" alt="" class="img-thumbnail img-fluid edit_location" id="editimage">
                             <div class="custom-file">
                             <input type="file" class="custom-file-input" name="myFiles" id="editfileToUpload" onchange = "loadImage2()">
                             <label class="custom-file-label">Choose Picture</label>
                             </div>
                         </div><!-- col-5 -->
           
                     </div><!-- row -->
             </div><!-- modal-body -->
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-info btn-sm" name="update"><i class="fa fa-save"></i> Update</button>
            	</form>
          	</div><!-- modal-footer -->
        </div><!-- modal-content -->
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
            	<form class="form-horizontal" method="POST" action="delete_spmember.php">
            		<input type="hidden" class="objid" name="id">
            		<div class="text-center">
	                	<p>DELETE SP Member</p>
	                	<h2 id="del_fullname" class="bold"></h2>
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



             </div>
         </div>
        <!-- /.card-body -->
 
     </div>
      <!-- /.card -->

 </section>
                <!-- /.content -->
 </div> 
   <!-- Content-Wrapper End -->

 <?php include 'includes/footer.php'; ?>
 </div>
 <!-- Wrapper End -->

 <?php include 'includes/scripts.php'; ?>

 <script>
 $(function(){

  $(document).on('click', '.edit', function(e){
    e.preventDefault();
    $('#editspmember').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.delete', function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });
  
});

function getRow(id){

  $.ajax({
    
    type: 'POST',
    url: 'sp_member_fetch.php',
    data: {id:id},
    dataType: 'json',
    success: function(data){
      
      $('.objid').val(data.objid);
      $('#objid').val(data.objid);
      $('#edit_fullname').val(data.fullname);
      $('#edit_contactno').val(data.contactno);
      $('#edit_email').val(data.email);
      $('#edit_committee').val(data.committee).change();
      $('#edit_subcommittee').val(data.subcommittee).change();
      $('#del_fullname').html(data.fullname);
      $('.edit_location').attr('src',data.location);
    }
  });
};

 </script>
<script>
function loadImage(){
    var input = document.getElementById("addfileToUpload");
var fReader = new FileReader();
fReader.readAsDataURL(input.files[0]);
fReader.onloadend = function(event){
    var img = document.getElementById("addimage");
    img.src = event.target.result;
}
}
</script> 
<script>
function loadImage2(){
    var input = document.getElementById("editfileToUpload");
var fReader = new FileReader();
fReader.readAsDataURL(input.files[0]);
fReader.onloadend = function(event){
    var img = document.getElementById("editimage");
    img.src = event.target.result;
}
}
</script> 

</body>
</html>
 