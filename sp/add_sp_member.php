<?php include 'includes/session.php'; ?>
 <?php include 'includes/header.php'; ?>
<?php include 'insert_sp_member.php'; ?>

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
   <section class="content-header">
     <div class="container-fluid">
       <div class="row mb-2">
         <div class="col-sm-6">
         <h1 class="m=o text-dark">
         Add SP Member
         <!-- <small>Version 2.0</small> -->
         </h1>
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

           <form role="form" method="post" action="<?php htmlspecialchars("PHP_SELF"); ?>" enctype="multipart/form-data">
             <div class="card-body">

               <div align="center">
                 <?php echo $alert_msg; ?>
               </div>

               <div class = "register-box-body" style = "width:300px;margin:auto;" >
                 <img src="../dist/img/no-photo-icon.png" align="center" class="elevation-2" style="margin-top:20px;margin-left:20px;margin-bottom:20px;width:200px;height:200px";  id="image" >
               </div>      
               <div class="col-md-2" style = "width:300px;margin:auto;">
                 <input type ="file" name="myFiles" id="fileToUpload" onchange = "loadImage()" value="<?php echo $pictures;?>">
               </div><br>
            
               <div class="row">
                 <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Employee ID No.</label>
                 </div>
                 <div class="col-md-10">
                   <input type="text" class="form-control" name="idno" placeholder="Employee ID No." value="<?php echo $empID; ?>" required>
                 </div>
               </div><br>
                
               <div class="row">
                 <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Full Name</label>
                 </div>
                 <div class="col-md-10">
                   <input type="text" class="form-control" name="fullname" placeholder="Full Name" value="<?php echo $fullName; ?>" required>
                 </div>
               </div><br>
                                
               <div class="row">
                 <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Email Address</label>
                  </div>
                 <div class="col-md-10">
                   <input type="email" class="form-control" name="email" placeholder="Email Address" value="<?php echo $email; ?>">
                 </div>
               </div><br>

               <div class="row">
                 <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Contact Number</label>
                 </div>
                 <div class="col-md-10">
                      <input type="number" class="form-control" name="contact_number" placeholder="Contact Number" value="<?php echo $contactno; ?>" required>
                 </div>
               </div><br>

               <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                     <label>Committee</label>
                  </div>
                  <div class="col-md-10">
                  <div class="form-group">
                     <select class="form-control select2"  style="width: 100%" multiple="" name="committee[]" value="<?php echo $committee; ?>" >
                         <?php while ($get_committee = $get_committee_data->fetch(PDO::FETCH_ASSOC)) { ?>
                         <option value="<?php echo
                         $get_committee['committee']; ?>"><?php echo $get_committee['committee']; ?></option><?php } ?>
                     </select>
                   </div>
                  </div>
                </div><br>	

               <div class="row">
                 <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                     <label>Sub-Committee</label>
                 </div>
                 <div class="col-md-10">
                   <div class="form-group">
                     <select class="form-control select2"  style="width: 100%" multiple="" name="subcommittee[]" value="<?php echo $subcommittee; ?>" >
                         <?php while ($get_committee = $get_committee_data2->fetch(PDO::FETCH_ASSOC)) { ?>
                         <option value="<?php echo
                         $get_committee['committee']; ?>"><?php echo $get_committee['committee']; ?></option><?php } ?>
                     </select>
                   </div>
                 </div>
               </div><br>

             </div>                    
               <!-- /.card-body -->
             <div class="card-footer">
               <a href="add_sp_member">
                 <input type="button"  <?php echo $btnNew; ?> name="add" class="btn btn-primary" value="New">
               </a>
                 <input type="submit" <?php echo $btnStatus; ?> name="insert_spmember" class="btn btn-primary" value="Save">
               <a href="sp_member">
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

  <!-- loadImage -->
<script>
function loadImage(){
    var input = document.getElementById("fileToUpload");
var fReader = new FileReader();
fReader.readAsDataURL(input.files[0]);
fReader.onloadend = function(event){
    var img = document.getElementById("image");
    img.src = event.target.result;
}
}
</script> 

</body>
</html>
