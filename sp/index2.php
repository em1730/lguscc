 <?php include 'includes/session.php'; ?>
 <?php include 'includes/header.php'; ?>

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
            <h1 class="m-0 text-dark">Dashboard</h1>
           </div>
         </div>
       </div>
     </div>
     <!-- Content Header End -->

     <!-- Main content  -->
     <div class="container-fluid">

       <!-- Info boxes -->
       <div class="row">
        
         <!-- /.col -->
         <div class="col-12 col-sm-6 col-md-3">
           <div class="info-box bg-info-gradient">

            <a href="ordinances.php" class="info-box-icon bg-info elevation-1"><span ><i class="fa fa-file"></i></span></a>

              <div class="info-box-content">
                <span class="info-box-text">Ordinances</span>
                <span class="info-box-number">
                  <?php echo $get_all_ordinances_data->rowCount()?>
                </span>
              </div>
           </div>
         </div>

         <!-- /.col -->
         <div class="col-12 col-sm-6 col-md-3">
           <div class="info-box bg-danger-gradient">
          
            <a href="resolutions.php" class="info-box-icon bg-danger elevation-1"><span ><i class="fa fa-file-text"></i></span></a>

              <div class="info-box-content">
                <span class="info-box-text">Resolutions</span>
                <span class="info-box-number">
                  <?php echo $get_all_resolutions_data->rowCount()?>
                </span>
              </div>
           </div>
         </div>
        
         <!-- fix for small devices only -->
         <div class="clearfix hidden-md-up"></div>

         <!-- /.col -->
         <div class="col-12 col-sm-6 col-md-3">
           <div class="info-box bg-success-gradient">
          
            <a href="sp_member.php" class="info-box-icon bg-success elevation-1"><span ><i class="fa fa-users"></i></span></a>

              <div class="info-box-content">
                <span class="info-box-text">SP Members</span>
                <span class="info-box-number">
                  <?php echo $get_all_spmembers_data->rowCount()?>
                </span>
              </div>
           </div>
         </div>

         <!-- /.col -->
         <div class="col-12 col-sm-6 col-md-3">
           <div class="info-box bg-warning-gradient">
          
            <a href="committee.php" class="info-box-icon bg-warning elevation-1"><span ><i class="fa fa-address-card"></i></span></a>

              <div class="info-box-content">
                <span class="info-box-text">Committees</span>
                <span class="info-box-number">
                  <?php echo $get_all_committee_data->rowCount()?>
                </span>
              </div>
           </div>
         </div>

       </div>

       <br>
       <!-- Info boxes End -->

       <div class="card card-outline card-primary ">
            <div class="card-header with-border">
              <h3 class="card-title">Quick Search</h3>
            </div>

            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="get" action="<?php htmlspecialchars("PHP_SELF"); ?>">
            <div class="card-body">
              <table id="users" class="table table-bordered table-striped">
                 
                  <thead>
                    <tr>
                <th width="100">Date Added</th>
                <th width="250">Resolution/Ordinance Number</th>
                <th>Title</th>
                <th width="50">Options</th>
                    </tr>
                  </thead>
                 <tbody>
                  </tbody>
                </table>
              </div>
              <!-- /.box-body -->
            </form>
       </div>

     </div>
     <!-- Main Content End --> 

   </div> 
   <!-- Content-Wrapper End -->


 <?php include 'includes/footer.php'; ?>
 </div>
 <!-- Wrapper End -->

 <?php include 'includes/scripts2.php'; ?>

   <script>
  		$(document).ready(function() {
				var dataTable = $('#users').DataTable( {
					"processing": true,
					"serverSide": true,
					"ajax":{
						url :"quicksearch.php", // json datasource

						type: "post",  // method  , by default get
           
						error: function(){  // error handling
							$("#users-error").html("");
							$("#users").append('<tbody class="users-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
							$("#users_processing").css("display","none");
             
						}
					},
          "columnDefs": [{
                "targets" : -1,
                "data" : null,
                "defaultContent": '<button class=\"receive btn btn-outline-success btn-xs \" ><i class="fa fa-eye" aria-hidden= "true"></i></button>'
          
         
              }],
				} );

      //   $('#users tbody').on( 'click', 'button.receive', function() {
      //     // alert ('hello');
      //    // var row = $(this).closest('tr');
      //    var table = $('#users').DataTable();
      //    var data = table.row( $(this).parents('tr') ).data();
      //   //  alert (data[0]);
      //   //  var data = $('#users').DataTable().row('.selected').data(); //table.row(row).data().docno;
      //     var docno = data[0];
      //     window.open("viewpdf.php?orno=" + docno,'_parent');
      //   //  var table = $('#users').DataTable();
      //   //   if ($(this).hasClass('selected')){
      //   //       $(this).removeClass('selected');
            
      //   //   }else{
      //   //     table.$('tr.selected').removeClass('selected');
      //   //     $(this).addClass('selected');
          
      //   //   var data = $('#users').DataTable().row('.selected').data(); //table.row(row).data().docno;
      //   //   var docno = data[0];
      //   //   window.open("receive_incoming.php?docno=" + docno,'_parent');
      //  // alert(docno);
      // //    }
      //   });
			} );
   </script>


</body>
</html>
