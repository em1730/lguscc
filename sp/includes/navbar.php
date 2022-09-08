   <!-- Navbar -->
   <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
     <!-- Left navbar links -->
     <ul class="navbar-nav">

       <li class="nav-item">
         <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
       </li>

       <li class="nav-item d-none d-sm-inline-block">
         <a href="index.php" class="nav-link"><i class="nav-icon fa fa-home"></i></a>
       </li>

       <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link"><i class="nav-icon fa fa-envelope"></i></a>
       </li> -->
       
     </ul>

     <!-- Right navbar links -->
     <!-- <ul class="navbar-nav ml-auto">
     
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-comments-o"></i>
          <span class="badge badge-danger navbar-badge">
             <?php echo $get_commiteeno_data->rowCount()?>
          </span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

        <?php
     $spmember = $con->query("SELECT * FROM sp_members WHERE committee ='Police Matters, Fire & Penology'")->fetchall(PDO::FETCH_ASSOC);
     foreach($spmember as $row):?>

          <a href="update_sp_member.php?objid=<?php echo $row['objid']; ?>" class="dropdown-item">

            <div class="media">
              <img src="<?php echo (empty($row['location'])) ? '../dist/pic/nophoto.png' : '../dist/pic/'.$row['location'] ; ?>" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                   <?php echo $row['fullname'];?>
                   <span class="float-right text-sm text-danger"><i class="fa fa-star"></i></span>
                </h3>
                <p class="text-sm"><?php echo $row['email'];?></p>
                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
          </a>
          <div class="dropdown-divider"></div>

     <?php endforeach; ?>


          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-bell-o"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
            class="fa fa-th-large"></i></a>
      </li>
     </ul> -->
     
  </nav>
  <!-- Navbar End -->