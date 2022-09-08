<?php


session_start();

include ('includes/head.php');


if (!isset($_SESSION['id'])) {
  header('location:../index.php');
}

$user_id = $_SESSION['id'];



$alert_msg = '';
$docno = $pr_no = $po_no = $etal = $date = $type= $particulars = $origin = $destination = $obr_no = $account = $dv_no = $cheque_no =$acct_no = $payee=  $status = $date_received = $remarks = $user_name = '';

$amount  = "0.00";
$btnNew = 'disabled';
$btnPrint = 'disabled';
$btnStatus = '';

$now = new DateTime();


include('../config/db_config.php');
include ('update_forward_dv.php'); //for tbl_documents and tbl_dv
include ('insert_forward_dv.php'); //for tbl_ledger

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
    $user_name = $result['username'];
    $department= $result['department'];
}

if (isset($_GET['docno'])) {
  $docno = $_GET['docno'];
//select all incoming documents
$get_all_incoming_sql = "SELECT * FROM tbl_documents where docno = :doc";// and destination = '$department'";
$get_all_incoming_data = $con->prepare($get_all_incoming_sql);
$get_all_incoming_data->execute([':doc' => $docno]);  
while ($result = $get_all_incoming_data->fetch(PDO::FETCH_ASSOC)) {
  $docno = $result['docno'];
  $date = $result['date'];
  $type = $result['type']; 
  $obr_no = $result['obrno'];
  $account = $result['acctype'];
  $dv_no = $result['dvno'];
  $account_no = $result['acctno'];
  $cheque_no = $result['chequeno'];
  $payee = $result['payee'];
  $etal = $result['etal'];
  $particulars = $result['particulars']; 
  $origin= $result['origin']; 
  $amount= $result['amount'];
  $status = $result['status'];
  $remarks = $result['remarks'];

}
}


//select all incoming documents
$get_all_doctype_sql = "SELECT * FROM document_type";
$get_all_doctype_data = $con->prepare($get_all_doctype_sql);
$get_all_doctype_data->execute();  
  



//select all departments
$get_all_dept_sql = "SELECT * FROM tbl_department";
$get_all_dept_data = $con->prepare($get_all_dept_sql);
$get_all_dept_data->execute();  

//select all payee
$get_all_payee_sql = "SELECT code, name_supplier from tbl_suppliers 
UNION
select objid, CONCAT(firstname, ' ', middlename, ' ', lastname) from tbl_joborder 
UNION
select employeeno, CONCAT(firstname, ' ', middlename, ' ', lastname) from tbl_employee
ORDER BY name_supplier";


$get_all_payee_data = $con->prepare($get_all_payee_sql);
$get_all_payee_data->execute();  
//select all account type
$get_all_account_sql = "SELECT * FROM tbl_accounts";
$get_all_account_data = $con->prepare($get_all_account_sql);
$get_all_account_data->execute();  

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
    //include ('includes/dashboard.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
  

    <section class="content">
      <div class="container-fluid">
     <div class="col-sm-6">
            <h1></h1>
          </div>
        <div class="row">
          <!-- left column -->
          <div class="col-md-12 ">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Release Documents</h3>
              </div>
          
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="<?php htmlspecialchars("PHP_SELF"); ?>">
              <div class="box-body">
              <div class="col-sm-6">
            <h1></h1>
          </div>
                <?php echo $alert_msg; ?>
                
               <!-- form document no & date -->
        <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
             
                   <label>Document No.:</label>
                  </div>
                  <div class="col-md-4">
                      <input type="text" readonly  class="form-control" id="doc_no" name="doc_no"  placeholder="Document Number" value="<?php echo
$docno; ?>" required>
                  </div>

                  <div class="col-md-1" style="text-align: right;padding-top: 5px;">
                                                <label>Date:</label>
                                            </div>
                                            <div class="col-md-4">
                                                <!-- Date -->
                                                <div class="form-group">
                                                    <!-- <label>Date:</label> -->
                                                    <div class="input-group date" data-provide="datepicker" >
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control pull-right" id="datepicker" name="date" placeholder="Date Created" value="<?php echo
$now->format('m/d/Y');; ?>">
                                                    </div>
                                                </div>
                                            </div>
                </div><br>
<!-- form document no & date -->


                                        <div class="row">
                                            <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                                <!-- <div class="form-group"> -->
                                                <label>Document Type:</label>
                                            </div>
                                                                                     
                                            <div class="col-md-4">
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
                                      
                                    </div><br>

 <!-- for PR & PO -->
 <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>PR No.:</label>
                  </div>
                  <div class="col-md-4">
                      <input type="text" <?php if ($type != 'PR'){?> readonly <?php } ?>  class="form-control" id="pr_no" name="pr_number"  placeholder="PR Number" value="<?php echo
$pr_no; ?>" >
                  </div>

                  <div class="col-md-1" style="text-align: right;padding-top: 5px;">
                   <label>PO No.:</label>
                  </div>
                  <div class="col-md-4">
                      <input type="text" <?php if ($type != 'PO'){?> readonly <?php } ?>    class="form-control" id="po_no" name="po_number"  placeholder="PO Number" value="<?php echo
$po_no; ?>" >
                  </div>
                </div><br>

<!-- for PR & PO -->


                                  
                                    <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>OBR No.:</label>
                  </div>
                  <div class="col-md-4">
                                  
                      <input type="text" <?php if ($department != 'CBO'){?> readonly <?php } ?>  class="form-control" id="obr_no" name="obr_number"  placeholder="OBR Number" value="<?php echo
$obr_no; ?>">
                  </div>
                </div><br>

                    <div class="row">
                
                <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                                <!-- <div class="form-group"> -->
                                                <label>Fund:</label>
                                            </div>
                                                                                     
                                            <div class="col-md-4">
                                                <select class="form-control select2" <?php if ($department != 'ACCTG'){?> readonly <?php } ?> style="width: 100%;" id="select_account" name="account"  value="<?php echo $account; ?>">
                                                   <option>Please select...</option>
                                                    <?php while ($get_account = $get_all_account_data->fetch(PDO::FETCH_ASSOC)) { ?>

<?php
    //if $get_author naa value, check nato if equals sa $get_author1['fullname']
    //if equals, put 'selected' sa option
    $selected = ($account == $get_account['code'])? 'selected':'';

?>

<option <?=$selected;?> value="<?php echo $get_account['code']; ?>"><?php echo $get_account['account']; ?></option>
<?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-1" style="text-align: right;padding-top: 5px;">
                   <label>DV No.:</label>
                  </div>
                  <div class="col-md-4">
                      <input type="text"  <?php if ($department != 'ACCTG'){?> readonly <?php } ?> class="form-control" id="dv_no" name="dv_number"  placeholder="DV Number" value="<?php echo
$dv_no; ?>" >
                  </div>
                                    </div><br>

      <div class="row">
                <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Account No.:</label>
                  </div>
                  <div class="col-md-4">
                      <input type="text" <?php if ($department != 'CTO'){?> readonly <?php } ?> class="form-control" id="acct_no" name="acct_number"  placeholder="Account Number" value="<?php echo
$acct_no; ?>">
                  </div>
                  <div class="col-md-1" style="text-align: right;padding-top: 5px;">
                   <label>Cheque No.:</label>
                  </div>
                  <div class="col-md-4">
                      <input type="text" <?php if ($department != 'CTO'){?> readonly <?php } ?> class="form-control" id="cheque_number" name="cheque_number"  placeholder="Cheque Number" value="<?php echo
$cheque_no; ?>">
                  </div>
                </div><br>

              


                <div class="row">
                                            <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                                <!-- <div class="form-group"> -->
                                                <label>Payee:</label>
                                            </div>
                                                                                     
                                            <div class="col-md-8">
                                                <select class="form-control select2" readonly style="width: 100%;" name="payee" value="<?php echo $payee; ?>">
                                                   <option>Please select...</option>
                                                    <?php while ($get_payee = $get_all_payee_data->fetch(PDO::FETCH_ASSOC)) { ?>

<?php
    //if $get_author naa value, check nato if equals sa $get_author1['fullname']
    //if equals, put 'selected' sa option
    $selected = ($payee == $get_payee['name_supplier'])? 'selected':'';

?>

<option <?=$selected;?> value="<?php echo $get_payee['name_supplier']; ?>"><?php echo $get_payee['name_supplier']; ?></option>
<?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-check">           
                    &nbsp; &nbsp;<input <?php if ($etal == 1) echo 'checked="checked"'; ?> type="checkbox" class="form-check-input" id="exampleCheck1" name="etc" value="etal">
                    <label class="form-check-label" for="exampleCheck1">et Al.</label>             
                    </div>               
                                    </div><br>


                                    <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Particulars:</label>
                  </div>
                  <div class="col-md-9">
                      <textarea rows="3" class="form-control" name="particulars" placeholder="Subject/Particulars"  required><?php echo
$particulars; ?></textarea>
                  </div>
                </div><br>

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Amount:</label>
                  </div>
                  <div class="col-md-4">
                      <input required type="text" class="form-control" id="amount" name="amount"  placeholder="Amount" value="<?php echo
number_format($amount,2); ?>" required>
                  </div>
                  <p>NOTE: <code>Numbers & decimal point only, do not use comma (,)</code></p>
                </div><br>

                <div class="row">
                                            <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                                <!-- <div class="form-group"> -->
                                                <label>Forwarded To:</label>
                                            </div>
                                                                                     
                                            <div class="col-md-9">
                                                <select class="form-control select2" readonly style="width: 100%;" name="receiver" value="<?php echo $destination; ?>">
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
                                    </div><br>

                                    <div class="row">
                                            <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                                <label>Date Received:</label>
                                            </div>
                                            <div class="col-md-9  ">
                                                <!-- Date -->
                                                <div class="form-group">
                                                    <!-- <label>Date:</label> -->
                                                    <div class="input-group date" data-provide="datepicker" >
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control pull-right" id="datepicker" name="date" placeholder="Date Created" value="<?php echo
$now->format('m/d/Y');; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div><br>

                                        <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Remarks:</label>
                  </div>
                  <div class="col-md-10">
               
                      <input type="text" required  class="form-control" name="remarks" placeholder="Remarks"  value="<?php echo
$remarks; ?>">
                  </div>
                </div><br>        
                <div class="box-footer" align="center">
          
              
          <input type="submit"  <?php echo $btnStatus; ?> name="insert_forward" class="btn btn-primary" value="Release">
            <a href="list_received.php">
              <input type="button" name="cancel" class="btn btn-default" value="Close">       
            </a>
          </div>
                  <div class="col-md-9">
                      <input type="hidden" readonly id="department" class="form-control" name="department" placeholder="Department" value="<?php echo
$department; ?>" required>
                  </div>
                </div><br>

                <div class="col-md-10">
                      <input type="hidden" readonly class="form-control" name="username" placeholder="username" value="<?php echo
$user_name; ?>" required>
                  </div>
                </div><br>
             
              <!-- /.box-body -->
             
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

   
<!
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
                $(document).ajaxStart(function() {
                    Pace.restart()
                })


       

            });

           
   } 
                 
  });       

        </script>


        <script>

// $('#select_account').on('change',function(){
//   // var type = $('#select_type').val();
//   var account = $(this).val();
//   var office = $('#department').val();
         
//             $.ajax({
//               type:'POST',
//               data:{account:account, office:office},
//               url:'generate_dv.php',
//                success:function(data){
//             $('#dv_no').val(data);


//             } 
                 
//                 });           
                        
//                       });

        // $('#select_type').on('change',function(){
        //      var type = $(this).val();
        //     //  $('#doc_no').val(type);
      
         
        //     $.ajax({
        //       type:'POST',
        //       data:{type:type},
        //       url:'generate_serial.php',
        //        success:function(data){
        //      $('#doc_no').val(data);


        //     } 
                 
        //         });           
                        
        //               });

    
              
$(function(){
  // var type = $('#select_type').val();
  // var office = $('#department').val();
  // var obr = $('#obr_no').val();

  // $.ajax({
  //   type:'POST',
  //   data:{type:type,office:office,obr:obr},
  //   url:'generate_obr.php',
  //   success:function(data){
  //     // var result = $.parseJSON(data);
  //    // $('#doc_no').val(result.docno);
  //     $('#obr_no').val(data);
    
  //   }
  // });

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