<?php include 'includes/session.php'; ?>
<?php include 'insert_update_user.php'; ?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition sidebar-mini">
   <div class="wrapper">

 <!-- sidebar activity -->
 <?php
$sb_dashboard = "";
$sb_manage_records ="";
$sb_ordinances = "";
$sb_resolutions = "";
$sb_main_navigation = "";
$sb_sp_members = "";
$sb_committees = "";
$sb_account_settings = "menu-open";
$sb_my_profile = "active";
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
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
                
             <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header text-white"
                   style="background: url('../dist/img/sancarlos.jpg') center center;">
                <h3 class="widget-user-username"><?php echo $db_first_name . " " . $db_middle_name[0] ."." . " " . $db_last_name ?></h3>
                <h5 class="widget-user-desc"><?php echo $db_position ?></p></h5>
              </div>
              <div class="widget-user-image">
             
                <img class="img-circle elevation-2" src="<?php echo (empty($db_location)) ?'../dist/img/no-photo-icon.png'  : '../dist/img/' .$db_location ; ?>" alt="User Avatar">

              </div>
             
               <div class="card-body">
                 <br>
                 <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Department</b> <a class="float-right"><?php echo $db_department ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Email</b> <a class="float-right"><?php echo $db_email_ad ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Contact Number</b> <a class="float-right"><?php echo $db_contact_number ?></a>
                  </li>
                 </ul>
                 <?php echo $alert_msg ?>
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
               </div>
             </div>  


            <!-- /.card -->

            <!-- About Me Box -->
            <!-- <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              
              <div class="card-body">
                <strong><i class="fa fa-book mr-1"></i> Education</strong>

                <p class="text-muted">
                  B.S. in Computer Science from the University of Tennessee at Knoxville
                </p>

                <hr>

                <strong><i class="fa fa-map-marker mr-1"></i> Location</strong>

                <p class="text-muted">Malibu, California</p>

                <hr>

                <strong><i class="fa fa-pencil mr-1"></i> Skills</strong>

                <p class="text-muted">
                  <span class="tag tag-danger">UI Design</span>
                  <span class="tag tag-success">Coding</span>
                  <span class="tag tag-info">Javascript</span>
                  <span class="tag tag-warning">PHP</span>
                  <span class="tag tag-primary">Node.js</span>
                </p>

                <hr>

                <strong><i class="fa fa-file-text-o mr-1"></i> Notes</strong>

                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
              </div>
              
            <-- </div> -->
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                  <li class="nav-item"><a class="nav-link" href="#profilepicture" data-toggle="tab">Profile Picture</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Update Settings</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    
                    <!-- <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">
                        <span class="username">
                          <a href="#">Jonathan Burke Jr.</a>
                          <a href="#" class="float-right btn-tool"><i class="fa fa-times"></i></a>
                        </span>
                        <span class="description">Shared publicly - 7:30 PM today</span>
                      </div>
                     
                       <p>
                        Lorem ipsum represents a long-held tradition for designers,
                        typographers and the like. Some people hate it and argue for
                        its demise, but others ignore the hate as they create awesome
                        tools to help create filler text for everyone from bacon lovers
                        to Charlie Sheen fans.
                      </p>

                      <p>
                        <a href="#" class="link-black text-sm mr-2"><i class="fa fa-share mr-1"></i> Share</a>
                        <a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up mr-1"></i> Like</a>
                        <span class="float-right">
                          <a href="#" class="link-black text-sm">
                            <i class="fa fa-comments-o mr-1"></i> Comments (5)
                          </a>
                        </span>
                      </p>

                      <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                    </div>
                  

                   
                    <div class="post clearfix">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="../../dist/img/user7-128x128.jpg" alt="User Image">
                        <span class="username">
                          <a href="#">Sarah Ross</a>
                          <a href="#" class="float-right btn-tool"><i class="fa fa-times"></i></a>
                        </span>
                        <span class="description">Sent you a message - 3 days ago</span>
                      </div>
                     
                      <p>
                        Lorem ipsum represents a long-held tradition for designers,
                        typographers and the like. Some people hate it and argue for
                        its demise, but others ignore the hate as they create awesome
                        tools to help create filler text for everyone from bacon lovers
                        to Charlie Sheen fans.
                      </p>

                      <form class="form-horizontal">
                        <div class="input-group input-group-sm mb-0">
                          <input class="form-control form-control-sm" placeholder="Response">
                          <div class="input-group-append">
                            <button type="submit" class="btn btn-danger">Send</button>
                          </div>
                        </div>
                      </form>
                    </div>
                   

                    
                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="../../dist/img/user6-128x128.jpg" alt="User Image">
                        <span class="username">
                          <a href="#">Adam Jones</a>
                          <a href="#" class="float-right btn-tool"><i class="fa fa-times"></i></a>
                        </span>
                        <span class="description">Posted 5 photos - 5 days ago</span>
                      </div>
                      
                      <div class="row mb-3">
                        <div class="col-sm-6">
                          <img class="img-fluid" src="../../dist/img/photo1.png" alt="Photo">
                        </div>
                        
                        <div class="col-sm-6">
                          <div class="row">
                            <div class="col-sm-6">
                              <img class="img-fluid mb-3" src="../../dist/img/photo2.png" alt="Photo">
                              <img class="img-fluid" src="../../dist/img/photo3.jpg" alt="Photo">
                            </div>
                            
                            <div class="col-sm-6">
                              <img class="img-fluid mb-3" src="../../dist/img/photo4.jpg" alt="Photo">
                              <img class="img-fluid" src="../../dist/img/photo1.png" alt="Photo">
                            </div>
                            
                          </div>
                        </div>
                      </div>

                      <p>
                        <a href="#" class="link-black text-sm mr-2"><i class="fa fa-share mr-1"></i> Share</a>
                        <a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up mr-1"></i> Like</a>
                        <span class="float-right">
                          <a href="#" class="link-black text-sm">
                            <i class="fa fa-comments-o mr-1"></i> Comments (5)
                          </a>
                        </span>
                      </p> 

                      <input class="form-control form-control-sm" type="text" placeholder="Type a comment"> 
                    </div>
                     /.post -->
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="profilepicture">
                    
                   <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to update your profile picture?');">
                  
                     <div class="form-group">
                        <div class = "register-box-2" style = "width:300px;margin:auto;" >
                           <img src="<?php echo (empty($db_location)) ?'../dist/img/no-photo-icon.png'  : '../dist/img/' .$db_location ; ?>" class="elevation-2" style="margin-top:20px;margin-left:20px;margin-bottom:20px;width:400px;height:400px";   id="image" >
                        </div>
                   
                        <div class="col-md-10" style = "width:300px;margin:auto;">
                           <input class="form-control" type ="file" name="myFiles" id="fileToUpload" onchange = "loadImage()">
                        </div><br>
                 
                        <div>
                        <input type="submit" name="update_profile_picture" class="btn btn-success" value="Update">
                        </div>
                     </div>
                  
                   </form>

                  </div> 
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="settings">
                
                    <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return confirm('Are you sure you want to update this profile?');">

                      <div class="form-group">
                        <label for="FirstName" class="col-sm-2 control-label">First Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="FirstName" value="<?php echo $db_first_name ?>">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="MiddleName" class="col-sm-2 control-label">Middle Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="MiddleName" value="<?php echo $db_middle_name ?>">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="LastName" class="col-sm-2 control-label">Last Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="LastName" value="<?php echo $db_last_name ?>">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="Email" class="col-sm-2 control-label">Email Address</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" name="Email" value="<?php echo $db_email_ad ?>">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="ContactNo" class="col-sm-2 control-label">Contact Number</label>
                        <div class="col-sm-10">
                          <input type="contact_no" class="form-control" name="ContactNo" value="<?php echo $db_contact_number ?>">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="position" class="col-sm-2 control-label">Position</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="Position" value="<?php echo $db_position ?>">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="department" class="col-sm-2 control-label">Department</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="Department" value="<?php echo $db_department ?>">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" name="update_profile" class="btn btn-success" value="Update">
                        </div>
                        <div class="col-sm-offset-2 col-sm-10">
                        <a href="#" class='edituserpass' data-id="<?php echo $user_id; ?>"><i>change username and password</i></a>
                        </div>
                      </div>
                      
                    </form>
                    
                    
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
     <!-- Main Content End --> 

   </div> 
   <!-- Content-Wrapper End -->

    <!-------------------- modals here --------------------------------->

           <!-- Edit -->
           <div class="modal fade" id="edituserpass" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header card-outline card-danger ">
            	<h4 class="modal-title"><b>Change Username and Password</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="insert_update_userpass.php">
              <input type="hidden" class="user_id" name="id">
              <div class="row">
                    <div class="col-md-4" style="text-align: right;padding-top: 5px;">
                       <label>Old Username</label>
                    </div>
                    <div class="col-md-7">
                       <input readonly="true" type="text" class="form-control" id="old_username" name="oldusername">
                    </div>
                </div><br>

              <div class="row">
                    <div class="col-md-4" style="text-align: right;padding-top: 5px;">
                       <label>New Username</label>
                    </div>
                    <div class="col-md-7">
                       <input type="text" class="form-control" id="new_username" name="newusername">
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-md-4" style="text-align: right;padding-top: 5px;">
                       <label>New Password</label>
                    </div>
                    <div class="col-md-7">
                       <input type="password" class="form-control" id="new_password" name="newpassword">
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-md-4" style="text-align: right;padding-top: 5px;">
                       <label>Old Password</label>
                    </div>
                    <div class="col-md-7">
                       <input type="password" class="form-control" id="old_password" name="oldpassword">
                       <label style="color:red" class="right badge"> *type old password to confirm changes  </label>
                    </div>
                </div><br>

          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
            	<button type="submit" class="btn btn-danger btn-sm" name="edit"><i class="fa fa-check"></i> Confirm</button>
            	</form>
          	</div>
        </div>
    </div>
</div>


 <?php include 'includes/footer.php'; ?>
 </div>
 <!-- Wrapper End -->

 <?php include 'includes/scripts.php'; ?>

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

 <script>
 $(function(){
   
  $('.edituserpass').click(function(e){
    e.preventDefault();
    $('#edituserpass').modal('show');
    var id = $(this).data('id');
    getRow(id);
    
  });

});

function getRow(id){
 
  $.ajax({
    
    type: 'POST',
    url: 'profile_fetch.php',
    data: {id:id},
    dataType: 'json',
    success: function(data){
      $('.user_id').val(data.user_id);
      $('#user_id').val(data.user_id);
      $('#old_username').val(data.username);
      
       }
  });
};
 </script>

</body>
</html>
