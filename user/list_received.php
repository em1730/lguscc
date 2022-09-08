<?php

session_start();
include ('includes/head.php');

if (!isset($_SESSION['id'])) {
  header('location:../index.php');
}

$user_id = $_SESSION['id'];

include('../config/db_config.php');
include('delete.php');
include ('update_forward.php');
include ('insert_forward.php');


$get_user_sql = "SELECT * FROM tbl_users WHERE user_id = :id";
$get_user_data = $con->prepare($get_user_sql);
$get_user_data->execute([':id'=>$user_id]);
while ($result = $get_user_data->fetch(PDO::FETCH_ASSOC)) {

$user_name = $result['username'];
$GLOBALS['department'] = $result['department'];
$db_first_name = $result['first_name'];
$db_middle_name = $result['middle_name'];
$db_last_name = $result['last_name'];
$db_email_ad = $result['email'];
$db_contact_number = $result['contact_no'];
$db_user_name = $result['username'];
}

//select all departments
$get_all_dept_sql = "SELECT * FROM tbl_department";
$get_all_dept_data = $con->prepare($get_all_dept_sql);
$get_all_dept_data->execute();  

//select all outgoing documents
$get_all_document_sql = "SELECT * FROM tbl_documents where destination = '$department' and status = 'RECEIVED'";
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


?>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

<?php  
    
    include ('includes/nav-bar.php');
    include ('includes/aside.php');
      include ('includes/dashboard.php');
?>



  <!-- Content Wrapper. Contains page content -->
  <!-- <div class="content-wrapper"> -->
  <div class="card">
            <div class="card-header">
              <h3 class="card-title">Received Documents</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="users" class="table table-bordered table-striped">
          
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
      
  <!-- modal here release-->
  <div class="modal fade" id="release_Modal" role="dialog" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Confirm Release</h4>
              </div>
              <form method="POST" action="<?php htmlspecialchars("PHP_SELF")?>">
                <div class="modal-body">  
                  <div class="box-body">
                    <div class="form-group">
                    <label>Release Record?</label>
                    <input type="text" name="user_id" id="user_id" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">

                  <button type="button" class="btn btn-default pull-left bg-olive" data-dismiss="modal">No</button>
                  <!-- <button type="submit" name="delete_user" class="btn btn-danger">Yes</button> -->
                  <input type="submit" name="insert_forward" class="btn btn-danger" value="Yes">
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
  <footer class="main-footer">
    <strong>Copyright &copy; 2019 ITCSO <a href="http://lguscc.gov.ph">Local Government of San Carlos City</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 2.0.0-alpha
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
  <div class="modal-header">
                <h5 class="modal-title">RELEASE DOCUMENTS</h5>
                  </div>
          
                  <div class="modal-body">  
                
              
                    <label>Forwarded To:</label>
                    <select class="form-control select2"  style="width: 100%;" name="receiver" id="destination" value="<?php echo $destination; ?>">
                              <option>Please select...</option>
                              <?php while ($get_dept = $get_all_dept_data->fetch(PDO::FETCH_ASSOC)) { ?>
                              <?php
                              //if $get_author naa value, check nato if equals sa $get_author1['fullname']
                              //if equals, put 'selected' sa option
                              $selected = ($origin == $get_dept['objid'])? 'selected':'';
                              ?>
                              <option <?=$selected;?> value="<?php echo $get_dept['objid']; ?>"><?php echo $get_dept['department']; ?></option>
                              <?php } ?>
                    </select>
                    </div>
                    <div class="modal-body">  
                    <div class="box-body">
                    <div class="form-group">
                    <h6  class="modal-title">Remarks:</h6>
                    <input type="text" name="remarks" id="remarks" class="form-control">
                    </div>
                    <div class="form-group">
                    <h6 class="modal-title">Please scan/enter barcode:</h6>
                    <input type="text" name="scan_release" id="scan_release" class="form-control">
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
                    <label>Particulars:</label>
                    <label id="lblParticulars"></label>
                    </div>                   
                    <div class="form-group">
                    <label>Origin:</label>
                    <label id="lblOrigin"></label>
                    </div>
                    <!-- <div class="form-group">
                    <label>Remarks:</label>
                    <label id="lblRemarks"></label>
                    </div> -->

                    <div class="form-group">
                    <h5 class="blinking"  id="lblMessage"> </h5>
                    </div>

                  </div>
                </div>

                    
                    
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<!-- <script src="../dist/css/jquery-ui.min.js"></script> -->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  // $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Morris.js charts -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script> -->
<!-- <script src="../plugins/morris/morris.min.js"></script> -->
<!-- Sparkline -->
<!-- <script src="../plugins/sparkline/jquery.sparkline.min.js"></script> -->
<!-- jvectormap -->
<!-- <script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script> -->
<!-- <script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script> -->
<!-- jQuery Knob Chart -->
<!-- <script src="../plugins/knob/jquery.knob.js"></script> -->
<!-- daterangepicker -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script> -->
<!-- <script src="../plugins/daterangepicker/daterangepicker.js"></script> -->
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
<script src="../plugins/datatables/dataTables.bootstrap4.js"></script>
<!-- Select2 -->
<script src="../plugins/select2/select2.full.min.js"></script>




<script>


$('#scan_release').on('change',function(){
  
  // function receive(){
             var docno = document.getElementById("scan_release").value;
             var destination = document.getElementById("destination").value;
             var remarks = document.getElementById("remarks").value;
           
             if (remarks==""){
            alert ("Please enter remarks.");
            document.getElementById('remarks').select();
            document.getElementById('remarks').focus();
               
            } else {

            $.ajax({
              type:'POST',
              data:{docno:docno, destination:destination, remarks:remarks},
              url:'scan_release.php',
               success:function(data){
                var result = $.parseJSON(data);
                // alert(result.type)
                 document.getElementById('lblDate').innerHTML = result.date;
                 document.getElementById('lblType').innerHTML = result.type;
                 document.getElementById('lblParticulars').innerHTML = result.particulars;
                 document.getElementById('lblOrigin').innerHTML = result.origin;
                //  document.getElementById('lblRemarks').innerHTML = result.remarks;
                 document.getElementById('lblMessage').innerHTML = result.message;

               }
            
                });   
             
                document.getElementById('scan_release').focus();
                document.getElementById('scan_release').select();
            
                  }    //
              
              
    });
    
  		$(document).ready(function() {
        var office = $('#department').val();
				var dataTable = $('#users').DataTable( {
					"processing": true,
					"serverSide": true,
					"ajax":{
						url :"track_received.php", // json datasource
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
                "defaultContent": '<button class=\"release btn btn-outline-success btn-xs \" ><i class="fa fa-share" aria-hidden= "true"></i></button><button class=\"archive btn btn-outline-success btn-xs \" ><i class="fa fa-archive" aria-hidden= "true"></i></button>'
          
         
              }],
             
				} );

        $('#users tbody').on( 'click', 'button.release', function() {
          // alert ('hello');
         // var row = $(this).closest('tr');
         var table = $('#users').DataTable();
         var data = table.row( $(this).parents('tr') ).data();
        //  alert (data[0]);
        //  var data = $('#users').DataTable().row('.selected').data(); //table.row(row).data().docno;
          var docno = data[0];
          window.open("release_document.php?docno=" + docno,'_parent');
       // alert(docno);
          
        });
		

      $('#users tbody').on( 'click', 'button.archive', function() {
          // alert ('hello');
         // var row = $(this).closest('tr');
         var table = $('#users').DataTable();
         var data = table.row( $(this).parents('tr') ).data();
        //  alert (data[0]);
        //  var data = $('#users').DataTable().row('.selected').data(); //table.row(row).data().docno;
          var docno = data[0];
          window.open("archive_document.php?docno=" + docno,'_parent');
       // alert(docno);
          
        });
			});
     
    $(document).on('click', 'button[data-role=confirm_delete]', function(event){
      event.preventDefault();

      var user_id = ($(this).data('id'));

      $('#user_id').val(user_id);
      $('#deleteuser_Modal').modal('toggle');

    })

    $('div.dataTables_filter input').focus();

    $(document).on('click', 'button[data-role=confirm_delete]', function(event){
      event.preventDefault();

      var user_id = ($(this).data('id'));

      $('#user_id').val(user_id);
      $('#deleteuser_Modal').modal('toggle');

    })

    $(document).on('click', 'button[data-role=confirm_release]', function(event){
      event.preventDefault();

      var docno = ($(this).data('id'));

      $('#user_id').val(docno);
      $('#release_Modal').modal('toggle');

    })

    $(function() {
                //Initialize Select2 Elements
                $('.select2').select2()

                //Datemask dd/mm/yyyy
                $('#datemask').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'})
                //Datemask2 mm/dd/yyyy
                $('#datemask2').inputmask('mm/dd/yyyy', {'placeholder': 'mm/dd/yyyy'})
                //Money Euro
                $('[data-mask]').inputmask()

                //Date range picker
                $('#reservation').daterangepicker()
                //Date range picker with time picker
                $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'})
                //Date range as a button
                $('#daterange-btn').daterangepicker(
                        {
                            ranges: {
                                'Today': [moment(), moment()],
                                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                                'This Month': [moment().startOf('month'), moment().endOf('month')],
                                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                            },
                            startDate: moment().subtract(29, 'days'),
                            endDate: moment()
                        },
                function(start, end) {
                    $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
                )

                //Date picker
                $('#datepicker').datepicker({
                    autoclose: true
                    
                })

                //iCheck for checkbox and radio inputs
                $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                    checkboxClass: 'icheckbox_minimal-blue',
                    radioClass: 'iradio_minimal-blue'
                })
                //Red color scheme for iCheck
                $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                    checkboxClass: 'icheckbox_minimal-red',
                    radioClass: 'iradio_minimal-red'
                })
                //Flat red color scheme for iCheck
                $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass: 'iradio_flat-green'
                })

                //Colorpicker
                $('.my-colorpicker1').colorpicker()
                //color picker with addon
                $('.my-colorpicker2').colorpicker()

                //Timepicker
                $('.timepicker').timepicker({
                    showInputs: false
                })
            })

</script> 

</body>
</html>
