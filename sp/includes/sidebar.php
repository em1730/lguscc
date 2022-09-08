   <!-- Main Sidebar Container -->

   

   <aside class="main-sidebar sidebar-dark-primary elevation-4">

     <!-- Brand Logo -->
     <a href="index3.html" class="brand-link">
       <img src="../dist/img/scclogo.png" alt="AdminLTE Logo" class="brand-image img-circle" style="opacity: ">
       <span class="brand-text font-weight-light"><b>SP DocuTrack</b> Sys</span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">

       <!-- Sidebar USER PANEL -->
       <div class="user-panel mt-3 pb-3 mb-3 d-flex">
         <div class="image">
         <img src="<?php echo (empty($db_location)) ?'../dist/img/no-photo-icon.png'  : '../dist/img/' .$db_location ; ?>" class="img-circle elevation-2" alt="User Image">
         </div>
         <div class="info">
          <a href="profile.php" class="d-block"><?php echo $db_first_name . " " . $db_middle_name[0] ."." . " " . $db_last_name ?>  </a>
         </div>
       </div>

       <!-- Sidebar Menu -->
       <nav class="mt-2">
         <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         
           <li class="nav-item">
             <a href="index.php" class="nav-link <?php echo $sb_dashboard ?>">
               <i class="nav-icon fa fa-th"></i> <p> Dashboard </p>
             </a>
           </li>

           <li class="nav-item has-treeview <?php echo $sb_manage_records ?>">
             <a href="#" class="nav-link">
               <i class="nav-icon fa fa-suitcase"></i><p>MANAGE RECORDS<i class="right fa fa-angle-left"></i></p>
             </a>

               <ul class="nav nav-treeview">

                 <li class="nav-item">
                   <a href="ordinances.php" class="nav-link <?php echo $sb_ordinances ?>">
                     <i class="fa fa-circle-o nav-icon"></i>
                       <p>Ordinances</p>
                   </a>
                 </li>

                 <li class="nav-item">
                   <a href="resolutions" class="nav-link <?php echo $sb_resolutions ?>">
                     <i class="fa fa-circle-o nav-icon"></i>
                       <p>Resolutions</p>
                   </a>
                 </li>

               </ul>
             
           <li class="nav-item has-treeview <?php echo $sb_main_navigation ?>">
             <a href="#" class="nav-link">
               <i class="nav-icon fa fa-suitcase"></i> <p> MAIN NAVIGATION <i class="right fa fa-angle-left"></i></p>
             </a>
            
               <ul class="nav nav-treeview">

                 <li class="nav-item">
                   <a href="sp_member" class="nav-link <?php echo $sb_sp_members ?>">
                     <i class="fa fa-circle-o nav-icon"></i>
                       <p>SP Members</p>
                   </a>
                 </li>

                 <li class="nav-item">
                   <a href="committee" class="nav-link <?php echo $sb_committees ?>">
                     <i class="fa fa-circle-o nav-icon"></i>
                       <p>Committees</p>
                   </a>
                 </li>

               </ul>
                


           <li class="nav-item has-treeview <?php echo $sb_account_settings ?>" >
             <a href="#" class="nav-link ">
               <i class="nav-icon fa fa-suitcase"></i><p>ACCOUNT SETTINGS<i class="right fa fa-angle-left"></i></p>
             </a>

             <ul class="nav nav-treeview">

               <li class="nav-item">
                 <a href="profile.php" class="nav-link <?php echo $sb_my_profile ?>">
                     <i class="fa fa-circle-o nav-icon"></i>
                     <p>My Profile</p>
                    </a>
                  </li>

             </ul>
           

           <li class="nav-item has-treeview <?php echo $sb_system ?>">
             <a href="#" class="nav-link ">
               <i class="nav-icon fa fa-suitcase"></i><p>SYTEM<i class="right fa fa-angle-left"></i></p>
             </a>

             <ul class="nav nav-treeview">

               <li class="nav-item">
                 <a href="../lockscreen.php" class="nav-link <?php echo $sb_lock ?>">
                   <i class="fa fa-circle-o nav-icon"></i>
                   <p>LOCK</p>
                 </a>
               </li>

               <li class="nav-item">
                 <a href="../logout.php" class="nav-link <?php echo $sb_signout ?>">
                   <i class="fa fa-circle-o nav-icon"></i>
                   <p>SIGN OUT</p>
                 </a>
               </li>

             </ul>
         </ul>

       </nav> <!-- Sidebar Menu END -->
       

     
       <!-- <div class="image">
       <img src="../dist/pic/tenor.gif" >
       </div> -->
      
     </div> <!-- Sidebar END -->
     

   </aside>
   <!-- Main Sidebar Container End -->