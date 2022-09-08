<?php

session_start();
$user_id = $_SESSION['id'];
$docno ='';
include ('includes/head.php');


if (!isset($_SESSION['id'])) {
  header('location:../index.php');
}

$user_id = $_SESSION['id'];

include('../config/db_config.php');
include('delete.php');

$get_user_sql = "SELECT * FROM tbl_users WHERE user_id = :id";
$get_user_data = $con->prepare($get_user_sql);
$get_user_data->execute([':id'=>$user_id]);
while ($result = $get_user_data->fetch(PDO::FETCH_ASSOC)) {

$user_name = $result['username'];
$department = $result['department'];
$db_first_name = $result['first_name'];
$db_middle_name = $result['middle_name'];
$db_last_name = $result['last_name'];
$db_email_ad = $result['email'];
$db_contact_number = $result['contact_no'];
$db_user_name = $result['username'];
}


//count incoming documents
$get_noofdocs_sql= "SELECT COUNT(`docno`) as total FROM `tbl_documents` WHERE status in ('CREATED','FORWARDED') and destination = '$department'";
$get_noofdocs_data = $con->prepare($get_noofdocs_sql);
$get_noofdocs_data->execute();
$get_noofdocs_data->setFetchMode(PDO::FETCH_ASSOC);
while ($result1 = $get_noofdocs_data->fetch(PDO::FETCH_ASSOC)) {
  $incoming_count =  $result1['total'];
}


//count incoming documents
$get_noofdocs_sql= "SELECT COUNT(`docno`) as total FROM `tbl_documents` WHERE status in ('CREATED','FORWARDED') and destination = '$department'";
$get_noofdocs_data = $con->prepare($get_noofdocs_sql);
$get_noofdocs_data->execute();
$get_noofdocs_data->setFetchMode(PDO::FETCH_ASSOC);
while ($result1 = $get_noofdocs_data->fetch(PDO::FETCH_ASSOC)) {
  $incoming_count =  $result1['total'];
}


//count incoming documents
$get_noofdocs_sql= "SELECT COUNT(`docno`) as total FROM `tbl_documents` WHERE status = 'RECEIVED' and destination = '$department'";
$get_noofdocs_data = $con->prepare($get_noofdocs_sql);
$get_noofdocs_data->execute();
$get_noofdocs_data->setFetchMode(PDO::FETCH_ASSOC);
while ($result1 = $get_noofdocs_data->fetch(PDO::FETCH_ASSOC)) {
  $received_count =  $result1['total'];
}

$get_noofdocs_sql= "SELECT COUNT(`docno`) as total FROM `tbl_documents` where origin = '$department'";
$get_noofdocs_data = $con->prepare($get_noofdocs_sql);
$get_noofdocs_data->execute();
$get_noofdocs_data->setFetchMode(PDO::FETCH_ASSOC);
while ($result1 = $get_noofdocs_data->fetch(PDO::FETCH_ASSOC)) {
  $outgoing_count =  $result1['total'];
}

$get_noofdocs_sql= "SELECT COUNT(`docno`) as total FROM `tbl_documents` WHERE status = 'ARCHIVED' and destination = '$department'";
$get_noofdocs_data = $con->prepare($get_noofdocs_sql);
$get_noofdocs_data->execute();
$get_noofdocs_data->setFetchMode(PDO::FETCH_ASSOC);
while ($result1 = $get_noofdocs_data->fetch(PDO::FETCH_ASSOC)) {
  $archived_count =  $result1['total'];
}


// count new messages
$get_all_message_sql = "SELECT count(*) as total FROM tbl_message where receiver = $user_id and status = 'PENDING'";
$get_all_message_data = $con->prepare($get_all_message_sql);
$get_all_message_data->execute();  
while ($result1 = $get_all_message_data->fetch(PDO::FETCH_ASSOC)) {
  $message_count =  $result1['total'];
}

// //select all messages for notification
$get_all_messages_sql = "SELECT * FROM tbl_message where (receiver = $user_id or receiver = '0') and status = 'PENDING' ";
$get_all_messages_data = $con->prepare($get_all_messages_sql);
$get_all_messages_data->execute();  

// //select all messages for email
$get_all_messages1_sql = "SELECT * FROM tbl_message where receiver = $user_id or receiver ='0'";
$get_all_messages1_data = $con->prepare($get_all_messages1_sql);
$get_all_messages1_data->execute();  
  
?>


<body class="hold-transition sidebar-mini">
<div class="wrapper">

<?php  
      include ('includes/nav-bar.php');
      include ('includes/aside.php');
      include ('includes/dashboard.php');
?>

    <!-- /.content-header -->


  <!-- Content Wrapper. Contains page content -->
  <!-- <div class="content-wrapper"> -->
  <div class="card">
            <div class="card-header">
              <h3 class="card-title">Archived Documents</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="archived" class="table table-bordered table-striped">
          
                  <thead>
                    <tr>
                    <th>Document No.</th>
                <th>Date</th>
                <th>Type</th>
                <th>Particulars</th>
                <th>Origin</th>
                <th>Status</th>
                <th>Remarks</th>
                <th>Options</th>
                    </tr>
                  </thead>
                  <tbody>
                
                    
                  </tbody>
                </table>
              </div>
              <!-- /.box-body -->
            </form>
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-1"></div>
      </div>
      <div class="col-md-10">
                      <input type="hidden" id="department" readonly class="form-control" name="department" placeholder="Department" value="<?php echo
$department; ?>" >
                  </div>
                </div><br>

    </section>
    <!-- /.content -->


    <!-- modals here -->
        <!-- modal here delete -->
        <div class="modal fade" id="deleteuser_Modal" role="dialog" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Confirm Delete</h4>
              </div>
              <form method="POST" action="<?php htmlspecialchars("PHP_SELF")?>">
                <div class="modal-body">  
                  <div class="box-body">
                    <div class="form-group">
                    <label>Delete Record?</label>
                    <input type="text" name="user_id" id="user_id" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">

                  <button type="button" class="btn btn-default pull-left bg-olive" data-dismiss="modal">No</button>
                  <!-- <button type="submit" name="delete_user" class="btn btn-danger">Yes</button> -->
                  <input type="submit" name="delete_user" class="btn btn-danger" value="Yes">
                </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->


  </div>
  <!-- /.content-wrapper -->

  <!-- footer here -->
  <?php include ('includes/footer.php');?>



<script>
  
  $(document).ready(function() {
        var office = $('#department').val();
				var dataTable = $('#archived').DataTable( {
					"processing": true,
					"serverSide": true,
					"ajax":{
						url :"track_archived.php", // json datasource
            data:{office:office},
						type: "post",  // method  , by default get
						error: function(){  // error handling
							$("#archived-error").html("");
							$("#archived").append('<tbody class="archived-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
							$("#archived_processing").css("display","none");
             
						}
					},
          "columnDefs": [{
                "targets" : -1,
                "data" : null,
                "defaultContent": '<button class=\"pdf btn btn-outline-success btn-xs \" ><i class="fa fa-file-pdf-o" aria-hidden= "true"></i></button>'
          
         
              }],
				} );

        $('#archived tbody').on( 'click', 'button.pdf', function() {
          // alert ('hello');
         // var row = $(this).closest('tr');
         var table = $('#archived').DataTable();
         var data = table.row( $(this).parents('tr') ).data();
        //  alert (data[0]);
        //  var data = $('#users').DataTable().row('.selected').data(); //table.row(row).data().docno;
          var docno = data[0];
          window.open("view_pdf.php?docno=" + docno,'_blank');
        //  var table = $('#users').DataTable();
        //   if ($(this).hasClass('selected')){
        //       $(this).removeClass('selected');
            
        //   }else{
        //     table.$('tr.selected').removeClass('selected');
        //     $(this).addClass('selected');
          
        //   var data = $('#users').DataTable().row('.selected').data(); //table.row(row).data().docno;
        //   var docno = data[0];
        //   window.open("receive_incoming.php?docno=" + docno,'_parent');
       // alert(docno);
      //    }
        });
			} );
    $(document).on('click', 'button[data-role=confirm_delete]', function(event){
      event.preventDefault();

      var user_id = ($(this).data('id'));

      $('#user_id').val(user_id);
      $('#deleteuser_Modal').modal('toggle');

    })
</script> 

</body>
</html>
