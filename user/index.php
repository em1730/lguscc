
<?php

include ('../config/db_config.php');

session_start();
$user_id = $_SESSION['id'];
$docno ='';
include ('includes/head.php');

if (!isset($_SESSION['id'])) {
    header('location:../index.php');
} else {

}



//fetch user from database
$get_user_sql = "SELECT * FROM tbl_users where user_id = :id";
$user_data = $con->prepare($get_user_sql);
$user_data->execute([':id' => $user_id]);
while ($result = $user_data->fetch(PDO::FETCH_ASSOC)) {


    $db_first_name = $result['first_name'];
    $db_middle_name = $result['middle_name'];
    $db_last_name = $result['last_name'];
    $db_email_ad = $result['email'];
    $db_contact_number = $result['contact_no'];
    $db_user_name = $result['username'];
    $department = $result['department'];

}



// $get_all_document_sql = "SELECT * FROM tbl_ledger";
// $get_all_document_data = $con->prepare($get_all_document_sql);
// $get_all_document_data->execute();  

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




  <!-- Navbar -->
  
  <!-- /.navbar -->
<?php  
      include ('includes/nav-bar.php');
    include ('includes/aside.php');
      include ('includes/dashboard.php');
?>

   <div class="col-md-20">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Inbox</h3>

              <div class="card-tools">
                <div class="input-group input-group-sm">
                  <input type="text" class="form-control" placeholder="Search Mail">
                  <div class="input-group-append">
                    <div class="btn btn-primary">
                      <i class="fa fa-search"></i>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="mailbox-controls">
                <!-- Check all button -->
                
                <!-- /.btn-group -->
                
                <div class="float-right">
                
                  <div class="btn-group">
                    
                  </div>
                  <!-- /.btn-group -->
                </div>
                <!-- /.float-right -->
              </div>
              <div class="table-responsive mailbox-messages" id="mailbox">
                <table class="table table-hover table-striped">
                  <tbody>
                  <?php while($messages_data = $get_all_messages1_data->fetch(PDO::FETCH_ASSOC)){ ?>
                  <tr>
                    <td><input type="checkbox"></td>
                    <td class="mailbox-star"><a href="#"><i class="fa fa-star text-warning"></i></a></td>
                    <td class="mailbox-name"><a href="read-mail.php?objid=<?php echo $messages_data['objid'];?>"><?php echo $messages_data['sender'];?></a></td>
                    <td class="mailbox-subject"><?php echo $messages_data['subject'];?>
                    </td>
                    <td class="mailbox-attachment"></td>
                    <td class="mailbox-date"><?php echo $messages_data['date'];?></td>
                  </tr>
                 
                  <?php } ?>
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer p-0">
              <div class="mailbox-controls">
                <!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                </div>
                <!-- /.btn-group -->
                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                <div class="float-right">
                  1-50/200
                  <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                  </div>
                  <!-- /.btn-group -->
                </div>
                <!-- /.float-right -->
              </div>
            </div>
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
           
  
  <!-- Main Sidebar Container -->
    </section>

  <!-- Content Wrapper. Contains page content -->
 
      <!-- /.row -->
   
    <!-- /.content -->

    
   
    <!-- modals here -->
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
          <!-- /.modal-dialog -->
        
        <!-- /.modal -->



  </div>
  <?php include ('includes/footer.php');?>
  </div>
  
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
  <div class="modal-header">
                <h4 class="modal-title">TRACK DOCUMENT</h4>
              </div>
          
                <div class="modal-body">  
                  <div class="box-body">
                    <div class="form-group">
                    <h6 class="modal-title">Please scan/enter barcode:</h6>
                    <input type="text" name="scan_track" id="scan_track" class="form-control">
                    </div>

                    <div class="form-group">
                    <label>Date:</label>
                    <label id="lblDate"></label>
                    </div>
                    <div class="form-group">
                    <label>Time:</label>
                    <label id="lblTime"></label>
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
                    <div class="form-group">
                    <label>Destination:</label>
                    <label id="lblDestination"></label>
                    </div>
                    <div class="form-group">
                    <label>Remarks:</label>
                    <label id="lblRemarks"></label>
                    </div>

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

<script>
  

$('#scan_track').on('change',function(){
  
  // function receive(){
             var docno = document.getElementById("scan_track").value;
           
            //  alert (docno);
         
            $.ajax({
              type:'POST',
              data:{docno:docno},
              url:'scan_track.php',
               success:function(data){
                var result = $.parseJSON(data);
                // alert(result.type)
                 document.getElementById('lblDate').innerHTML = result.date;
                 document.getElementById('lblTime').innerHTML = result.time;
                 document.getElementById('lblType').innerHTML = result.type;
                 document.getElementById('lblParticulars').innerHTML = result.particulars;
                 document.getElementById('lblOrigin').innerHTML = result.origin;
                 document.getElementById('lblDestination').innerHTML = result.destination;
                 document.getElementById('lblRemarks').innerHTML = result.remarks;
                 document.getElementById('lblMessage').innerHTML = result.message;

               }
            
                });   
              
                document.getElementById('scan_track').focus();
                document.getElementById('scan_track').select();
               
                //
              
              
    });
          
              
  

</script>
