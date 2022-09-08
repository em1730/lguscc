<?php


session_start();


$objid = $department =  $status  = $fname = $last = $middle= $idnumber= $control= $rate='';
$btnNew = 'disabled';
$btnStatus = '';

include ('includes/head.php');
if (!isset($_SESSION['id'])) {
    header('location:../index');
}
$user_id = $_SESSION['id'];

include ('../config/db_config.php');
include ('update_for_joborders.php');

//select user
$get_user_sql = "SELECT * FROM tbl_users WHERE user_id = :id";
$user_data = $con->prepare($get_user_sql);
$user_data->execute([':id' => $user_id]);
while ($result = $user_data->fetch(PDO::FETCH_ASSOC)) {
    $db_first_name = $result['first_name'];
    $db_middle_name = $result['middle_name'];
    $db_last_name = $result['last_name'];
    $db_email_ad = $result['email'];
    $db_contact_number = $result['contact_no'];
    $db_user_name = $result['username'];

}
$get_all_department_sql = "SELECT * FROM tbl_department";
$get_all_department_data = $con->prepare($get_all_department_sql);
$get_all_department_data->execute(); 


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
 

if (isset($_GET['objid'])) {
  $objid = $_GET['objid'];

$get_joborder_sql = "SELECT * FROM tbl_joborder WHERE objid = :objid";
$joborder_data = $con->prepare($get_joborder_sql);
$joborder_data->execute([':objid' => $objid]);
while ($result = $joborder_data->fetch(PDO::FETCH_ASSOC)) {
    $objid = $result['objid'];
    $control = $result['controlno'];
    $fname = $result['firstname'];
    $middle = $result['middlename'];
    $last = $result['lastname'];
    $rate = $result['rate'];
    $department = $result['department'];
    $status = $result['status'];

}
}



?>

<?php  
        include ('includes/nav-bar.php');
        include ('includes/aside.php');
    //  include ('includes/dashboard.php');
?>


 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
  

    <!-- Main content -->
    <section class="content">
    <div class="card">
            <div class="card-header">
              <h3 class="card-title">Add Supplier</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
          
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="<?php htmlspecialchars("PHP_SELF"); ?>">
              <div class="box-body">
                <?php echo $alert_msg; ?>
                
                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Job Order ID:</label>
                  </div>
                  <div class="col-md-10">
                      <input type="text" readonly class="form-control" name="objid" placeholder="Job Order ID" value="<?php echo $objid; ?>" required>
                  </div>
                </div><br>
                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Control Number:</label>
                  </div>
                  <div class="col-md-10">
                      <input type="text" class="form-control" name="controlNumber" placeholder="Control Number" value="<?php echo $control; ?>" required>
                  </div>
                </div><br>
                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>First Name:</label>
                  </div>
                  <div class="col-md-10">
                      <input type="text" class="form-control" name="firstname" placeholder="First Name" value="<?php echo $fname; ?>" required>
                  </div>
                </div><br>
                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Middle Name:</label>
                  </div>
                  <div class="col-md-10">
                      <input type="text" class="form-control" name="middlename" placeholder="Middle Name" value="<?php echo $middle; ?>" required>
                  </div>
                </div><br>
                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Last Name:</label>
                  </div>
                  <div class="col-md-10">
                      <input type="text" class="form-control" name="lastname" placeholder="Last Name" value="<?php echo $last; ?>" required>
                  </div>
                </div><br>

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Rate Per Day:</label>
                  </div>
                  <div class="col-md-10">
                      <input type="text" class="form-control" name="rate" placeholder="Rate Per Day" value="<?php echo $rate; ?>" required>
                  </div>
                </div><br>

                <div class="row">
                        <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                                <!-- <div class="form-group"> -->
                                                <label>Department/Office:</label>
                                            </div>
                                                                                     
                                            <div class="col-md-10">
                                                <select class="form-control select2" readonly style="width: 100%;" name="department" value="<?php echo $department; ?>">
                                                   <option>Please select...</option>
                                                    <?php while ($get_dept =$get_all_department_data->fetch(PDO::FETCH_ASSOC)) { ?>

<?php
    //if $get_author naa value, check nato if equals sa $get_author1['fullname']
    //if equals, put 'selected' sa option
    $selected = ($department== $get_dept['objid'])? 'selected':'';

?>

<option <?=$selected;?> value="<?php echo $get_dept['objid']; ?>"><?php echo $get_dept['department']; ?></option>
<?php } ?>
                                            </select>
                                        </div>
                                    </div><br>
                

       <div class="row">
                 <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                                <!-- <div class="form-group"> -->
                                                <label>Status</label>
                                            </div>
                                            <div class="col-md-10">

                                                <select class="form-control select2" style="width: 100%;" name="status" value="<?php echo
$status; ?>">
                                                    <option >Please select...</option>
                                                        <option <?php if ($status == 'Active') echo 'selected'; ?> value="Active">Active </option>
                                                        <option <?php if ($status == 'Inactive') echo 'selected'; ?> value="Inactive">Inactive </option>
              
                                                </select>
                                            </div>
                                        </div><br>
                
                
                                            
              <!-- /.box-body -->
              <div class="box-footer" align="center">
                           <input type="submit"  <?php echo $btnStatus; ?> name="update_jobOrder" class="btn btn-primary" value="Save">
                <a href="list_joborder">
                  <input type="button" name="cancel" class="btn btn-default" value="Close">       
                </a>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-1"></div>
      </div>

      </section>
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
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
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
<script src="../dist/js/demo.js"></script>
<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.js"></script>
<script src="../plugins/datatables/dataTables.bootstrap4.js"></script>
<!-- Select2 -->
<script src="../plugins/select2/select2.full.min.js"></script>
<!-- Page script -->

<script>
$('#users').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true,
      'autoHeight'  : true
    })
  </script>

<script type="text/javascript">

  $(document).ready(function() {

    $(document).ajaxStart(function () {
      Pace.restart()
    })  

  });
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