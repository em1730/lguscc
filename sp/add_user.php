<?php include 'includes/session.php'; ?>
 <?php include 'includes/header.php'; ?>
 <?php include 'includes/insert.php'; ?>

<body class="hold-transition sidebar-mini">
 <div class="wrapper">

 <?php include 'includes/navbar.php'; ?>
 <?php include 'includes/sidebar.php'; ?>



   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">

     <!-- Content Header (Page header) -->
 <div class="content-header">
   <div class="container-fluid">
     <div class="row mb-2">
       <div class="col-sm-6">
         <h1 class="m-0 text-dark">Add User</h1>
       </div>
       <div class="col-sm-6">
         <ol class="breadcrumb float-sm-right">
         </ol>
       </div>
     </div>
   </div>
 </div>
     <!-- Content Header End -->

     <!-- Main content  -->
 <section class="content">


  <div class="row">
   <div class="col-md-2"></div>
     <div class="col-md-8">     
       <div class="card card-secondary">
         <div class="card-header">
           <h3 class="card-title">User Details</h3>
         </div>
         
            <!-- /.box-header -->
            <!-- form start -->

           <form method="post" action="" enctype="multipart/form-data">
           <div class="card-body">

             <div align="center">
               <?php echo $alert_msg; ?>
             </div>

             <div class = "register-card-body" style = "width:300px;margin:auto;" >
               <img src="../dist/img/no-photo-icon.png" aling="center" class="elevation-2" style="margin-top:20px;margin-left:20px;margin-bottom:20px;width:200px;height:200px";   id="image" >
             </div>

             <div class="row">
               <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                 <label>First Name</label>
               </div>
               <div class="col-md-10">
                <input type="text" class="form-control" name="firstname" placeholder="Firstname" required>
               </div>
             </div><br>

           <div class="row">
            <div class="col-md-2" style="text-align: right;padding-top: 5px;">
             <label>Middle Name</label>
            </div>
            <div class="col-md-10">
                <input type="text" class="form-control" name="middlename" placeholder="Middlename" required>
            </div>
           </div><br>
           <div class="row">
            <div class="col-md-2" style="text-align: right;padding-top: 5px;">
             <label>Last Name</label>
            </div>
            <div class="col-md-10">
                <input type="text" class="form-control" name="lastname" placeholder="Lastname" required>
            </div>
           </div><br>
           <div class="row">
            <div class="col-md-2" style="text-align: right;padding-top: 5px;">
             <label>Email Address</label>
            </div>
            <div class="col-md-10">
                <input type="email" class="form-control" name="email" placeholder="Email Address" >
            </div>
           </div><br>
           <div class="row">
            <div class="col-md-2" style="text-align: right;padding-top: 5px;">
             <label>Contact Number</label>
            </div>
            <div class="col-md-10">
                <input type="number" class="form-control" name="contact_number" placeholder="Contact Number"  required>
            </div>
           </div><br>

           <div class="row">
            <div class="col-md-2" style="text-align: right;padding-top: 5px;">
             <label>Position</label>
            </div>
            <div class="col-md-10">
                <input type="text" class="form-control" name="position" placeholder="Position" required>
            </div>
           </div><br>
           
           <div class="row">
            <div class="col-md-2" style="text-align: right;padding-top: 5px;">
             <label>Department</label>
            </div>
            <div class="col-md-10">
                <input type="text" class="form-control" name="department" placeholder="SP" disabled>
            </div>
           </div><br>

           <div class="row">
            <div class="col-md-2" style="text-align: right;padding-top: 5px;">
             <label>Username</label>
            </div>
            <div class="col-md-10">
                <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
           </div><br>

           <div class="row">
            <div class="col-md-2" style="text-align: right;padding-top: 5px;">
             <label>Password</label>
            </div>
            <div class="col-md-10">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
           </div><br>

           <div class="row">
            <div class="col-md-2" style="text-align: right;padding-top: 5px;">
             <label>Upload Photo</label>
            </div>
            <div class="col-md-10">
             <input class="form-control" type ="file" name="myFiles" id="fileToUpload"  onchange = "loadImage()">
            </div>
           </div><br>  

           </div>
           <!-- /.box-body -->
           <div class="card-footer" align="center">
              <input type="submit"  <?php echo $btnNew; ?> name="add" class="btn btn-primary" value="New">
              <input type="submit"  <?php echo $btnStatus; ?> name="insert" class="btn btn-primary" value="Save">
              <a href="users">
              <input type="button" name="cancel" class="btn btn-default" value="Cancel">       
              </a>
           </div>
             <br>
           
           </form>
         </div>
       <!-- /.box -->
       </div>
         <div class="col-md-1"></div>
         
         
        </div>
       </div>
      
 </section>
     <!-- Main Content End --> 

   </div> 
   <!-- Content-Wrapper End -->


 <?php include 'includes/footer.php'; ?>
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
