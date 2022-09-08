<?php


session_start();

$objid = $code = $name_supplier = $owner  = $address = $contact_no = $contact_person= $fax_no =$telephone_no = $others = $product_lines= '';
$btnNew = 'disabled';
$btnStatus = '';

include ('includes/head.php');

if (!isset($_SESSION['id'])) {
    header('location:../index');
}
$user_id = $_SESSION['id'];

include ('../config/db_config.php');
include ('update_for_suppliers.php');



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

$get_suppliers_sql = "SELECT * FROM tbl_suppliers WHERE objid = :objid";
$suppliers_data = $con->prepare($get_suppliers_sql);
$suppliers_data->execute([':objid' => $objid]);
while ($result = $suppliers_data->fetch(PDO::FETCH_ASSOC)) {
    $objid = $result['objid'];
    $code = $result['code'];
    $name_supplier = $result['name_supplier'];
    $owner = $result['owner'];
    $product_lines = $result['product_lines'];
    $address = $result['address'];
    $contact_no = $result['contact_no'];
    $contact_person = $result['contact_person'];
    $telephone_no = $result['tel_no'];
    $fax_no = $result['fax_no'];
    $others = $result['others'];

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
              <h3 class="card-title">Update Supplier</h3>
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
                   <label>Objid:</label>
                  </div>
                  <div class="col-md-10">
                      <input type="text" readonly class="form-control" name="objid" placeholder="ID" value="<?php echo
$objid; ?>" required>
                  </div>
                </div><br>

                
                
                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Code:</label>
                  </div>
                  <div class="col-md-10">
                      <input type="text" class="form-control" name="code" placeholder="Supplier Code" value="<?php echo
$code; ?>" required>
                  </div>
                </div><br>

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Name of Supplier:</label>
                  </div>
                  <div class="col-md-10">
                      <input type="text" class="form-control" name="name_supplier" placeholder="Name of Supplier" value="<?php echo
$name_supplier; ?>" required>
                  </div>
                </div><br>

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Proprietor/Owner</label>
                  </div>
                  <div class="col-md-10">
                      <input type="text" class="form-control" name="owner" placeholder="Proprietor/Owner" value="<?php echo
$owner; ?>" required>
                  </div>
                </div><br>

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Product Line:</label>
                  </div>
                  <div class="col-md-10">
                      <textarea rows="5" class="form-control" name="product_line" placeholder="Product Line"  required><?php echo
$product_lines; ?></textarea>
                  </div>
                </div><br>


                
                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Address:</label>
                  </div>
                  <div class="col-md-10">
                      <textarea rows="2" class="form-control" name="address" placeholder="Business Address"  required><?php echo
$address; ?></textarea>
                  </div>
                </div><br>

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Authorized Representative:</label>
                  </div>


                  <div class="col-md-10">
                      <input type="text" class="form-control" name="contact_person" placeholder="Authorized Representative" value="<?php echo
$contact_person; ?>" required>
                  </div>
                </div><br>

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Mobile No.:</label>
                  </div>


                  <div class="col-md-10">
                      <input type="text" class="form-control" name="contact_no" placeholder="Mobile Number" value="<?php echo
$contact_no; ?>" required>
                  </div>
                </div><br>

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Telephone No.:</label>
                  </div>


                  <div class="col-md-10">
                      <input type="text" class="form-control" name="telephone_no" placeholder="Telephone Number" value="<?php echo
$telephone_no; ?>" required>
                  </div>
                </div><br>
              


                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Fax No.:</label>
                  </div>


                  <div class="col-md-10">
                      <input type="text" class="form-control" name="fax_no" placeholder="Fax No." value="<?php echo
$fax_no; ?>" required>
                  </div>
                </div><br>

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Others:</label>
                  </div>
                  <div class="col-md-10">
                      <textarea rows="5" class="form-control" name="others" placeholder="Others"  required><?php echo
$others; ?></textarea>
                  </div>
                </div><br>

        
             
              <!-- /.box-body -->
              <div class="box-footer" align="center">
            
                <input type="submit"  <?php echo $btnStatus; ?> name="update_suppliers" class="btn btn-primary" value="Save">
               
                <a href="list_suppliers">
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

  <!-- footer here -->
    <footer class="main-footer">
      <div class="pull-right hidden-xs">
      <b>Version</b> 1.0
      </div>
      <strong>Copyright &copy; <?php echo 2018; ?>.</strong> All rights
      reserved.
    </footer>
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


</script>


</body>
</html>