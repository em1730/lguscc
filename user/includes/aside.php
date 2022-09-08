 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="../dist/img/scclogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: ">
      <span class="brand-text font-weight-light">LGUSSC | DTS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../dist/img/logo.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="profile.php" class="d-block"><?php echo $db_first_name . " " . $db_middle_name . " " . $db_last_name ?>  </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
         
               <li class="nav-item">
                <a href="index.php" class="nav-link active">
                  <i class="nav-icon fa fa-th"></i>
                  <p>
                    Dashboard
                    <!-- <span class="right badge badge-danger">New</span> -->
                  </p>
                </a>
              </li>
             
              <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-dashboard"></i>
              <p>
                TRANSACTIONS
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            
            <ul class="nav nav-treeview">

            <li class="nav-item">
                <a href="add_outgoing" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Forward</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="receive_incoming_other" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Receive</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="release_document" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Release</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="archive_document" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Archive</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="track_documents" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Track Documents</p>
                </a>
              </li>
            
              <li class="nav-item">
                <a href="force_receive" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Force Receive</p>
                </a>
              </li>
              </ul>
            
              <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-dashboard"></i>
              <p>
                MASTER LISTS
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="list_document_type" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Document Types</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="list_department" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Departments</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="list_document_type" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Users</p>
                </a>
              </li>
              </ul>

              <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
              <i class="nav-icon fa fa-dashboard"></i>
              <p>
                REPORTS
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="receiving_copy" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Receiving Copy</p>
                </a>
              </li>
              <li class="nav-item" >
                <a href="#myModal" data-toggle="modal" data-target="#myModal"  class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Routing Slip</p>
                </a>
              </li>
              </ul>

              <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
              <i class="nav-icon fa fa-dashboard"></i>
              <p>
                SETTINGS
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="add_document" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Add Document Type</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="add_department" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Add Department</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="add_user " class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Add User</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="add_suppliers " class="nav-link">
                <i class="fa fa-circle-o nav-icon"></i>
                  <p>Add Suppliers</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="add_joborder " class="nav-link">
                <i class="fa fa-circle-o nav-icon"></i>
                  <p>Add Job Order</p>
                </a>
              </li>

             
              </ul>

              <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
              <i class="nav-icon fa fa-dashboard"></i>
              <p>
                SYTEM
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../lockscreen.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>LOCK</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="../logout.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>SIGN OUT</p>
                </a>
              </li>
              </ul>
          
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>