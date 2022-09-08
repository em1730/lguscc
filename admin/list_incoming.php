<?php

session_start();
include ('includes/head.php');
if (!isset($_SESSION['id'])) {
  header('location:../index.php');
}

$user_id = $_SESSION['id'];
$docno ='';
$alert_msg ='';


include('../config/db_config.php');
include('delete.php');

$get_user_sql = "SELECT * FROM tbl_users WHERE user_id = :id";
$get_user_data = $con->prepare($get_user_sql);
$get_user_data->execute([':id'=>$user_id]);
while ($result = $get_user_data->fetch(PDO::FETCH_ASSOC)) {

$user_name =$result['username'];
$GLOBALS['department'] = $result['department'];
$db_first_name = $result['first_name'];
$db_middle_name = $result['middle_name'];
$db_last_name = $result['last_name'];
$db_email_ad = $result['email'];
$db_contact_number = $result['contact_no'];
$db_user_name = $result['username'];
}


// //select all outgoing documents
$get_all_document_sql = "SELECT * FROM tbl_documents where destination = '$department' and status in ('CREATED','FORWARDED')";
$get_all_document_data = $con->prepare($get_all_document_sql);
$get_all_document_data->execute();  
  
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

//select all incoming documents
$get_all_doctype_sql = "SELECT * FROM document_type";
$get_all_doctype_data = $con->prepare($get_all_doctype_sql);
$get_all_doctype_data->execute();  



?>

<body class="hold-transition sidebar-mini">

<div class="float-topright">
                <?php echo $alert_msg; ?>
            </div>

<div class="wrapper">

  <!-- Navbar -->

  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php  
    
       include ('includes/nav-bar.php');
       include ('includes/aside.php');
         include ('includes/dashboard.php');
   ?>
   
  <!-- Content Wrapper. Contains page content -->
  

  <!-- Content Wrapper. Contains page content -->
  <!-- <div class="content-wrapper"> -->
  <div class="card">
            <div class="card-header">
              <h3 class="card-title">Incoming Documents</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="users" class="table table-bordered table-striped">
                 
                  <thead>
                    <tr>
                <th>Document No.</th>
                <th>Date</th>
                <th>Type</th>
                <th>OBR No.</th>
                <th>DV No.</th>
                <th>Payee</th>
                <th>Particulars</th>
                <th>Amount</th>
                <th>Origin</th>
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
       <!-- modal here delete -->
       <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Print Routing Slip</h4>
              </div>
              <form method="POST" action="<?php htmlspecialchars("PHP_SELF")?>">
                <div class="modal-body">  
                  <div class="box-body">
                    <div class="form-group">
                    <label>Please enter Document Number:</label>
                    <input type="text" name="modal_docno" id="modal_docno" class="form-control" value="<?php echo
                    $docno; ?>" required>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                    
                  <button type="button" class="btn btn-default pull-left bg-olive" data-dismiss="modal">No</button>
                  <!-- <button type="submit" name="delete_user" class="btn btn-danger">Yes</button> -->
                  <a href= "javascript:;" onclick ="this.href='../plugins/TCPDF/User/routing.php?docno=' + document.getElementById('modal_docno').value" target="blank">
                  <input type="button" name="delete_user" class="btn btn-danger" value="Yes">
                </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->


  </div>
   <!-- /.content -->
   </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2019 ITCSO <a href="http://lguscc.gov.ph">Local Government of San Carlos City</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 2.0.0-alpha
    </div>
  </footer>

  <!-- Control Sidebar -->
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
  <div class="modal-header">
                <h5 class="modal-title">SETTINGS</h5>
              </div>
          
              <div class="modal-body" <?php if ($department == 'CBO' || $department == 'ACCTG'){?> style="visibility:visible" <?php } else { ?>  style = "display:none" <?php }?>>  
                  <div class="box-body" >
                    <div class="form-group">
                    <h6 class="modal-title">Please enter Document No.:</h6>
                    <input type="text" name="docno" id="docno" class="form-control">
                    </div>

                    <div class="form-group">
                    <label>Date:</label>
                    <label id="lblDate"></label>
                    </div>
                    <div class="form-group">
                    <label>Type:</label>
                    <label id="lblType"></label>
                    </div>
                    <div class="form-group">
                    <label>Change Document Type:</label>
                    <label id="lblRemarks"></label>
                    <div class="col-md-14">
                                                <select  class="form-control select2" id="select_type" readonly style="width: 100%;" name="type" value="<?php echo
$type; ?>">
                                                    <option>Please select...</option>
                                                    <?php while ($get_doctype = $get_all_doctype_data->fetch(PDO::FETCH_ASSOC)) { ?>

<?php
    //if $get_author naa value, check nato if equals sa $get_author1['fullname']
    //if equals, put 'selected' sa option
    $selected = ($type == $get_doctype['objid'])? 'selected':'';

?>

<option <?=$selected;?> value="<?php echo $get_doctype['objid']; ?>"><?php echo $get_doctype['description']; ?></option>
<?php } ?>
                                            </select>
                                        </div>
                    </div>

                    <div class="box-footer" align="center">
                    <input type="button" id = "change" name="submit" class="btn btn-success" value="CHANGE">       
</div>

                    <!-- <div class="form-group">
                    <h5 class="blinking"  id="lblMessage"> </h5>
                    </div> -->

                  </div>
                </div>
  </aside>
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- datepicker -->
<script src="../plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="../dist/js/demo.js"></script> -->
<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.js"></script>
<script src="../plugins/select2/select2.full.min.js"></script>
<script src="../plugins/datatables/dataTables.bootstrap4.js"></script>

<script>
  		$(document).ready(function() {
        $('.select2').select2()

        var office = $('#department').val();
				var dataTable = $('#users').DataTable( {
					"processing": true,
					"serverSide": true,
          "scrollX": true,
					"ajax":{
						url :"track_incoming.php", // json datasource
            data:{office:office},
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
                "defaultContent": '<button class=\"receive btn btn-outline-success btn-xs \" ><i class="fa fa-download" aria-hidden= "true"></i></button>'
          
         
              }],
				} );

        $('#users tbody').on( 'click', 'button.receive', function() {
          // alert ('hello');
         // var row = $(this).closest('tr');
         var table = $('#users').DataTable();
         var data = table.row( $(this).parents('tr') ).data();
        //  alert (data[0]);
        //  var data = $('#users').DataTable().row('.selected').data(); //table.row(row).data().docno;
          var type = data[2];
          var docno = data[0];
         
          if (type=="DV" || type=="OBR" || type=="DWP" || type == "PYL" || type == "LR" || type == "RIS" || type == "PO"  || type == "PR") {
              window.open("receive_incoming_dv.php?docno=" + docno, '_parent');
          } else  {
         
              window.open("receive_incoming.php?docno=" + docno,'_parent');
        }
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

    $('#docno').on('change',function(){
  
  // function receive(){
             var docno = document.getElementById("docno").value;
           
            // alert (docno);
         
            $.ajax({
              type:'POST',
              data:{docno:docno},
              url:'scan_receive.php',
               success:function(data){
                var result = $.parseJSON(data);
                // alert(result.type)
                 document.getElementById('lblDate').innerHTML = result.date;
                 document.getElementById('lblType').innerHTML = result.type;
                 document.getElementById('lblParticulars').innerHTML = result.particulars;
                 document.getElementById('lblOrigin').innerHTML = result.origin;
                //  document.getElementById('lblRemarks').innerHTML = result.remarks;
                //  document.getElementById('lblMessage').innerHTML = result.message;

               }
            
                });   
              
                document.getElementById('scan_receive').focus();
                document.getElementById('scan_receive').select();
               
                //
              
              
    });

    
    $('#change').on('click',function(){
  
  // function receive(){
             var type = document.getElementById("select_type").value;
             var docno = document.getElementById("docno").value;
            //  alert (docno);
         
            $.ajax({
              type:'POST',
              data:{docno:docno,type:type},
              url:'update_type.php',
               success:function(data){
                var result = $.parseJSON(data);
               alert(data)
                //  document.getElementById('lblDate').innerHTML = result.date;
                //  document.getElementById('lblTime').innerHTML = result.time;
                //  document.getElementById('lblType').innerHTML = result.type;
                //  document.getElementById('lblParticulars').innerHTML = result.particulars;
                //  document.getElementById('lblOrigin').innerHTML = result.origin;
                //  document.getElementById('lblDestination').innerHTML = result.destination;
                //  document.getElementById('lblRemarks').innerHTML = result.remarks;
                //  document.getElementById('lblMessage').innerHTML = result.message;

               }
            
                });   
              
                // document.getElementById('scan_track').focus();
                // document.getElementById('scan_track').select();
               
                //
              
                location.reload();
    });         

          
</script> 

</body>
</html>
