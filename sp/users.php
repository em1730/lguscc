<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition sidebar-mini">
   <div class="wrapper">

   <?php include 'includes/navbar.php'; ?>
   <?php include 'includes/sidebar.php'; ?>



   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">

     <!-- Content Header (Page header) -->
     <section class="content-header">
      <h1>Users</h1>
      </section>
     <!-- Content Header End -->

     <!-- Main content  -->
     <section class="content">

         <!-- <div class="btn-group-vertical">
                        <button type="button" class="btn btn-default" href="../plugins/TCPDF/User/ordinance" target="blank"><i class="fa fa-envelope-o"></i> Generate PDF</button>
                        <button type="button" class="btn btn-default" href="../bower_components/PHPExcel/Examples/blank"><i class="fa fa-envelope-o"></i> Export Data</button>
                        <button type="button" class="btn btn-default" href="import_data"><i class="fa fa-file-text-o"></i> Import Data</button>
         </div> -->

            <!-- /.box-body -->
    
            <div class="col-md-2">
         <!-- <a href="add_user.php">
           <button class="btn btn-info btn-block margin-bottom" >
             Add User
           </button>                      
         </a> -->
         </div>
         <br> 

          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">User Details</h3>
            </div>


            <!-- /.box-header -->

            <!-- form start -->
            <form role="form" method="get" action="<?php htmlspecialchars("PHP_SELF");?>">
              <div class="card-body">
                <table id="users" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th> </th>
                      <th>Fullname</th>
                      <!-- <th>Middlename</th>
                      <th>Lastname</th> -->
                      <th>Email</th>
                      <th>Contact Number</th>
                      <th>Username</th>
                      <th>Options</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php while($user_data = $get_all_users_data->fetch(PDO::FETCH_ASSOC)){ ?>
                    <tr>
                        <td width="70" align="center"><img class="img-circle" src="<?php echo (empty($user_data['location'])) ? '../dist/img/no-photo-icon.png' : '../dist/img/'.$user_data['location'] ; ?>" width="50" height="50" ></td>
                        <td><?php echo ucfirst($user_data['first_name']) . ' ' .ucwords($user_data['middle_name'][0]) . '. ' . ucfirst($user_data['last_name']);?></td>
                        <td><?php echo $user_data['email'];?></td>
                        <td><?php echo $user_data['contact_no'];?></td>
                        <td><?php echo $user_data['username'];?></td>
                        <td>
                          <a class="btn btn-outline-success btn-xs" href="update_user?userpass=<?php echo $user_data['userpass'];?>&id=<?php echo $user_data['user_id'];?> "><i class="fa fa-pencil"></i>
                          </a>
                          &nbsp; 
                          <button class="btn btn-outline-danger btn-xs" data-role="confirm_delete" data-id="<?php echo $user_data["user_id"]; ?>"><i class="fa fa-trash-o"></i></button>
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
        
        <div class="col-md-1"></div>
      </div>

     </section>
     <!-- Main Content End --> 

   </div> 
   <!-- Content-Wrapper End -->


 <?php include 'includes/footer.php'; ?>
 </div>
 <!-- Wrapper End -->

 <?php include 'includes/scripts.php'; ?>

</body>
</html>
