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



$alert_msg = '';
$docno = $date = $type= $particulars = $origin = $destination = $amount = $status = $date_received = $remarks = $user_name = $storage = $folder = '';
$btnNew = 'disabled';
$btnStatus = '';

$now = new DateTime();



include ('../config/db_config.php');
// include ('update_forward.php');
// include ('insert_forward.php');
include ('insert_archive.php');




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
  $received_count =  $result1['total'];
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

//select all data type
$get_all_document_sql = "SELECT * FROM document_type";
$get_all_document_data = $con->prepare($get_all_document_sql);
$get_all_document_data->execute();  

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
    $particulars = $result['particulars']; 
    $origin= $result['origin']; 
    //$amount= $result['amount'];
    $status = $result['status'];
    $remarks = $result['remarks'];
  
  }
}
  
?>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

<?php  
      include ('includes/nav-bar.php');
      include ('includes/aside.php');
   
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
  

    <!-- Main content -->
    <section class="content">
    <div class="card">
            <div class="card-header">
              <h3 class="card-title">Archive Documents</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

             
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" enctype="multipart/form-data" method="post" action="<?php htmlspecialchars("PHP_SELF"); ?>">
              <div class="box-body">
                <?php echo $alert_msg; ?>
                
                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Document No.:</label>
                  </div>
                  <div class="col-md-10">
                      <input type="text" readonly class="form-control" name="doc_number" placeholder="Document Number" value="<?php echo
$docno; ?>" required>
                  </div>
                </div><br>

                <div class="row">
                                            <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                                <label>Date:</label>
                                            </div>
                                            <div class="col-md-10">
                                                <!-- Date -->
                                                <div class="form-group">
                                                    <!-- <label>Date:</label> -->
                                                    <div class="input-group date" data-provide="datepicker" >
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" readonly class="form-control pull-right" id="datepicker" name="date" placeholder="Date Created" value="<?php echo $date; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div><br>

                                        <div class="row">
                                            <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                                <!-- <div class="form-group"> -->
                                                <label>Document Type:</label>
                                            </div>
                                                                                     
                                            <div class="col-md-10">
                                                <select class="form-control select2" readonly style="width: 100%;" name="type" value="<?php echo
$type; ?>">
                                                    <option>Please select...</option>
                                                    <?php while ($get_doctype = $get_all_document_data->fetch(PDO::FETCH_ASSOC)) { ?>

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


                                        <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Subject/Particulars:</label>
                  </div>
                  <div class="col-md-10">
                      <textarea rows="5" readonly class="form-control" name="particulars" placeholder="Subject/Particulars"  required><?php echo $particulars; ?></textarea>
                  </div>
                </div><br>

               
                                      

                                        <div class="row">
                                        <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Remarks:</label>
                  </div>
                  <div class="col-md-10">
                      <textarea rows="5" class="form-control" name="remarks" placeholder="Remarks"  required><?php echo
$remarks; ?></textarea>
                  </div>
                </div><br>  

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Storage / Cabinet No.:</label>
                  </div>
                  <div class="col-md-10">
                      <input type="text"   class="form-control" id="storage" name="storage"  placeholder="Storage / Cabinet Number" value="<?php echo
$storage; ?>" >
                  </div>
                </div><br>

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Folder Label/No.:</label>
                  </div>
                  <div class="col-md-10">
                      <input type="text"  class="form-control" id="folderno" name="folderno"  placeholder="Folder Label / Number" value="<?php echo
$folder; ?>" required>
                  </div>
                </div><br>


                <div class="card-body">
                 <div class="row">
                     <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                         <label>Upload File</label>
                     </div>
                     <div class="col-md-10">
                          <input type ="file" name="myFile" id="fileToUpload">
                          <p class="help-block">Upload .pdf file only.</p>
                     </div>
                 </div>
               </div>

                                        <!-- /.box-body -->
                                        <div class="box-footer" align = "center">
                                            <!-- <input type="submit"  <?php echo $btnNew; ?> name="add" class="btn btn-primary" value="New"> -->
                                            <input type="submit"  <?php echo $btnStatus; ?> name="insert_archive" class="btn btn-primary" value="Archive">
                                            <a href="ordinance">
                                                <input type="button" name="cancel" class="btn btn-default" value="Cancel">       
                                            </a>
                                        </div>
                           
                            </div>
                            <!-- /.box -->
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <?php include ('includes/footer.php');?>


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


        $('#select_type').on('change',function(){
             var type = $(this).val();
            //  $('#doc_no').val(type);
      
         
            $.ajax({
              type:'POST',
              data:{type:type},
              url:'generate_serial.php',
               success:function(data){
             $('#doc_no').val(data);


            } 
                 
                });           
                        
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