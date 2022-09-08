
<body class="hold-transition sidebar-mini">
<div class="wrapper">

<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="send_email" class="nav-link">Contact</a>
      </li>
   
    <li class="nav-item d-none d-sm-inline-block">
        <a href="it_support" class="nav-link">IT Support</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <form class="form-inline ml-3">
                <button class="btn btn-navbar" type="submit" data-role="scan_receive">
            <i class="fa fa-search"></i>
          </button>
        
     
    </form>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-comments-o"></i>
          <?php if ($message_count != 0) { ?>
          <span class="badge badge-danger navbar-badge"><?php echo $message_count ?> </span>
          <?php } ?>
                    </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <?php while($messages_data = $get_all_messages_data->fetch(PDO::FETCH_ASSOC)){ ?>
        <a href="read-mail.php?objid=<?php echo $messages_data['objid'];?>" class="dropdown-item">
            <!-- Message Start -->

          

            <div class="media">
              <img src="../dist/img/logo.png" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  <?php echo $messages_data['sender']; ?>
                  <span class="float-right text-sm text-danger"><i class="fa fa-star"></i></span>
                </h3>
                <p class="text-sm">  <?php echo $messages_data['subject']; ?></p>
                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i>   <?php echo $messages_data['date']; ?></p>
              </div>
            </div>
            <!-- Message End -->
          </a>

          <?php } ?>

         
            <!-- Message End -->
          </a>
          
          <div class="dropdown-divider"></div>
          <a href="mailbox.php" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
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
    </ul>
  </nav>