 <?php include 'includes/session.php'; ?>
 <?php include 'includes/header.php'; ?>
 <?php include 'insert_update_sp_member.php'; ?>

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
            <h1 class="m-0 text-dark">Update SP Member</h1>
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
     <section class="content">

    
       <div class="row">
           <div class="col-md-2"></div>
         <div class="col-md-7">
         <div class="animationIN card card-primary card-outline">
            <br>
            <!-- /.card-header -->
            <!-- form start -->

           <form method="post" action="<?php htmlspecialchars("PHP_SELF"); ?>" enctype="multipart/form-data">
           <div class="card-body">

             <div class="box-profile" align="center">
               <?php echo $alert_msg; ?>
             </div>  

            
           <!-- Profile Image -->
               <div class="box-profile" align="center">
                 <img class="img-thumbnail" src="<?php echo (empty($location)) ? '../dist/pic/nophoto.png' : '../dist/pic/'.$location ; ?>" align="center" vspace="10" width="200" height="200";  id="image">
               </div>                                                              

                 <div class="col-md-2" style = "width:300px;margin:auto;">
                   <input type ="file" name="myFiles" id="fileToUpload" onchange = "loadImage()" value="<?php echo $location;?>">
                 </div><br>
           
                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Employee ID No.</label>
                  </div>
                  <div class="col-md-10">
                      <input type="text" class="form-control" name="idno" placeholder="Employee ID No." value="<?php echo $empID; ?>">
                  </div>
                </div><br>
                
                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Full Name</label>
                  </div>
                  <div class="col-md-10">
                      <input type="text" class="form-control" name="fullname" placeholder="Full Name" value="<?php echo $fullName; ?>">
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
                      <input type="contactno" class="form-control" name="contact_number" placeholder="Contact Number" value="<?php echo $contact_number; ?>">
                  </div>
                </div><br>
                
                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                     <label>Committee</label>
                  </div>
                  <div class="col-md-10">
                  <div class="form-group">
                     <select class="form-control select2"  style="width: 100%" multiple="" name="committee[]" value="<?php echo $committee; ?>" >
                         <?php while ($get_committee = $get_committee_data->fetch(PDO::FETCH_ASSOC)) { 
                          if( in_array($get_committee['committee'], $new_committees) ){
                          $selected = 'selected';
                          }
                          else{
                          $selected = '';
                          }

                          ?>
                           <option <?= $selected ?> value="<?php echo $get_committee['committee']; ?>"><?php echo $get_committee['committee']; ?></option>
                           <?php } ?>
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
                          <?php while ($get_committee = $get_committee_data2->fetch(PDO::FETCH_ASSOC)) { 
                          if( in_array($get_committee['committee'], $new_subcommittees) ){
                          $selected = 'selected';
                          }
                          else{
                          $selected = '';
                          }

                          ?>
                           <option <?= $selected ?> value="<?php echo $get_committee['committee']; ?>"><?php echo $get_committee['committee']; ?></option>
                           <?php } ?>
                     </select>
                   </div>
                  </div>
                </div><br>

           </div>	
           
           <div class="card-footer">
               <input type="submit" name="insert_update_spmember" class="btn btn-primary" value="Save">
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
